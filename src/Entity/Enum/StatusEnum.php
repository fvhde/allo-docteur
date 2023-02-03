<?php

declare(strict_types=1);

namespace App\Entity\Enum;

enum StatusEnum: string
{
    use EnumToArray;

    case CREATED = 'created';
    case CONFIRMED = 'confirmed';
    case CANCELED = 'canceled';
}
