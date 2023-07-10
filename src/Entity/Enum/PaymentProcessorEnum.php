<?php

declare(strict_types=1);

namespace App\Entity\Enum;

enum PaymentProcessorEnum: string
{
    case Paypal = 'paypal';
    case Stripe = 'stripe';

    public static function choices(): array
    {
        $result = [];
        foreach (self::cases() as $case) {
            $result[$case->name] = $case->value;
        }

        return $result;
    }
}
