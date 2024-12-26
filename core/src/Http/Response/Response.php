<?php

namespace Timon\PhpFramework\Http\Response;

class Response
{
    public function __construct(
        private string $data = '',
        private array $headers = [],
        private int $statusCode = 200,
    ) {
        http_response_code($statusCode);
    }

    public function send()
    {
        echo $this->data;
    }

    public function setContent(string $content)
    {
        $this->data = $content;
        return $this;
    }

    public function json(array $data)
    {
        dd(json_encode($data));
    }
}
