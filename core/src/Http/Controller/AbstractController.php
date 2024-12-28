<?php

namespace Timon\PhpFramework\Http\Controller;

use Psr\Container\ContainerInterface;
use Timon\PhpFramework\Http\Response\Response;
use Twig\Environment;

abstract class AbstractController
{
    protected ?Environment $twig = null;

    protected ?ContainerInterface $container = null;

    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
        $this->setTwig($this->container->get('twig'));
    }

    private function setTwig(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function render(string $view, array $params = [], ?Response $response = null): Response
    {
        $content = $this->twig->render($view, $params);
        $response ??= new Response($content);

        return $response;
    }
}
