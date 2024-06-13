<?php

declare(strict_types=1);

namespace Qroques\ResilientData\Exception;

class NumberOfFragmentsTooLowException extends \InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('The number of fragments must be greater than 1');
    }
}
