<?php

namespace Timon\PhpFramework\Http\Response;

class Response
{
    public function __construct(
        private $data,
        private array $headers = [],
        private int $statusCode = 200,
    ) {
        $this->send();
    }

    public function send()
    {
        echo $this->data;
    }
}
