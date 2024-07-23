<?php

declare(strict_types=1);

namespace App\Core;

class Router
{
    private array $routes;

    public function __construct()
    {
        $this->routes = require_once './routes/routes.php';
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function processRequest(Request $request): Response
    {
        $fullUrl = $request->getRoute();
        $requestMethod = $request->getMethod();
        $url = parse_url($fullUrl, PHP_URL_PATH);

        foreach ($this->routes as $routeData) {
            if ($routeData['method'] === $requestMethod && $routeData['path'] === $url) {
                    return $this->callHandler($routeData['handler'], $request);
                }
            }
        return new Response('Not found', 404);
    }

    /**
     * @param callable $handler
     * @param Request $request
     * @return Response
     */
    protected function callHandler(callable $handler, Request $request): Response
    {
        if (is_callable($handler)) {
            $handler($request);
            return new Response('Handler executed', 200);
        } else {
            return new Response('Handler is not callable', 500);
        }
    }
}
