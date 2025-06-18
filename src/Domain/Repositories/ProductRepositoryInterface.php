<?php

namespace Src\Domain\Repositories;

use Src\Domain\Entities\Product;

interface ProductRepositoryInterface
{
    public function getAll(): array;

    /**
     * @return Product[]
     */
    public function getFeaturedList(): array;

    public function updateFeaturedList(): void;
}
