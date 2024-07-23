<?php

declare(strict_types=1);

namespace App\Core;

abstract class BaseController
{
    protected Request $request;
    protected Response $response;

    /**
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return array
     */
    protected function getRequestData(): array
    {
        return $this->request->getData()['data'] ?? [];
    }

    /**
     * @param string $key
     * @return array|null
     */
    protected function getRequestFile(string $key): ?array
    {
        return $this->request->getData()['files'][$key] ?? null;
    }

    /**
     * @param string $message
     * @param int $status
     * @return Response
     */
    protected function createResponse(string $message, int $status = 200): Response
    {
        $this->response->setContent($message);
        $this->response->setStatusCode($status);
        return $this->response;
    }

    /**
     * @param string $url
     * @return Response
     */
    protected function redirectResponse(string $url): Response
    {
        $this->response->redirect($url);
        return $this->response;
    }
}
