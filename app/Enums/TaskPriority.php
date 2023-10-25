<?php

namespace App\Enums;

use App\Traits\EnumCases;

enum TaskPriority: int
{
    use EnumCases;

    case Low = 1;
    case Normal = 2;
    case High = 3;
}
