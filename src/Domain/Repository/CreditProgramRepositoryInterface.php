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

    /**
     * Находит предпочтительную программу по названию.
     */
    public function findPreferredByName(string $name): ?CreditProgram;

    /**
     * Находит лучшую альтернативную программу (например, с минимальной ставкой),
     * исключая программу с заданным названием.
     */
    public function findBestAlternative(?string $excludeName = null): ?CreditProgram;

    /**
     * Находит первую попавшуюся программу, исключая программу с заданным названием.
     * Используется, если альтернатива не найдена, но нужна хоть какая-то.
     */
    public function findAnyExcept(?string $excludeName = null): ?CreditProgram;
} 