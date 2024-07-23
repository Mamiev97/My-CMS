<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\BaseController;
use App\Core\Request;
use App\Core\Response;

class RenderTemplatesController extends BaseController
{
    protected Response $response;
    protected Request $request;

    /**
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        parent::__construct($request, $response);
    }

    /**
     * @param string $templatePath
     * @param array $data
     * @return null
     */
    public function renderTemplate(string $templatePath, array $data = []): null
    {
        extract($data);
        include $templatePath;
        return null;
    }

    /**
     * @return null
     */
    public function renderRegistrationTemplate(): null
    {
        return $this->renderTemplate('./Templates/registration.html');
    }

    /**
     * @return null
     */
    public function renderAuthTemplate(): null
    {
        return $this->renderTemplate('./Templates/auth.html');
    }

    /**
     * @return null
     */
    public function renderResetPasswordTemplate(): null
    {
        return $this->renderTemplate('./Templates/reset_password.html');
    }
}