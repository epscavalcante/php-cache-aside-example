<?php

declare(strict_types=1);

namespace Src\Application\UseCases\GetFeaturedProductList;

use Src\Domain\Repositories\ProductRepositoryInterface;
use Src\Infrastructure\Cache\CacheInterface;

class GetFeaturedProductListUseCase
{
    private const CACHE_KEY = 'catalog:featured_products:v1';
    private const TTL = 300; // 5 minutos

    public function __construct(
        private readonly CacheInterface $cache,
        private readonly ProductRepositoryInterface $productRepository,
    ) {}

    public function execute(): array
    {
        $productsCached = $this->cache->get(self::CACHE_KEY);

        if ($productsCached !== null) {
            return $this->decodeProducts($productsCached);
        }

        return $this->fetchAndCacheProducts();
    }

    private function fetchAndCacheProducts(): array
    {
        $productsFromDB = $this->productRepository->getFeaturedList();
        $products = array_map(
            callback: fn($product) => $product->toArray(),
            array: $productsFromDB
        );

        $this->cache->set(
            key: self::CACHE_KEY,
            value: $this->encodeProducts($products),
            ttl: self::TTL
        );

        return $products;
    }

    private function encodeProducts(array $products): string
    {
        return json_encode(
            value: $products,
            flags: JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE
        );
    }

    private function decodeProducts(string $data): array
    {
        return json_decode(
            json: $data,
            associative: true,
            depth: 512,
            flags: JSON_THROW_ON_ERROR
        );
    }
}
