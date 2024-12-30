<?php

namespace Timon\PhpFramework\Session;

interface SessionInterface
{

    public function start(): void;
    public function get(string $key, $default = null);
    public function set(string $key, mixed $value);

    public function has(string $key): bool;

    public function remove(string $key);

    public function getFlash(string $key, $default = null);

    public function setFlash(string $key, string $message);
    public function hasFlash(string $key): bool;
    public function clearFlash(): void;
}
