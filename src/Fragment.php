<?php

declare(strict_types=1);

namespace Qroques\ResilientData;

class Fragment
{
    /**
     * @param array<DataChunk> $dataChunks
     */
    public function __construct(
        public readonly int $index,
        public readonly Manifest $manifest,
        private array $dataChunks = []
    ) {}

    public function addChunk(DataChunk $dataChunk): void
    {
        $this->dataChunks[$dataChunk->index] = $dataChunk;
    }

    public function hasChunk(int $index): bool
    {
        return (bool) ($this->dataChunks[$index] ?? false);
    }

    public function getDataChunk(int $index): DataChunk
    {
        return $this->dataChunks[$index] ?? throw new \InvalidArgumentException('Chunk not found');
    }

    /**
     * @return array<int>
     */
    public function getDataChunkIndexes(): array
    {
        return array_keys($this->dataChunks);
    }
}
