<?php

declare(strict_types=1);

namespace Qroques\ResilientData;

/**
 * @implements Identifiable<FragmentIdentifier>
 */
class Fragment implements Identifiable
{
    /** @var Collection<DataChunk> */
    private Collection $dataChunks;

    /**
     * @param array<DataChunk> $dataChunks
     */
    public function __construct(
        public readonly FragmentIdentifier $identifier,
        public readonly Manifest $manifest,
        array $dataChunks = []
    ) {
        $this->dataChunks = new Collection($dataChunks);
    }

    public function getIdentifier(): FragmentIdentifier
    {
        return $this->identifier;
    }

    public function addDataChunk(DataChunk $dataChunk): void
    {
        $this->dataChunks->add($dataChunk);
    }

    public function hasDataChunk(DataChunkIdentifier $identifier): bool
    {
        return $this->dataChunks->contains($identifier);
    }

    public function getDataChunk(DataChunkIdentifier $identifier): DataChunk
    {
        return $this->dataChunks->get($identifier);
    }

    /** @return Collection<DataChunk> */
    public function getDataChunks(): Collection
    {
        return $this->dataChunks;
    }
}
