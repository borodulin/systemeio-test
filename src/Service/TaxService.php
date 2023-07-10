<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Tax;
use App\Repository\TaxRepository;

class TaxService
{
    private static array $taxPatterns = [
        'DE' => '/^DE\d{9}$/',
        'IT' => '/^IT\d{11}$/',
        'GR' => '/^GR\d{9}$/',
        'FR' => '/^IT\w{2}\d{9}$/',
    ];

    public function __construct(
        private readonly TaxRepository $taxRepository,
    ) {
    }

    public function getTaxByNumber(string $taxNumber): ?Tax
    {
        $tax = $this->findTaxByNumber($taxNumber);
        if (null === $tax) {
            throw new \RuntimeException('Something goes wrong');
        }
        return $tax;
    }

    public function findTaxByNumber(string $taxNumber): ?Tax
    {
        foreach (self::$taxPatterns as $countryCode => $pattern) {
            if (preg_match($pattern, $taxNumber)) {
                return $this->taxRepository->findActualByCountryCode($countryCode);
            }
        }

        return null;
    }
}
