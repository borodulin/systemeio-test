<?php

declare(strict_types=1);

namespace App\Service\PaymentProcessor\Integration;

use App\Integration\PaymentProcessor\PaypalPaymentProcessor as PaypalIntegrationPaymentProcessor;
use App\Service\PaymentProcessor\PaymentProcessorInterface;

class PaypalPaymentProcessor implements PaymentProcessorInterface
{
    public function __construct(
        private readonly PaypalIntegrationPaymentProcessor $paypalPaymentProcessor,
    ) {
    }

    public function purchase(int $price): void
    {
        $this->paypalPaymentProcessor->pay($price);
    }
}
