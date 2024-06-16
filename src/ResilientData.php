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
        $stringData = json_encode($this->data);

        if (false === $stringData) {
            throw new \RuntimeException('Failed to encode data to JSON: '.json_last_error_msg());
        }

        return base64_encode($stringData);
    }

    public static function fromBinaryData(string $data): self
    {
        return new self(json_decode(base64_decode($data)));
    }
}
