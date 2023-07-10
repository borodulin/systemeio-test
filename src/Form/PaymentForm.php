<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Enum\PaymentProcessorEnum;
use App\Form\Data\PaymentData;
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
                'required' => true,
            ])
            ->add('taxNumber', TextType::class, [
                'required' => true,
            ])
            ->add('paymentProcessor', ChoiceType::class, [
                'required' => true,
                'choices' => PaymentProcessorEnum::choices(),
            ])
            ->add('couponCode', EntityType::class, [
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
