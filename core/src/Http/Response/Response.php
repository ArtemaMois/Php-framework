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
        return json_encode($data);
    }

    public function getHeader(string $key)
    {
        return $this->headers[$key];  
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
