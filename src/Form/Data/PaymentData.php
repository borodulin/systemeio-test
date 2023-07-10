<?php

declare(strict_types=1);

namespace App\Form\Data;

use App\Entity\Coupon;
use App\Entity\Enum\PaymentProcessorEnum;
use App\Entity\Product;

class PaymentData
{
    public Product $product;

    public string $taxNumber;

    public ?Coupon $coupon = null;

    public string $paymentProcessor;
}
