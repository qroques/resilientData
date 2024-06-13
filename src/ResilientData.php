<?php

declare(strict_types=1);

namespace Qroques\ResilientData;

class ResilientData
{
    public function __construct(private readonly mixed $data) {}

    public function getData(): mixed
    {
        return $this->data;
    }

    public function getHash(): Hash
    {
        return Hash::fromContent($this->getBinaryData());
    }

    public function getBinaryData(): string
    {
        return base64_encode(serialize($this->data));
    }

    public static function fromBinaryData(string $data): self
    {
        return new self(unserialize(base64_decode($data)));
    }
}
