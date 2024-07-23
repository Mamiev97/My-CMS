<?php

declare(strict_types=1);

namespace App\Core;

class Request
{
    protected array $data;
    protected string $route;
    protected string $method;
    protected array $queryParams;

    /**
     * @param array $data
     * @param string $route
     * @param string $method
     */
    public function __construct(array $data, string $route, string $method) {
        $this->data = $data;
        $this->route = $route;
        $this->method = $method;
        $this->queryParams = [];
        $queryString = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
        if ($queryString) {
            parse_str($queryString, $this->queryParams);
        }
    }

    /**
     * @return array
     */
    public function getData(): array {
        return $this->data;
    }

    /**
     * @return string
     */
    public function getRoute(): string {
        return $this->route;
    }

    /**
     * @return string
     */
    public function getMethod(): string {
        return $this->method;
    }

    /**
     * @return array
     */
    public function getQueryParams(): array {
        return $this->queryParams;
    }
}