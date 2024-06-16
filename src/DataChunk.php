<?php

declare(strict_types=1);

namespace Qroques\ResilientData;

/**
 * @implements Identifiable<DataChunkIdentifier>
 */
readonly class DataChunk implements Identifiable
{
    public function __construct(
        public DataChunkIdentifier $identifier,
        public string $data
    ) {}

    public function getIdentifier(): DataChunkIdentifier
    {
        return $this->identifier;
    }
}
