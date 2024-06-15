<?php

declare(strict_types=1);

namespace Qroques\ResilientData;

use Qroques\ResilientData\Exception\HashMismatchException;
use Qroques\ResilientData\Exception\NotEnoughFragmentsException;

class Assembler
{
    /**
     * @param array<Fragment> $fragments
     */
    public function assemble(array $fragments): ResilientData
    {
        if (0 === count($fragments)) {
            throw new \InvalidArgumentException('No fragments to assemble');
        }

        $manifest = $fragments[0]->manifest;

        if (count($fragments) < $manifest->splittingConfiguration->getMinimumNumberOfFragments()) {
            throw new NotEnoughFragmentsException(count($fragments), $manifest->splittingConfiguration->getMinimumNumberOfFragments());
        }

        $data = '';
        foreach ($manifest->splittingConfiguration->getRepartitionKeys() as $i) {
            foreach ($fragments as $fragment) {
                if ($fragment->hasChunk($i)) {
                    $data .= $fragment->getDataChunk($i)->data;

                    continue 2;
                }
            }
        }
        $resilientData = ResilientData::fromBinaryData($data);

        if ($resilientData->getHash() !== $manifest->resilientDataHash) {
            throw new HashMismatchException($resilientData->getHash(), $manifest->resilientDataHash);
        }

        return $resilientData;
    }
}
