<?php

declare(strict_types=1);

namespace Src\Infrastructure\Cache;

use Predis\Client as PredisClient;
use Src\Infrastructure\Cache\CacheInterface;

class RedisCacheAdapter implements CacheInterface
{
    private readonly PredisClient $client;

    public function __construct()
    {
        $this->client = new PredisClient('redis://redis:6379');
    }

    public function get(string $key, mixed $default = null): mixed
    {
        $value = $this->client->get($key);
        return $value === false ? $default : $value;
    }

    public function set(string $key, mixed $value, null|int|\DateInterval $ttl = null): bool
    {
        $ttl = $this->normalizeTTL($ttl);

        $result = $ttl
            ? $this->client->setex($key, $ttl, $value)
            : $this->client->set($key, $value);

        return $result === 'OK' || $result === true;
    }

    public function delete(string $key): bool
    {
        return (bool) $this->client->del($key);
    }

    public function has(string $key): bool
    {
        return (bool) $this->client->exists($key);
    }

    public function getMultiple(iterable $keys, mixed $default = null): iterable
    {
        $result = [];
        foreach ($keys as $key) {
            if (!is_string($key)) {
                throw new \Psr\SimpleCache\InvalidArgumentException('Keys must be strings.');
            }
            $value = $this->get($key, $default);
            $result[$key] = $value;
        }

        return $result;
    }


    public function setMultiple(iterable $values, null|int|\DateInterval $ttl = null): bool
    {
        $result = true;

        foreach ($values as $key => $value) {
            if (!is_string($key)) {
                throw new \Psr\SimpleCache\InvalidArgumentException('Keys must be strings.');
            }
            $result = $result && $this->set($key, $value, $ttl);
        }

        return $result;
    }

    public function deleteMultiple(iterable $keys): bool
    {
        $result = true;

        foreach ($keys as $key) {
            if (!is_string($key)) {
                throw new \Psr\SimpleCache\InvalidArgumentException('Keys must be strings.');
            }
            $result = $result && $this->delete($key);
        }

        return $result;
    }


    public function clear(): bool
    {
        return (bool) $this->client->flushdb();
    }

    private function normalizeTTL(null|int|\DateInterval $ttl): int
    {
        if ($ttl instanceof \DateInterval) {
            return (int) $ttl->format('%s') + (int) $ttl->format('%i') * 60 + (int) $ttl->format('%H') * 3600;
        }

        return $ttl ?? 0;
    }
}
