<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Infrastructure\Persistence\Repository\CarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarRepository::class)]
class Car
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $photo = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\ManyToOne(inversedBy: 'cars')]
    private ?Brand $brand = null;

    #[ORM\ManyToOne(inversedBy: 'cars')]
    private ?CarModel $model = null;

    /**
     * @var Collection<int, CreditRequest>
     */
    #[ORM\OneToMany(targetEntity: CreditRequest::class, mappedBy: 'car')]
    private Collection $creditRequests;

    public function __construct()
    {
        $this->creditRequests = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getModel(): ?CarModel
    {
        return $this->model;
    }

    public function setModel(?CarModel $model): static
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @return Collection<int, CreditRequest>
     */
    public function getCreditRequests(): Collection
    {
        return $this->creditRequests;
    }

    public function addCreditRequest(CreditRequest $creditRequest): static
    {
        if (!$this->creditRequests->contains($creditRequest)) {
            $this->creditRequests->add($creditRequest);
            $creditRequest->setCar($this);
        }

        return $this;
    }

    public function removeCreditRequest(CreditRequest $creditRequest): static
    {
        if ($this->creditRequests->removeElement($creditRequest)) {
            // set the owning side to null (unless already changed)
            if ($creditRequest->getCar() === $this) {
                $creditRequest->setCar(null);
            }
        }

        return $this;
    }
}
