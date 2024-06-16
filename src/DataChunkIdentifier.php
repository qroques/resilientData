<?php

declare(strict_types=1);

namespace Qroques\ResilientData;

/**
 * @extends Identifier<DataChunk>
 *
 * @template-extends Identifier<DataChunk>
 */
readonly class DataChunkIdentifier extends Identifier
{
    public function contains(int $powerOfTwo): bool
    {
        return ($this->value & 2 ** $powerOfTwo) === 2 ** $powerOfTwo;
    }

    /**
     * @return array<FragmentIdentifier>
     */
    public function getRelatedFragmentIdentifiers(): array
    {
        $fragmentIdentifiers = [];
        $i = 1;

        while ($i <= $this->value) {
            if ($i & $this->value) {
                $fragmentIdentifiers[] = new FragmentIdentifier((int) log($i, 2));
            }

            $i <<= 1;
        }

        return $fragmentIdentifiers;
    }

    public function getIdentifiableClassName(): string
    {
        return DataChunk::class;
    }
}
