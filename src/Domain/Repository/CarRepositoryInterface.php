<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Car;

interface CarRepositoryInterface
{
    public function findById(int $id): ?Car;

    /**
     * @return Car[]
     */
    public function findAll(): array;

    public function save(Car $car): void;

    public function remove(Car $car): void;
} 