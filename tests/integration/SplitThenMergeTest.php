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
    public function testSplitThenMerge()
    {
        $data = file_get_contents('tests/fixtures/lorem.txt');
        $resilientData = new ResilientData($data);
        $splittingConfiguration = new SplittingConfiguration(7, 3);
        $splitter = new Splitter();
        $fragments = $splitter->split($resilientData, $splittingConfiguration);

        $assembler = new Assembler();
        $reassembledResilientData = $assembler->assemble($fragments);
        $this->assertEquals($data, $reassembledResilientData->getData());
    }
}
