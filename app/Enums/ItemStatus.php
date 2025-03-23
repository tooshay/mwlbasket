<?php

namespace App\Enums;

enum ItemStatus: string
{
    case ADDED = "added";

    case REMOVED = "removed";

    case PURCHASED = "purchased";
}
