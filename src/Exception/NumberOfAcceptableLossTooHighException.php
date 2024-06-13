<?php

declare(strict_types=1);

namespace Qroques\ResilientData\Exception;

class NumberOfAcceptableLossTooHighException extends \InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('The number of acceptable loss must be between 0 and the number of fragments');
    }
}
