<?php

declare(strict_types=1);

namespace Qroques\ResilientData;

class Splitter implements SplitterInterface
{
    public function split(
        ResilientData $resilientData,
        SplittingConfiguration $splittingConfiguration
    ): array {
        $fragments = [];
        $numberOfChunks = $splittingConfiguration->getNumberOfChunks();
        $manifest = new Manifest($resilientData->getHash(), $numberOfChunks, $splittingConfiguration);
        $chunkSize = (int) ceil(strlen($resilientData->getBinaryData()) / $numberOfChunks);

        if ($chunkSize <= 1) {
            throw new \RuntimeException('The chunk size is too small to split the data');
        }

        $chunkRepartitionKeys = $splittingConfiguration->getRepartitionKeys();
        $data = str_split($resilientData->getBinaryData(), $chunkSize);

        for ($index = 0; $index < $splittingConfiguration->numberOfFragments; ++$index) {
            $fragments[] = new Fragment($index, $manifest);
        }

        foreach ($data as $index => $chunk) {
            $dataChunk = new DataChunk($chunkRepartitionKeys[$index], $chunk);

            foreach ($fragments as $fragment) {
                if ($dataChunk->index & (2 ** $fragment->index)) {
                    $fragment->addChunk($dataChunk);
                }
            }
        }

        return $fragments;
    }
}
