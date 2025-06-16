<?php

declare(strict_types=1);

namespace Src\Infrastructure\Http\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class HomeController
{
    public function __invoke(Request $request, Response $response): Response
    {
        $body = [
            'message' => 'Hello world',
        ];
        $response->withHeader('Content-Type', 'application/json')->getBody()->write(json_encode($body));
        return $response;
    }
}
