<?php

declare(strict_types=1);

namespace Qroques\ResilientData;

interface SplitterInterface
{
    /**
     * @return array<Fragment>
     */
    public function split(
        ResilientData $resilientData,
        SplittingConfiguration $splittingConfiguration
    ): array;
}
