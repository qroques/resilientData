<?php

declare(strict_types=1);

namespace tests\unit\Qroques\ResilientData;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Qroques\ResilientData\Collection;
use Qroques\ResilientData\Fragment;
use Qroques\ResilientData\FragmentIdentifier;
use Qroques\ResilientData\Hash;
use Qroques\ResilientData\Manifest;
use Qroques\ResilientData\SplittingConfiguration;

/**
 * @internal
 */
#[CoversClass(Collection::class)]
class CollectionTest extends TestCase
{
    public function testAddContains(): void
    {
        $collection = new Collection();
        $collection->add(new Fragment(new FragmentIdentifier(0), new Manifest(Hash::fromContent('12345'), new SplittingConfiguration(5, 2))));
        $this->assertTrue($collection->contains(new FragmentIdentifier(0)));
    }

    public function testGetFragment(): void
    {
        $fragment = new Fragment(new FragmentIdentifier(0), new Manifest(Hash::fromContent('12345'), new SplittingConfiguration(5, 2)));
        $collection = new Collection([$fragment]);

        $this->assertEquals($fragment, $collection->get(new FragmentIdentifier(0)));

        $this->expectException(\RuntimeException::class);
        $collection->get(new FragmentIdentifier(1));
    }
}
