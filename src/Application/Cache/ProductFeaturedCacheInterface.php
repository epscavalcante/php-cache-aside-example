<?php

declare(strict_types=1);

namespace Src\Application\Cache;

interface ProductFeaturedCacheInterface
{
    public function set(array $products): void;

    public function get(): ?array;

    public function clear(): void;
}
