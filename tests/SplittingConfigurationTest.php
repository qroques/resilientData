<?php

declare(strict_types=1);

namespace tests\Qroques\ResilientData;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Qroques\ResilientData\SplittingConfiguration;

#[CoversClass(SplittingConfiguration::class)]
class SplittingConfigurationTest extends TestCase
{
    public function testSplittingConfiguration(): void
    {
        $splittingConfiguration = new SplittingConfiguration(5, 2);
        $this->assertSame(3, $splittingConfiguration->getMinimumNumberOfFragments());
        $this->assertEquals([7, 11, 13, 14, 19, 21, 22, 25, 26, 28], $splittingConfiguration->getRepartitionKeys());
    }
}
