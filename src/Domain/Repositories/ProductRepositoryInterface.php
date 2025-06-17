<?php

namespace Src\Domain\Repositories;

interface ProductRepositoryInterface
{
    public function getAll(): array;

    public function getFeaturedList(): array;

    public function updateFeaturedList(): void;
}
