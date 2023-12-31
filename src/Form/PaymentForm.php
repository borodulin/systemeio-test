<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Coupon;
use App\Entity\Enum\PaymentProcessorEnum;
use App\Entity\Product;
use App\Form\Data\PaymentData;
use App\Infrastructure\Validator\ServiceConstraint;
use App\Service\TaxValidationService;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaymentForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('product', EntityType::class, [
                'class' => Product::class,
                'required' => true,
            ])
            ->add('taxNumber', TextType::class, [
                'required' => true,
                'constraints' => [
                    new ServiceConstraint([
                        'service' => TaxValidationService::class,
                    ]),
                ],
            ])
            ->add('paymentProcessor', ChoiceType::class, [
                'required' => true,
                'choices' => PaymentProcessorEnum::choices(),
            ])
            ->add('couponCode', EntityType::class, [
                'class' => Coupon::class,
                'property_path' => 'coupon',
                'choice_value' => 'code',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PaymentData::class,
            'csrf_protection' => false,
        ]);
    }
}
