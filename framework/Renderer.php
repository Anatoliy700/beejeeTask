<?php

declare(strict_types = 1);

namespace Framework;

use Symfony\Component\HttpFoundation\Response;

class Renderer
{
    private $layout = 'main';

    private $rootViewPath;

    /**
     * Получаем layout
     */
    private function getLayout()
    {
        try {
            $this->layout = Registry::getDataConfig('layout');
        } catch (\InvalidArgumentException $e) {
        }
    }

    /**
     * Отрисовка страницы
     *
     * @param string $view
     * @param array $parameters
     * @param bool $layout
     * @return Response
     * @throws \Throwable
     */
    public function render(string $view, array $parameters = [], $layout = true): Response
    {
        $this->rootViewPath = Registry::getDataConfig('view.directory');
        $viewPath = $this->rootViewPath . $view;

        if ($layout) {
            $this->getLayout();
            $content = $this->renderTemplate($viewPath, $parameters);
            $response = $this->renderTemplate($this->rootViewPath . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR . $this->layout . '.php',
                ['content' => $content, 'params' => $parameters]);
        } else {
            $response = $this->renderTemplate($viewPath, $parameters);
        }

        return new Response($response);
    }

    /**
     * @param $viewPath
     * @param array $parameters
     * @return false|string
     * @throws \Throwable
     */
    private function renderTemplate($viewPath, $parameters = [])
    {
        if (!file_exists($viewPath)) {
            return new Response('There is no view file ' . $viewPath, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        ob_start();
        extract($parameters);
        include_once $viewPath;
        return ob_get_clean();
    }
}
