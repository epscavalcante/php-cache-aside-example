<?php

use Slim\Factory\AppFactory;
use Src\Infrastructure\Http\Controllers\HomeController;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->addBodyParsingMiddleware();

$app->addRoutingMiddleware();

$app->addErrorMiddleware(true, true, true);

$app->get('/', HomeController::class);

$app->run();