<?php

use Timon\PhpFramework\Http\Response\Response;

if (! function_exists('response')) {
    function response(?string $content = null, array $headers = [], int $status = 200)
    {
        return new Response($content, $headers, $status);
    }
}


