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
     * @return array<int>
     */
    public function getRepartitionKeys(): array
    {
        $matches = [];
        for ($i = 0; $i < 2 ** $this->numberOfFragments; ++$i) {
            $binary = str_pad(base_convert((string) $i, 10, 2), $this->numberOfFragments, '0', STR_PAD_LEFT);

            $numberOfOnes = substr_count($binary, '1');

            $matches[$numberOfOnes][] = (int) base_convert((string) $binary, 2, 10);
        }

        return $matches[$this->acceptableLoss + 1];
    }

    public function getNumberOfChunks(): int
    {
        return count($this->getRepartitionKeys());
    }
}
