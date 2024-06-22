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
        /** @var Collection<Fragment> */
        $fragmentCollection = new Collection($fragments);
        if (0 === $fragmentCollection->count()) {
            throw new \InvalidArgumentException('No fragments to assemble');
        }

        $manifest = $fragments[0]->manifest;

        if ($fragmentCollection->count() < $manifest->splittingConfiguration->getMinimumNumberOfFragments()) {
            throw new NotEnoughFragmentsException($fragmentCollection->count(), $manifest->splittingConfiguration->getMinimumNumberOfFragments());
        }

        $data = '';
        foreach ($manifest->splittingConfiguration->getDataChunkIdentifiers() as $i) {
            foreach ($fragments as $fragment) {
                if ($fragment->hasDataChunk($i)) {
                    $data .= $fragment->getDataChunk($i)->data;

                    continue 2;
                }
            }
        }

        $resilientData = ResilientData::fromBinaryData($data, $manifest->originalType, $manifest->originalName);

        if (!$resilientData->getHash()->equals($manifest->resilientDataHash)) {
            throw new HashMismatchException($resilientData->getHash(), $manifest->resilientDataHash);
        }

        return $resilientData;
    }
}
