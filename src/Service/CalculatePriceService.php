<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Coupon;
use App\Entity\Enum\CouponTypeEnum;
use App\Entity\Product;
use App\Entity\Tax;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;

class CalculatePriceService
{
    public function __construct(
        private readonly string $currency,
    ) {
    }

    public function calculatePrice(Product $product, Tax $tax, ?Coupon $coupon): string
    {
        $money = (new Money($product->getPrice(), new Currency($this->currency)))
            ->multiply($tax->getValue())->divide(100);
        if (null !== $coupon) {
            $money = match ($coupon->getType()) {
                CouponTypeEnum::Fixed => $money
                    ->subtract(new Money($coupon->getValue(), new Currency($this->currency))),
                CouponTypeEnum::Percent => $money
                    ->multiply($coupon->getValue())
                    ->divide(100),
            };
        }

        $moneyFormatter = new DecimalMoneyFormatter(new ISOCurrencies());

        return $moneyFormatter->format($money);
    }
}
