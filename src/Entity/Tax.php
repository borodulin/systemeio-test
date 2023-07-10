<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\IdTrait;
use App\Repository\TaxRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaxRepository::class)]
#[ORM\UniqueConstraint(fields: ['countyCode'], options: ['where' => '(terminated_at IS NULL)'])]
class Tax
{
    use IdTrait;

    #[ORM\Column(type: 'string')]
    private string $countyCode;

    #[ORM\Column(type: 'integer')]
    private int $value;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $terminatedAt = null;

    public function getCountyCode(): string
    {
        return $this->countyCode;
    }

    public function setCountyCode(string $countyCode): self
    {
        $this->countyCode = $countyCode;

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
