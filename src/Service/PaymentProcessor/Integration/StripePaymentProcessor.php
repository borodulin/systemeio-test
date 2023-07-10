<?php

declare(strict_types=1);

namespace App\Service\PaymentProcessor\Integration;

use App\Integration\PaymentProcessor\StripePaymentProcessor as StripeIntegrationPaymentProcessor;
use App\Service\PaymentProcessor\PaymentProcessorInterface;

class StripePaymentProcessor implements PaymentProcessorInterface
{
    public function __construct(
        private readonly StripeIntegrationPaymentProcessor $stripePaymentProcessor,
    ) {
    }

    public function purchase(int $price): void
    {
        if (!$this->stripePaymentProcessor->processPayment($price)) {
            throw new \Exception('Something goes wrong');
        }
    }
}
