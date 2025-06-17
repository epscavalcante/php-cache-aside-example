<?php

declare(strict_types=1);

namespace Src\Application\UseCases\GetProductList;

use Src\Domain\Repositories\ProductRepositoryInterface;

class GetProductListUseCase
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository,
    ) {}

    public function execute(): array
    {
        $products = $this->productRepository->getAll();

        return array_map(fn($product) => $product->toArray(), $products);
    }
}
