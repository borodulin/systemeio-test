<?php

declare(strict_types=1);

namespace App\Integration\PaymentProcessor;

class StripePaymentProcessor
{
    /**
     * @return bool true if payment was succeeded, false otherwise
     */
    public function processPayment(int $price): bool
    {
        if ($price < 10) {
            return false;
        }

        // process payment logic
        return true;
    }
}
