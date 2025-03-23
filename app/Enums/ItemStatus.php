<?php

declare(strict_types=1);

namespace App\Enums;

enum ItemStatus: string
{
    case ADDED = 'added';

    case REMOVED = 'removed';

    case PURCHASED = 'purchased';
}
