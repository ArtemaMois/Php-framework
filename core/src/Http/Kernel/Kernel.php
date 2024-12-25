<?php

namespace Timon\PhpFramework\Http\Kernel;

use Exception;
use League\Container\Container;
use Throwable;
use Timon\PhpFramework\Http\Exceptions\HttpExceptionInterface;
use Timon\PhpFramework\Http\Exceptions\MethodNotAllowedException;
use Timon\PhpFramework\Http\Exceptions\PageNotFoundException;
use Timon\PhpFramework\Http\Request\Request;
use Timon\PhpFramework\Http\Response\Response;
use Timon\PhpFramework\Routing\Router\RouterInterface;

class Kernel
{
    private string $appEnv;
    private Request $request;

    public function __construct(
        private RouterInterface $router,
        private Container $container
    ) {
        $this->appEnv = $container->get('APP_ENV');
        $this->request = Request::createFromGlobals();
    }

    public function handle()
    {
        try {
            throw new Exception("sss");
            [$routeHandler, $params] = $this->router->dispatch($this->request, $this->container,);
            $response = call_user_func_array($routeHandler, $params);
        } catch (Exception $e)
        {
            return $this->createExceptionResponse($e);
        }

        return $response;
    }

    private function createExceptionResponse(\Exception $e) 
    {
        if(in_array($this->appEnv, ['local', 'testing'])){
            throw $e;
        }
        if($e instanceof HttpExceptionInterface)
        {
            return new Response($e->getMessage(), [], $e->getCode());
        }
        return new Response('<h1>Internal server error</h1>', [], 500);
    }
}
