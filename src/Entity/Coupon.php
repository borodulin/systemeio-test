<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Enum\CouponTypeEnum;
use App\Entity\Trait\IdTrait;
use App\Repository\CouponRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CouponRepository::class)]
class Coupon
{
    use IdTrait;

    #[ORM\Column(type: 'string', unique: true)]
    private string $code;

    #[ORM\Column(type: 'string', enumType: CouponTypeEnum::class)]
    private CouponTypeEnum $type;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private string $value;

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getType(): CouponTypeEnum
    {
        return $this->type;
    }

    public function setType(CouponTypeEnum $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }
}
