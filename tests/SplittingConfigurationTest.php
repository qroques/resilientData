<?php

declare(strict_types=1);

namespace tests\Qroques\ResilientData;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Qroques\ResilientData\DataChunkIdentifier;
use Qroques\ResilientData\SplittingConfiguration;

/**
 * @internal
 */
#[CoversClass(SplittingConfiguration::class)]
class SplittingConfigurationTest extends TestCase
{
    public function testSplittingConfiguration(): void
    {
        $splittingConfiguration = new SplittingConfiguration(5, 2);
        $this->assertSame(3, $splittingConfiguration->getMinimumNumberOfFragments());
        $this->assertEquals([
            new DataChunkIdentifier(0b111),
            new DataChunkIdentifier(0b1011),
            new DataChunkIdentifier(0b1101),
            new DataChunkIdentifier(0b1110),
            new DataChunkIdentifier(0b10011),
            new DataChunkIdentifier(0b10101),
            new DataChunkIdentifier(0b10110),
            new DataChunkIdentifier(0b11001),
            new DataChunkIdentifier(0b11010),
            new DataChunkIdentifier(0b11100),
        ], $splittingConfiguration->getDataChunkIdentifiers());
    }
}
