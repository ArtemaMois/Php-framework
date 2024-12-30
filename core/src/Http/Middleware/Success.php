<?php 

namespace Timon\PhpFramework\Http\Middleware;

use App\Services\YoutubeService;
use Timon\PhpFramework\Http\Request\Request;
use Timon\PhpFramework\Http\Response\Response;

class Success implements MiddlewareInterface
{
    public function __construct(
        private YoutubeService $service
    ) {}
    public function process(Request $request, RequestHandlerInterface $handler): Response
    {
        dd($this->service->getChannelUrl());
        return new Response('Hello, world');
    }
}
