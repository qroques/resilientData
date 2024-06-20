<?php

declare(strict_types=1);

namespace tests\Qroques\ResilientData;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\TestCase;
use Qroques\ResilientData\Assembler;
use Qroques\ResilientData\ResilientData;
use Qroques\ResilientData\Splitter;
use Qroques\ResilientData\SplittingConfiguration;

/**
 * @internal
 */
#[CoversNothing]
class SplitThenMergeTest extends TestCase
{
    public function testSplitThenMergeTextFile()
    {
        $data = file_get_contents('tests/fixtures/lorem.txt');
        $resilientData = ResilientData::fromFile('tests/fixtures/lorem.txt');
        $splittingConfiguration = new SplittingConfiguration(7, 3);
        $splitter = new Splitter();
        $fragments = $splitter->split($resilientData, $splittingConfiguration);

        $assembler = new Assembler();
        $reassembledResilientData = $assembler->assemble($fragments);
        $this->assertEquals($data, $reassembledResilientData->getData());
    }

    public function testSplitThenMergeImageFile()
    {
        $data = file_get_contents('tests/fixtures/image.png');
        $resilientData = ResilientData::fromFile('tests/fixtures/image.png');
        $splittingConfiguration = new SplittingConfiguration(7, 3);
        $splitter = new Splitter();
        $fragments = $splitter->split($resilientData, $splittingConfiguration);

        $assembler = new Assembler();
        $reassembledResilientData = $assembler->assemble($fragments);
        $this->assertEquals($data, $reassembledResilientData->getData());
    }

    public function testSplitThenMergeText()
    {
        $resilientData = ResilientData::fromString('Lorem ipsum dolor sit amet, consectetur adipiscing elit.');
        $splittingConfiguration = new SplittingConfiguration(7, 3);
        $splitter = new Splitter();
        $fragments = $splitter->split($resilientData, $splittingConfiguration);

        $assembler = new Assembler();
        $reassembledResilientData = $assembler->assemble($fragments);
        $this->assertEquals('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', $reassembledResilientData->getData());
    }
}
