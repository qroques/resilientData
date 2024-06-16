<?php

declare(strict_types=1);

namespace tests\Qroques\ResilientData;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Qroques\ResilientData\DataChunkIdentifier;
use Qroques\ResilientData\FragmentIdentifier;

/**
 * @internal
 */
#[CoversClass(DataChunkIdentifier::class)]
class DataChunkIdentifierTest extends TestCase
{
    public function testContains(): void
    {
        $identifier = new DataChunkIdentifier(0b1010);
        $this->assertTrue($identifier->contains(3));
        $this->assertFalse($identifier->contains(2));
    }

    public function testEquals(): void
    {
        $identifier = new DataChunkIdentifier(0b1010);
        $this->assertTrue($identifier->equals(new DataChunkIdentifier(0b1010)));
        $this->assertFalse($identifier->equals(new DataChunkIdentifier(0b1000)));
    }

    public function testGetRelatedFragmentIdentifiers(): void
    {
        $identifier = new DataChunkIdentifier(0b11001);
        $this->assertEquals([
            new FragmentIdentifier(0),
            new FragmentIdentifier(3),
            new FragmentIdentifier(4),
        ], $identifier->getRelatedFragmentIdentifiers());
    }
}
