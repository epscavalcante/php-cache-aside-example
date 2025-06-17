<?php

declare(strict_types=1);

namespace Src\Domain\Entities;

class Product
{
    public function __construct(
        private readonly string $productId,
        private readonly string $name,
        private readonly int $price,
        private bool $isFeatured = false,
    ) {}

    public function getId(): string|int
    {
        return $this->productId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function isFeatured(): bool
    {
        return $this->isFeatured;
    }

    public function toggleFeatured(): void
    {
        $this->isFeatured = !$this->isFeatured();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'price' => $this->getPrice(),
            'isFeatured' => $this->isFeatured(),
        ];
    }
}
