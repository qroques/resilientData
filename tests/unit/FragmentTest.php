<?php

declare(strict_types=1);

namespace tests\unit\Qroques\ResilientData;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Qroques\ResilientData\DataChunk;
use Qroques\ResilientData\DataChunkIdentifier;
use Qroques\ResilientData\Fragment;
use Qroques\ResilientData\FragmentIdentifier;
use Qroques\ResilientData\Hash;
use Qroques\ResilientData\Manifest;
use Qroques\ResilientData\SplittingConfiguration;

/**
 * @internal
 */
#[CoversClass(Fragment::class)]
class FragmentTest extends TestCase
{
    public function testHasDataChunk(): void
    {
        $fragment = new Fragment(new FragmentIdentifier(3), new Manifest(Hash::fromContent('12345'), new SplittingConfiguration(5, 2)));
        $fragment->addDataChunk(new DataChunk(new DataChunkIdentifier(0b1010), 'data'));
        $this->assertTrue($fragment->hasDataChunk(new DataChunkIdentifier(0b1010)));
        $this->assertFalse($fragment->hasDataChunk(new DataChunkIdentifier(0b1000)));
    }

    public function testGetDataChunk(): void
    {
        $fragment = new Fragment(new FragmentIdentifier(3), new Manifest(Hash::fromContent('12345'), new SplittingConfiguration(5, 2)));
        $fragment->addDataChunk(new DataChunk(new DataChunkIdentifier(0b1010), 'data'));
        $this->assertEquals(new DataChunk(new DataChunkIdentifier(0b1010), 'data'), $fragment->getDataChunk(new DataChunkIdentifier(0b1010)));

        $this->expectException(\RuntimeException::class);
        $fragment->getDataChunk(new DataChunkIdentifier(0b1110));
    }
}
