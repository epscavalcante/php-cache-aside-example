<?php

declare(strict_types=1);

namespace Src\Infrastructure\Cache;

use Src\Application\Cache\ProductFeaturedCacheInterface;
use Src\Domain\Entities\Product;
use Src\Infrastructure\Cache\CacheInterface;

class ProductFeaturedCache implements ProductFeaturedCacheInterface
{
    private const KEY = 'v1:catalog:featured-products';

    private const TTL = 3600;

    public function __construct(private readonly CacheInterface $cache) {}

    /**
     * Stores an array of Product entities in the cache.
     *
     * @param Product[] $products
     */
    public function set(array $products): void
    {
        $productsArray = array_map(fn(Product $product) => $product->toArray(), $products);

        $value = serialize($productsArray);

        $this->cache->set(
            key: self::KEY,
            value: $value,
            ttl: self::TTL
        );
    }

    public function get(): ?array
    {
        $raw = $this->cache->get(self::KEY);
        if (!is_string($raw)) {
            return null;
        }
        $data = @unserialize($raw);
        if (!is_array($data)) {
            return null;
        }

        return $data;
    }

    public function clear(): void
    {
        $this->cache->delete(self::KEY);
    }
}
