<?php

declare(strict_types=1);

namespace tests\unit\Qroques\ResilientData;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Qroques\ResilientData\ResilientData;
use Qroques\ResilientData\Splitter;
use Qroques\ResilientData\SplittingConfiguration;

/**
 * @internal
 */
#[CoversClass(Splitter::class)]
class SplitterTest extends TestCase
{
    public function testSplit(): void
    {
        $splitter = new Splitter();
        $resilientData = ResilientData::fromPlainText('Lorem ipsum dolor sit amet, consectetur adipiscing elit.');
        $fragments = iterator_to_array($splitter->split($resilientData, new SplittingConfiguration(5, 2)));

        $this->assertCount(5, $fragments);
    }
}
