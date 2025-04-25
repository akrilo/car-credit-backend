<?php

declare(strict_types=1);

namespace App\Application\DTO;

class BrandShortDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $name
    ) {}
} 