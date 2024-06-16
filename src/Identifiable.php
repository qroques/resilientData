<?php

declare(strict_types=1);

namespace Qroques\ResilientData;

/**
 * @template T of Identifier
 */
interface Identifiable
{
    /**
     * @return T
     */
    public function getIdentifier(): Identifier;
}
