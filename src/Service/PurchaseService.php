<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Purchase;
use App\Form\Data\PaymentData;
use Doctrine\ORM\EntityManagerInterface;

class PurchaseService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly TaxService $taxService,
        private readonly CalculatePriceService $calculatePriceService,
    ) {
    }

    public function calcPrice(PaymentData $paymentData): array
    {
        $price = $this->calculatePriceService->calculatePrice(
            $paymentData->product,
            $this->taxService->getTax($paymentData->taxNumber),
            $paymentData->coupon
        );

        return [
            'status' => 'OK',
            'price' => $price,
        ];
    }

    public function purchase(PaymentData $paymentData): array
    {
        $tax = $this->taxService->getTax($paymentData->taxNumber);
        $price = $this->calculatePriceService->calculatePrice(
            $paymentData->product,
            $tax,
            $paymentData->coupon
        );

        $purchase = (new Purchase())
            ->setCoupon($paymentData->coupon)
            ->setTax($tax)
            ->setProduct($paymentData->product)
            ->setPaymentProcessor($paymentData->paymentProcessor)
            ->setTaxNumber($paymentData->taxNumber)
            ->setPrice($price);
        $this->entityManager->persist($purchase);
        $this->entityManager->flush();

        return [
            'status' => 'OK',
            'purchaseId' => $purchase->getId(),
        ];
    }
}
