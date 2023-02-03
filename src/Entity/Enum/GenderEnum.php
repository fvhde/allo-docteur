<?php

declare(strict_types=1);

namespace App\Entity\Enum;

enum GenderEnum: string
{
    use EnumToArray;
    case MALE = 'male';
    case FEMALE = 'female';
    case UNDEFINED = 'undefined';
}
