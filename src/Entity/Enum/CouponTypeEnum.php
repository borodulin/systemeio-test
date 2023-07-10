<?php

declare(strict_types=1);

namespace App\Entity\Enum;

enum CouponTypeEnum: string
{
    case Fixed = 'fixed';
    case Percent = 'percent';
}
