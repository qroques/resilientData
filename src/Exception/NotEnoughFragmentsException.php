<?php

declare(strict_types=1);

namespace Qroques\ResilientData\Exception;

class NotEnoughFragmentsException extends \InvalidArgumentException
{
    public function __construct(
        int $fragmentsCount,
        int $minimumFragmentsCount
    ) {
        parent::__construct(sprintf('Not enough fragments to recover the data (%d < %d)', $fragmentsCount, $minimumFragmentsCount));
    }
}
