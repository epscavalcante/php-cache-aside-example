<?php

declare(strict_types=1);

namespace Src\Infrastructure\Http\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Src\Application\UseCases\GetFeaturedProductList\GetFeaturedProductListUseCase;
use Src\Application\UseCases\UpdateFeaturedProductList\UpdateFeaturedProductListUseCase;
use Src\Application\UseCases\GetProductList\GetProductListUseCase;
use Src\Infrastructure\Cache\ProductFeaturedCache;
use Src\Infrastructure\Cache\RedisCacheAdapter;
use Src\Infrastructure\Repositories\MemoryProductRepository;

class ProductController
{
    public function getAll(Request $request, Response $response): Response
    {
        $productRepository = new MemoryProductRepository();
        $useCase = new GetProductListUseCase(
            productRepository: $productRepository,
        );
        $output = $useCase->execute();
        $response->getBody()->write(json_encode($output, JSON_PRETTY_PRINT));
        $response = $response->withHeader('Content-Type', 'application/json');
        $response = $response->withStatus(200);
        return $response;
    }

    public function getFeatured(Request $request, Response $response): Response
    {
        $productRepository = new MemoryProductRepository();
        $cache = new RedisCacheAdapter();
        $productFeaturedCache = new ProductFeaturedCache($cache);
        $useCase = new GetFeaturedProductListUseCase(
            productRepository: $productRepository,
            productFeaturedCache: $productFeaturedCache,
        );
        $output = $useCase->execute();
        $response->getBody()->write(json_encode($output, JSON_PRETTY_PRINT));
        $response = $response->withHeader('Content-Type', 'application/json');
        $response = $response->withStatus(200);
        return $response;
    }

    public function updateListFeatured(Request $request, Response $response): Response
    {
        $productRepository = new MemoryProductRepository();
        $cache = new RedisCacheAdapter();
        $productFeaturedCache = new ProductFeaturedCache($cache);
        $useCase = new UpdateFeaturedProductListUseCase(
            productRepository: $productRepository,
            productFeaturedCache: $productFeaturedCache,
        );
        $useCase->execute();
        $response->getBody()->write(json_encode(['message' => 'Featured product list updated successfully'], JSON_PRETTY_PRINT));
        $response = $response->withHeader('Content-Type', 'application/json');
        $response = $response->withStatus(200);
        return $response;
    }
}
