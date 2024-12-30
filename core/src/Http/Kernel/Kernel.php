<?php

namespace Timon\PhpFramework\Http\Kernel;

use Doctrine\DBAL\Connection;
use Exception;
use League\Container\Container;
use Timon\PhpFramework\Http\Exceptions\HttpExceptionInterface;
use Timon\PhpFramework\Http\Middleware\RequestHandlerInterface;
use Timon\PhpFramework\Http\Request\Request;
use Timon\PhpFramework\Http\Response\Response;
use Timon\PhpFramework\Routing\Router\RouterInterface;

class Kernel
{
    private string $appEnv;

    private Request $request;

    public function __construct(
        private RouterInterface $router,
        private Container $container,
        private RequestHandlerInterface $requestHandler
    ) {
        $this->appEnv = $container->get('APP_ENV');
    }

    public function handle(Request $request)
    {
        try {
            $response = $this->requestHandler->handle($request);
        } catch (Exception $e) {
            return $this->createExceptionResponse($e);
        }

        return $response;
    }

    private function createExceptionResponse(Exception $e)
    {
        if (in_array($this->appEnv, ['local', 'testing'])) {
            throw $e;
        }
        if ($e instanceof HttpExceptionInterface) {
            return new Response($e->getMessage(), [], $e->getCode());
        }

        return new Response('<h1>Internal server error</h1>', [], 500);
    }
}
