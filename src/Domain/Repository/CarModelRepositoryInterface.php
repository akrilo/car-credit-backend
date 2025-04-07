<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\CarModel;

interface CarModelRepositoryInterface
{
    public function findById(int $id): ?CarModel;

    /**
     * @return CarModel[]
     */
    public function findAll(): array;

    public function save(CarModel $carModel): void;

    public function remove(CarModel $carModel): void;
} 