<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\Data\PaymentData;
use App\Form\PaymentForm;
use App\Infrastructure\Attribute\ApiForm;
use App\Service\PurchaseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    #[Route(path: '/payment/calc', methods: ['POST'])]
    public function calcPrice(
        #[ApiForm(formClass: PaymentForm::class)]
        PaymentData $paymentData,
        PurchaseService $purchaseService,
    ): JsonResponse {
        return $this->json($purchaseService->calcPrice($paymentData));
    }

    #[Route(path: '/payment/process', methods: ['POST'])]
    public function processPayment(
        #[ApiForm(formClass: PaymentForm::class)]
        PaymentData $paymentData,
        PurchaseService $purchaseService,
    ): JsonResponse {
        return $this->json($purchaseService->purchase($paymentData));
    }
}
