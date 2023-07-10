<?php

declare(strict_types=1);

namespace App\Service;

use App\Infrastructure\Validator\ServiceConstraint;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class TaxValidationService extends ConstraintValidator
{
    public function __construct(
        private readonly TaxService $taxService,
    ) {
    }

    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof ServiceConstraint) {
            throw new UnexpectedTypeException($constraint, ServiceConstraint::class);
        }

        $tax = $this->taxService->findTaxByNumber($value);
        if (null === $tax) {
            $this->context->buildViolation('Invalid tax')
                ->setInvalidValue($value)
                ->setCode(ServiceConstraint::SERVICE_ERROR)
                ->setCause($this->context->getObject())
                ->addViolation();
        }
    }
}
