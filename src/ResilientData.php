<?php

declare(strict_types=1);

namespace Qroques\ResilientData;

class ResilientData
{
    private function __construct(private readonly string $data) {}

    public static function fromFile(string $filename): self
    {
        $data = file_get_contents($filename);

        if (false === $data) {
            throw new \RuntimeException('Could not read the file');
        }

        return new self($data);
    }

    public static function fromString(string $data): self
    {
        return new self($data);
    }

    public function getData(): string
    {
        return $this->data;
    }

    public function getHash(): Hash
    {
        return Hash::fromContent($this->getBinaryData());
    }

    public function getBinaryData(): string
    {
        return base64_encode($this->data);
    }

    public static function fromBinaryData(string $binaryData): self
    {
        return new self(base64_decode($binaryData));
    }
}
