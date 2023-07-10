<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\IdTrait;
use App\Repository\TaxRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaxRepository::class)]
#[ORM\UniqueConstraint(fields: ['countryCode'], options: ['where' => '(terminated_at IS NULL)'])]
class Tax
{
    use IdTrait;

    #[ORM\Column(type: 'string')]
    private string $countryCode;

    #[ORM\Column(type: 'integer')]
    private int $value;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $terminatedAt = null;

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    public function setCountryCode(string $countryCode): self
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function setValue(int $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getTerminatedAt(): ?\DateTimeInterface
    {
        return $this->terminatedAt;
    }

    public function setTerminatedAt(?\DateTimeInterface $terminatedAt): self
    {
        $this->terminatedAt = $terminatedAt;

        return $this;
    }
}
