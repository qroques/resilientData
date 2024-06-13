<?php

declare(strict_types=1);

namespace Qroques\ResilientData\Exception;

use Qroques\ResilientData\Hash;

class HashMismatchException extends \RuntimeException
{
    public function __construct(
        Hash $manifestHash,
        Hash $computedHash
    ) {
        parent::__construct(sprintf('The hash of the data does not match the hash of the manifest (%s != %s)', $manifestHash, $computedHash));
    }
}
