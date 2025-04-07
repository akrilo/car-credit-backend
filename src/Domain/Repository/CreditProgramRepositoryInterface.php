<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\CreditProgram;

interface CreditProgramRepositoryInterface
{
    public function findById(int $id): ?CreditProgram;

    /**
     * @return CreditProgram[]
     */
    public function findAll(): array;

    public function save(CreditProgram $creditProgram): void;

    public function remove(CreditProgram $creditProgram): void;
} 