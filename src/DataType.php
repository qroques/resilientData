<?php

declare(strict_types=1);

namespace Qroques\ResilientData;

enum DataType: string
{
    case TEXT = 'plain';
    case IMAGE = 'image';
    case FILE = 'file';
    case BINARY = 'binary';
}
