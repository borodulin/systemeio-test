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
use Money\Parser\DecimalMoneyParser;

class CalculatePriceService
{
    private DecimalMoneyFormatter $decimalMoneyFormatter;
    private DecimalMoneyParser $decimalMoneyParser;

    public function __construct(
        private readonly string $currency,
    ) {
        $isoCurrencies = new ISOCurrencies();
        $this->decimalMoneyFormatter = new DecimalMoneyFormatter($isoCurrencies);
        $this->decimalMoneyParser = new DecimalMoneyParser($isoCurrencies);
    }

    public function calculatePriceInCents(Product $product, Tax $tax, ?Coupon $coupon): string
    {
        $currency = new Currency($this->currency);
        $money = $this->parseMoney($product->getPrice(), $currency)
            ->multiply($tax->getValue() + 100)->divide(100);
        if (null !== $coupon) {
            $money = match ($coupon->getType()) {
                CouponTypeEnum::Fixed => $money
                    ->subtract(new Money($coupon->getValue(), $currency)),
                CouponTypeEnum::Percent => $money
                    ->multiply((int) (100 - (float) $coupon->getValue()))
                    ->divide(100),
            };
        }

        return $money->getAmount();
    }

    public function formatCentsToDecimal(string $price): string
    {
        $money = (new Money($price, new Currency($this->currency)));

        return $this->decimalMoneyFormatter->format($money);
    }

    public function parseMoney(string $price, Currency $currency): Money
    {
        return $this->decimalMoneyParser->parse($price, $currency);
    }
}
