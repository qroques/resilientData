<?php

declare(strict_types=1);

namespace Qroques\ResilientData;

/**
 * @template T of Identifiable
 *
 * @implements Comparable<Identifier>
 */
abstract readonly class Identifier implements Comparable
{
    public function __construct(public int $value) {}

    /**
     * @param Identifier<T> $other
     */
    public function equals(Comparable $other): bool
    {
        return $this->value === $other->getValue();
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
