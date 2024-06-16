<?php

declare(strict_types=1);

namespace Qroques\ResilientData;

use IteratorAggregate;

/**
 * @template T of Identifiable
 *
 * @implements IteratorAggregate<T>
 */
class Collection implements \IteratorAggregate, \Countable
{
    /**
     * @param array<T> $items
     */
    public function __construct(public array $items = []) {}

    /**
     * @param T $item
     */
    public function add(Identifiable $item): void
    {
        $this->items[] = $item;
    }

    /**
     * @param Identifier<T> $identifier
     */
    public function contains(Identifier $identifier): bool
    {
        foreach ($this->items as $item) {
            if ($item->getIdentifier()->equals($identifier)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param Identifier<T> $identifier
     *
     * @return T
     */
    public function get(Identifier $identifier): Identifiable
    {
        foreach ($this->items as $item) {
            if ($item->getIdentifier()->equals($identifier)) {
                return $item;
            }
        }

        throw new \RuntimeException('Item not found');
    }

    /**
     * @return \ArrayIterator<int, T>
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->items);
    }

    public function count(): int
    {
        return count($this->items);
    }
}
