<?php

declare(strict_types=1);

namespace App\Service\PaymentProcessor;

use App\Service\PaymentProcessor\Integration\PaypalPaymentProcessor;
use App\Service\PaymentProcessor\Integration\StripePaymentProcessor;

class PaymentProcessorManager
{
    public function __construct(
        private readonly PaypalPaymentProcessor $paypalPaymentProcessor,
        private readonly StripePaymentProcessor $stripePaymentProcessor,
    ) {
    }

    public function getPaymentProcessor(string $name): ?PaymentProcessorInterface
    {
        return match ($name) {
            'paypal' => $this->paypalPaymentProcessor,
            'stripe' => $this->stripePaymentProcessor,
            default => null,
        };
    }
}
