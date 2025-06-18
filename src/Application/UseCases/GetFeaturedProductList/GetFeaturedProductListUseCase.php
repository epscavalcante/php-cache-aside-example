<?php

declare(strict_types=1);

namespace Src\Application\UseCases\GetFeaturedProductList;

use Src\Domain\Entities\Product;
use Src\Domain\Repositories\ProductRepositoryInterface;
use Src\Infrastructure\Cache\ProductFeaturedCache;

class GetFeaturedProductListUseCase
{
    public function __construct(
        private readonly ProductFeaturedCache $productFeaturedCache,
        private readonly ProductRepositoryInterface $productRepository,
    ) {}

    public function execute(): GetFeaturedProductListOutput
    {
        $productsFromCache = $this->productFeaturedCache->get();

        if ($productsFromCache !== null) {
            return GetFeaturedProductListOutput::build(
                products: $productsFromCache
            );
        }

        $productsFromDB = $this->productRepository->getFeaturedList();

        $this->productFeaturedCache->set(
            products: $productsFromDB,
        );

        return GetFeaturedProductListOutput::build(
            products: array_map(
                callback: fn(Product $product) => $product->toArray(),
                array: $productsFromDB
            )
        );
    }
}
