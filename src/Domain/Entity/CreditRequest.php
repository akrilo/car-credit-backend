<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Infrastructure\Persistence\Repository\CreditRequestRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CreditRequestRepository::class)]
class CreditRequest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $initialPayment = null;

    #[ORM\Column]
    private ?int $loanTerm = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'creditRequests')]
    private ?Car $car = null;

    #[ORM\ManyToOne(inversedBy: 'creditRequests')]
    private ?CreditProgram $creditProgram = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInitialPayment(): ?float
    {
        return $this->initialPayment;
    }

    public function setInitialPayment(float $initialPayment): static
    {
        $this->initialPayment = $initialPayment;

        return $this;
    }

    public function getLoanTerm(): ?int
    {
        return $this->loanTerm;
    }

    public function setLoanTerm(int $loanTerm): static
    {
        $this->loanTerm = $loanTerm;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCar(): ?Car
    {
        return $this->car;
    }

    public function setCar(?Car $car): static
    {
        $this->car = $car;

        return $this;
    }

    public function getCreditProgram(): ?CreditProgram
    {
        return $this->creditProgram;
    }

    public function setCreditProgram(?CreditProgram $creditProgram): static
    {
        $this->creditProgram = $creditProgram;

        return $this;
    }
}
