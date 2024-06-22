<?php

declare(strict_types=1);

namespace Qroques\ResilientData;

/**
 * @implements Comparable<Hash>
 */
readonly class Hash implements \Stringable, Comparable
{
    public function __construct(public string $hash) {}

    public function __toString(): string
    {
        return $this->hash;
    }

    public static function fromContent(string $content): self
    {
        return new self(hash('sha256', $content));
    }

    public function equals(Comparable $other): bool
    {
        return $this->hash === $other->getValue();
    }

    public function getValue(): string
    {
        return $this->hash;
    }
}
