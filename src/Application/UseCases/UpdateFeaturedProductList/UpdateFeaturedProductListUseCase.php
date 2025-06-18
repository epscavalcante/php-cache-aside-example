<?php

declare(strict_types=1);

namespace Src\Application\UseCases\UpdateFeaturedProductList;

use Src\Domain\Repositories\ProductRepositoryInterface;
use Src\Infrastructure\Cache\ProductFeaturedCache;

class UpdateFeaturedProductListUseCase
{
    public function __construct(
        private readonly ProductFeaturedCache $productFeaturedCache,
        private readonly ProductRepositoryInterface $productRepository,
    ) {}

    public function execute(): void
    {
        $this->productRepository->updateFeaturedList();

        $this->productFeaturedCache->clear();
    }
}
