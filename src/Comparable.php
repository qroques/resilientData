<?php

declare(strict_types=1);

namespace Qroques\ResilientData;

/**
 * @template T of Comparable
 */
interface Comparable
{
    /**
     * @param Comparable<T> $other
     */
    public function equals(Comparable $other): bool;

    /** @return int|string */
    public function getValue(): mixed;
}
