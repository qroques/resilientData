<?php

declare(strict_types=1);

namespace Qroques\ResilientData;

use Qroques\ResilientData\Exception\NumberOfAcceptableLossTooHighException;
use Qroques\ResilientData\Exception\NumberOfFragmentsTooLowException;

readonly class SplittingConfiguration
{
    public function __construct(
        public int $numberOfFragments,
        public int $acceptableLoss
    ) {
        if ($numberOfFragments < 2) {
            throw new NumberOfFragmentsTooLowException();
        }

        if ($acceptableLoss < 0 || $acceptableLoss >= $numberOfFragments) {
            throw new NumberOfAcceptableLossTooHighException();
        }
    }

    public function getMinimumNumberOfFragments(): int
    {
        return $this->numberOfFragments - $this->acceptableLoss;
    }

    /**
     * @return array<DataChunkIdentifier>
     */
    public function getDataChunkIdentifiers(): array
    {
        $matches = [];

        for ($i = 0; $i < 2 ** $this->numberOfFragments; ++$i) {
            if (substr_count(decbin($i), '1') === $this->acceptableLoss + 1) {
                $matches[] = new DataChunkIdentifier($i);
            }
        }

        return $matches;
    }

    public function getNumberOfChunks(): int
    {
        return count($this->getDataChunkIdentifiers());
    }
}
