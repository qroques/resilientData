<?php

declare(strict_types=1);

namespace Qroques\ResilientData;

class Splitter
{
    /**
     * @return Collection<Fragment>
     */
    public function split(
        ResilientData $resilientData,
        SplittingConfiguration $splittingConfiguration
    ): iterable {
        /** @var Collection<Fragment> */
        $fragments = new Collection();
        $manifest = new Manifest($resilientData->getHash(), $splittingConfiguration);
        $chunkSize = (int) ceil(strlen($resilientData->getBinaryData()) / $splittingConfiguration->getNumberOfChunks());

        if ($chunkSize <= 1) {
            throw new \RuntimeException('The chunk size is too small to split the data');
        }

        $dataChunkIdentifiers = $splittingConfiguration->getDataChunkIdentifiers();
        $data = str_split($resilientData->getBinaryData(), $chunkSize);

        for ($index = 0; $index < $splittingConfiguration->numberOfFragments; ++$index) {
            $fragments->add(new Fragment(new FragmentIdentifier($index), $manifest));
        }

        foreach ($data as $index => $chunk) {
            $dataChunk = new DataChunk($dataChunkIdentifiers[$index], $chunk);

            foreach ($dataChunk->identifier->getRelatedFragmentIdentifiers() as $fragmentIdentifier) {
                $fragments->get($fragmentIdentifier)->addDataChunk($dataChunk);
            }
        }

        return $fragments;
    }
}
