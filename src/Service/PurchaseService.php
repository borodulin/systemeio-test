<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Enum\PaymentProcessorEnum;
use App\Entity\Purchase;
use App\Form\Data\PaymentData;
use App\Service\PaymentProcessor\PaymentProcessorManager;
use Doctrine\ORM\EntityManagerInterface;

class PurchaseService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly TaxService $taxService,
        private readonly CalculatePriceService $calculatePriceService,
        private readonly PaymentProcessorManager $paymentProcessorManager,
    ) {
    }

    public function calcPrice(PaymentData $paymentData): array
    {
        $priceInCents = $this->calculatePriceService->calculatePriceInCents(
            $paymentData->product,
            $this->taxService->getTaxByNumber($paymentData->taxNumber),
            $paymentData->coupon
        );

        return [
            'status' => 'OK',
            'price' => $this->calculatePriceService->formatCentsToDecimal($priceInCents),
        ];
    }

    public function purchase(PaymentData $paymentData): array
    {
        $tax = $this->taxService->getTaxByNumber($paymentData->taxNumber);
        $priceInCents = $this->calculatePriceService->calculatePriceInCents(
            $paymentData->product,
            $tax,
            $paymentData->coupon
        );

        $paymentProcessorEnum = PaymentProcessorEnum::from($paymentData->paymentProcessor);
        $paymentProcessor = $this->paymentProcessorManager->getPaymentProcessor($paymentProcessorEnum);
        $paymentProcessor->purchase((int) $priceInCents);

        $decimalPrice = $this->calculatePriceService->formatCentsToDecimal($priceInCents);

        $purchase = (new Purchase())
            ->setCoupon($paymentData->coupon)
            ->setTax($tax)
            ->setProduct($paymentData->product)
            ->setPaymentProcessor(PaymentProcessorEnum::from($paymentData->paymentProcessor))
            ->setTaxNumber($paymentData->taxNumber)
            ->setPrice($decimalPrice);
        $this->entityManager->persist($purchase);
        $this->entityManager->flush();

        return [
            'status' => 'OK',
            'purchaseId' => $purchase->getId(),
        ];
    }
}
