<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Brand;

interface BrandRepositoryInterface
{
    public function findById(int $id): ?Brand;

    /**
     * @return Brand[]
     */
    public function findAll(): array;

    public function save(Brand $brand): void;

    public function remove(Brand $brand): void;
} 