<?php

declare(strict_types = 1);

namespace Framework\Controllers;

use Framework\Registry;
use Framework\Renderer;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

abstract class BaseController
{

    /**
     * @param $viewPath
     * @param array $parameters
     * @param bool $layout
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     */
    public function render($viewPath, $parameters = [], $layout = true)
    {
        return (new Renderer())->render($viewPath, $parameters, $layout);
    }

    /**
     * @param string $name
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirect(string $name, array $params = [])
    {
        $route = Registry::getRoute($name, $params);
        return new RedirectResponse($route);
    }

    /**
     * @return Request
     * @throws \Exception
     */
    public function getRequest(): Request
    {
        return Registry::getRequest();
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function isLogged()
    {
        return Registry::getService('user.security')->isLogged();
    }
}
