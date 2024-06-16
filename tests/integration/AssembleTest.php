<?php

declare(strict_types=1);

namespace tests\Qroques\ResilientData;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Qroques\ResilientData\Assembler;

/**
 * @internal
 */
#[CoversNothing]
class AssembleTest extends TestCase
{
    #[DataProvider('fragmentProvider')]
    public function testAssemble(
        array $fragments,
        string $expectedData
    ) {
        $assembler = new Assembler();
        $resilientData = $assembler->assemble($fragments);
        $this->assertEquals($expectedData, $resilientData->getData());
    }

    public static function fragmentProvider(): array
    {
        $fragmentFiles = glob('tests/fixtures/fragments/fragment_*.txt');
        $fragments = array_map(
            fn (string $file) => unserialize(file_get_contents($file)),
            $fragmentFiles
        );

        $expectedData = file_get_contents('tests/fixtures/lorem.txt');

        return [
            'all fragments' => [$fragments, $expectedData],
            'with fragments 0 1 2' => [[$fragments[0], $fragments[1], $fragments[2]], $expectedData],
            'with fragments 0 1 3' => [[$fragments[0], $fragments[1], $fragments[3]], $expectedData],
            'with fragments 0 2 3' => [[$fragments[0], $fragments[2], $fragments[3]], $expectedData],
            'with fragments 1 2 3' => [[$fragments[1], $fragments[2], $fragments[3]], $expectedData],
            'with fragments 0 1 4' => [[$fragments[0], $fragments[1], $fragments[4]], $expectedData],
            'with fragments 0 2 4' => [[$fragments[0], $fragments[2], $fragments[4]], $expectedData],
            'with fragments 1 2 4' => [[$fragments[1], $fragments[2], $fragments[4]], $expectedData],
            'with fragments 0 3 4' => [[$fragments[0], $fragments[3], $fragments[4]], $expectedData],
            'with fragments 1 3 4' => [[$fragments[1], $fragments[3], $fragments[4]], $expectedData],
            'with fragments 2 3 4' => [[$fragments[2], $fragments[3], $fragments[4]], $expectedData],
        ];
    }
}
