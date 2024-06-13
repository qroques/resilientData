<?php

declare(strict_types=1);

namespace Qroques\ResilientData;

readonly class DataChunk
{
    public function __construct(
        public int $index,
        public string $data
    ) {}
}
