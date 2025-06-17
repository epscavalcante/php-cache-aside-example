<?php

use Slim\Factory\AppFactory;
use Src\Infrastructure\Http\Controllers\HomeController;
use Src\Infrastructure\Http\Controllers\ProductController;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->addBodyParsingMiddleware();

$app->addRoutingMiddleware();

$app->addErrorMiddleware(true, true, true);

$app->get('/', HomeController::class);
$app->get('/products', [ProductController::class, 'getAll']);
$app->get('/products/featured', [ProductController::class, 'getFeatured']);
$app->post('/products/featured', [ProductController::class, 'updateListFeatured']);

$app->run();