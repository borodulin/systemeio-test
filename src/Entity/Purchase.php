<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Enum\PaymentProcessorEnum;
use App\Entity\Trait\IdTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Purchase
{
    use IdTrait;

    #[ORM\ManyToOne(targetEntity: Product::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private Product $product;

    #[ORM\Column(type: 'string')]
    private string $taxNumber;

    #[ORM\ManyToOne(targetEntity: Coupon::class)]
    #[ORM\JoinColumn(onDelete: 'SET NULL')]
    private ?Coupon $coupon = null;

    #[ORM\Column(type: 'string', enumType: PaymentProcessorEnum::class)]
    private PaymentProcessorEnum $paymentProcessor;

    #[ORM\ManyToOne(targetEntity: Tax::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private Tax $tax;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private string $price;

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getTaxNumber(): string
    {
        return $this->taxNumber;
    }

    public function setTaxNumber(string $taxNumber): self
    {
        $this->taxNumber = $taxNumber;

        return $this;
    }

    public function getCoupon(): ?Coupon
    {
        return $this->coupon;
    }

    public function setCoupon(?Coupon $coupon): self
    {
        $this->coupon = $coupon;

        return $this;
    }

    public function getPaymentProcessor(): PaymentProcessorEnum
    {
        return $this->paymentProcessor;
    }

    public function setPaymentProcessor(PaymentProcessorEnum $paymentProcessor): self
    {
        $this->paymentProcessor = $paymentProcessor;

        return $this;
    }

    public function getTax(): Tax
    {
        return $this->tax;
    }

    public function setTax(Tax $tax): self
    {
        $this->tax = $tax;

        return $this;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }
}
