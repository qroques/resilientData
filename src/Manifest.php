<?php

declare(strict_types=1);

namespace Qroques\ResilientData;

readonly class Manifest
{
    public function __construct(
        public Hash $resilientDataHash,
        public int $totalNumberOfChunks,
        public SplittingConfiguration $splittingConfiguration
    ) {}
}
