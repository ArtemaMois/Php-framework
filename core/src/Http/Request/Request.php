<?php

namespace Timon\PhpFramework\Http\Request;

class Request
{
    public function __construct(
        private readonly array $getParams,
        private readonly array $postData,
        private readonly array $cookies,
        private readonly array $files,
        private readonly array $server,
    ) {}

    public static function createFromGlobals(): static
    {
        return new static($_GET,$_POST, $_COOKIE, $_FILES, $_SERVER);
    }

    public function uri(): string
    {
        return strtok($this->server['REQUEST_URI'], '?');
    }

    public function method(): string
    {
        return $this->server['REQUEST_METHOD'];
    }

    public function postParams()
    {
        return $this->postData;
    }

    public function postParam(string $key, $default = null)
    {
        return isset($this->postData[$key]) ? $this->postData[$key] : $default;
    }

    public function getParams()
    {
        return $this->getParams;
    }

    public function getParam(string $key, $default = null)
    {
        return isset($this->getParams[$key]) ? $this->getParams[$key] : $default;
    }
}
