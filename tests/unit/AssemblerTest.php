<?php

declare(strict_types=1);

namespace tests\unit\Qroques\ResilientData;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Qroques\ResilientData\Assembler;
use Qroques\ResilientData\DataChunk;
use Qroques\ResilientData\DataChunkIdentifier;
use Qroques\ResilientData\Exception\NotEnoughFragmentsException;
use Qroques\ResilientData\Fragment;
use Qroques\ResilientData\FragmentIdentifier;
use Qroques\ResilientData\Hash;
use Qroques\ResilientData\Manifest;
use Qroques\ResilientData\SplittingConfiguration;

/**
 * @internal
 */
#[CoversClass(Assembler::class)]
class AssemblerTest extends TestCase
{
    public function testAssemble(): void
    {
        $assembler = new Assembler();
        $chunk3 = new DataChunk(new DataChunkIdentifier(3), 'VGhpcyB');
        $chunk5 = new DataChunk(new DataChunkIdentifier(5), 'pcyBhIG');
        $chunk6 = new DataChunk(new DataChunkIdentifier(6), 'RhdGEh');
        $manifest = new Manifest(Hash::fromContent(base64_encode('This is a data!')), new SplittingConfiguration(3, 1));

        $fragment0 = new Fragment(new FragmentIdentifier(0), $manifest, [$chunk3, $chunk5]);
        $fragment1 = new Fragment(new FragmentIdentifier(1), $manifest, [$chunk3, $chunk6]);
        $fragment2 = new Fragment(new FragmentIdentifier(2), $manifest, [$chunk5, $chunk6]);

        $resilientData = $assembler->assemble([$fragment0, $fragment1, $fragment2]);
        $this->assertEquals('This is a data!', $resilientData->getData());

        $resilientData = $assembler->assemble([$fragment0, $fragment1]);
        $this->assertEquals('This is a data!', $resilientData->getData());

        $resilientData = $assembler->assemble([$fragment0, $fragment2]);
        $this->assertEquals('This is a data!', $resilientData->getData());

        $resilientData = $assembler->assemble([$fragment1, $fragment2]);
        $this->assertEquals('This is a data!', $resilientData->getData());
    }

    public function testAssembleWithMissingData(): void
    {
        $assembler = new Assembler();
        $chunk3 = new DataChunk(new DataChunkIdentifier(3), 'VGhpcyB');
        $chunk5 = new DataChunk(new DataChunkIdentifier(5), 'pcyBhIG');
        $chunk6 = new DataChunk(new DataChunkIdentifier(6), 'RhdGEh');
        $manifest = new Manifest(Hash::fromContent(base64_encode(json_encode('This is a data!'))), new SplittingConfiguration(3, 1));

        $fragment0 = new Fragment(new FragmentIdentifier(0), $manifest, [$chunk3, $chunk5]);
        $fragment1 = new Fragment(new FragmentIdentifier(1), $manifest, [$chunk3, $chunk6]);
        $fragment2 = new Fragment(new FragmentIdentifier(2), $manifest, [$chunk5, $chunk6]);

        $this->expectException(NotEnoughFragmentsException::class);
        $assembler->assemble([$fragment0]);

        $this->expectException(NotEnoughFragmentsException::class);
        $assembler->assemble([$fragment1]);

        $this->expectException(NotEnoughFragmentsException::class);
        $assembler->assemble([$fragment2]);

        $this->expectException(\InvalidArgumentException::class);
        $assembler->assemble([]);
    }
}
