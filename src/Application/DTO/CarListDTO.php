<?php

declare(strict_types=1);

namespace App\Application\DTO;

use App\Domain\Entity\Car;

class CarListDTO
{
    public readonly int $id;
    public readonly BrandShortDTO $brand;
    public readonly ?string $photo;
    public readonly int $price;

    public function __construct(Car $car)
    {
        $this->id = $car->getId();
        $this->brand = new BrandShortDTO(
            $car->getBrand()->getId(),
            $car->getBrand()->getName()
        );
        $this->photo = $car->getPhoto();
        $this->price = $car->getPrice();
    }
} 