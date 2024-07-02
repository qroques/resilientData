<?php

declare(strict_types=1);

namespace Qroques\ResilientData;

class ResilientData
{
    private function __construct(
        private readonly string $data,
        public readonly ?string $originalType = null,
        public readonly ?string $originalName = null
    ) {}

    public static function fromFile(
        string $filename,
        ?string $originalName = null
    ): self {
        $data = file_get_contents($filename);
        $type = mime_content_type($filename);

        if (false === $data) {
            throw new \RuntimeException('Could not read the file');
        }

        if (false === $type) {
            throw new \RuntimeException('Could not determine the mime type');
        }

        return new self($data, $type, basename($originalName ?? $filename));
    }

    public static function fromPlainText(string $data): self
    {
        return new self($data, 'text/plain');
    }

    public static function fromBinaryData(
        string $binaryData,
        ?string $originalType = null,
        ?string $originalName = null
    ): self {
        return new self(base64_decode($binaryData), $originalType, $originalName);
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
}
