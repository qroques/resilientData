<?php

declare(strict_types=1);

namespace Qroques\ResilientData;

readonly class Hash implements \Stringable
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
}
