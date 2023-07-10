<?php

declare(strict_types=1);

namespace App\Service\PaymentProcessor;

interface PaymentProcessorInterface
{
    public function purchase(int $price): void;
}
