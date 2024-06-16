<?php

declare(strict_types=1);

namespace tests\unit\Qroques\ResilientData;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Qroques\ResilientData\FragmentIdentifier;

/**
 * @internal
 */
#[CoversClass(FragmentIdentifier::class)]
class FragmentIdentifierTest extends TestCase
{
    public function testEquals(): void
    {
        $identifier = new FragmentIdentifier(0b1010);
        $this->assertTrue($identifier->equals(new FragmentIdentifier(0b1010)));
        $this->assertFalse($identifier->equals(new FragmentIdentifier(0b1000)));
    }

    public function testGetValue(): void
    {
        $identifier = new FragmentIdentifier(0b1010);
        $this->assertSame(0b1010, $identifier->getValue());
    }
}
