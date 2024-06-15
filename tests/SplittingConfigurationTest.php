<?php

declare(strict_types=1);

namespace tests\Qroques\ResilientData;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
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
        $this->assertEquals([0b111, 0b1011, 0b1101, 0b1110, 0b10011, 0b10101, 0b10110, 0b11001, 0b11010, 0b11100], $splittingConfiguration->getRepartitionKeys());
    }
}
