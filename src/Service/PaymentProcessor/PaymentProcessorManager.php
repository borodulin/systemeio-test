<?php

declare(strict_types=1);

namespace App\Service\PaymentProcessor;

use App\Entity\Enum\PaymentProcessorEnum;
use App\Service\PaymentProcessor\Integration\PaypalPaymentProcessor;
use App\Service\PaymentProcessor\Integration\StripePaymentProcessor;

class PaymentProcessorManager
{
    public function __construct(
        private readonly PaypalPaymentProcessor $paypalPaymentProcessor,
        private readonly StripePaymentProcessor $stripePaymentProcessor,
    ) {
    }

    public function getPaymentProcessor(PaymentProcessorEnum $paymentProcessor): PaymentProcessorInterface
    {
        return match ($paymentProcessor) {
            PaymentProcessorEnum::Paypal => $this->paypalPaymentProcessor,
            PaymentProcessorEnum::Stripe => $this->stripePaymentProcessor,
        };
    }
}
