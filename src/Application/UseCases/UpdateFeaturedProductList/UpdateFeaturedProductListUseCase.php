<?php

declare(strict_types=1);

namespace Src\Application\UseCases\GetFeaturedProductList;

use Src\Domain\Repositories\ProductRepositoryInterface;
use Src\Infrastructure\Cache\CacheInterface;

class UpdateFeaturedProductListUseCase
{
    private const CACHE_KEY = 'catalog:featured_products:v1';

    public function __construct(
        private readonly CacheInterface $cache,
        private readonly ProductRepositoryInterface $productRepository,
    ) {}

    public function execute(): void
    {
        $this->productRepository->updateFeaturedList();

        $this->cache->delete(self::CACHE_KEY);
    }
}
