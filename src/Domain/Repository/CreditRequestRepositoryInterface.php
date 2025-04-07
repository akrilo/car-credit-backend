<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\CreditRequest;

interface CreditRequestRepositoryInterface
{
    public function findById(int $id): ?CreditRequest;

    /**
     * @return CreditRequest[]
     */
    public function findAll(): array;

    public function save(CreditRequest $creditRequest): void;

    public function remove(CreditRequest $creditRequest): void;
} 