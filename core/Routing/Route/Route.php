<?php

namespace Timon\PhpFramework\Routing\Route;

class Route
{
    public static function get(string $uri, array $action)
    {
        return ['GET', $uri, $action];
    }

    public static function post(string $uri, array $action)
    {
        return ['POST', $uri, $action];
    }
}
