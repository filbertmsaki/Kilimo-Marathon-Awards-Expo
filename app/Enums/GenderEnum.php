<?php

namespace App\Enums;

use App\Attributes\Description;
use App\Models\Traits\AttributableEnum;

enum GenderEnum: string
{
    use AttributableEnum;

    #[Description('Male')]
    case Male = 'M';

    #[Description('Female')]
    case Female  = 'F';
    #[Description('Other')]
    case Other  = 'O';
}
