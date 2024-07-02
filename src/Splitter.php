<?php

declare(strict_types=1);

namespace Qroques\ResilientData;

class Splitter
{
    /**
     * @return \Generator<Fragment>
     */
    public function split(
        ResilientData $resilientData,
        SplittingConfiguration $splittingConfiguration
    ): \Generator {
        $manifest = new Manifest($resilientData->getHash(), $splittingConfiguration, $resilientData->originalType, $resilientData->originalName);
        $chunkSize = (int) ceil(strlen($resilientData->getBinaryData()) / $splittingConfiguration->getNumberOfChunks());

        if ($chunkSize <= 1) {
            throw new \RuntimeException('The chunk size is too small to split the data');
        }

        $dataChunkIdentifiers = $splittingConfiguration->getDataChunkIdentifiers();
        $data = mb_str_split($resilientData->getBinaryData(), $chunkSize);

        for ($index = 0; $index < $splittingConfiguration->numberOfFragments; ++$index) {
            $fragment = new Fragment(new FragmentIdentifier($index), $manifest);

            array_map(
                function ($index, $chunk) use ($fragment, $dataChunkIdentifiers) {
                    if (\in_array($fragment->getIdentifier(), $dataChunkIdentifiers[$index]->getRelatedFragmentIdentifiers())) {
                        $dataChunk = new DataChunk($dataChunkIdentifiers[$index], $chunk);
                        $fragment->addDataChunk($dataChunk);
                    }
                },
                array_keys($data),
                array_values($data)
            );

            yield $fragment;
        }
    }
}
