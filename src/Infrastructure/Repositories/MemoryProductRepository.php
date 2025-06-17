<?php

declare(strict_types=1);

namespace Src\Infrastructure\Repositories;

use Src\Domain\Entities\Product;
use Src\Domain\Repositories\ProductRepositoryInterface;

class MemoryProductRepository implements ProductRepositoryInterface
{
    /**@var Product[] */
    private array $products = [];

    public function __construct()
    {
        $this->products = [
            new Product('1', 'Product 1', 100, true),
            new Product('2', 'Product 2', 200, false),
            new Product('3', 'Product 3', 300, true),
            new Product('4', 'Product 3', 300, false),
            new Product('5', 'Product 3', 300, true),
            new Product('6', 'Product 3', 300, true),
            new Product('7', 'Product 3', 300, false),
            new Product('8', 'Product 3', 300, true),
            new Product('9', 'Product 3', 300, false),
            new Product('10', 'Product 3', 300, false),
        ];
    }

    public function getAll(): array
    {
        // simular um carregamento lento, como se fosse uma consulta a um banco de dados
        // ou uma chamada a um serviço externo
        sleep(rand(3, 6));

        return $this->products;
    }

    public function getFeaturedList(): array
    {
        sleep(rand(2, 5));

        return array_filter($this->products, fn($product) => $product->isFeatured());
    }

    public function updateFeaturedList(): void
    {
        sleep(rand(2, 5));

        foreach ($this->products as $product) {
            $product->toggleFeatured();
        }
    }
}
