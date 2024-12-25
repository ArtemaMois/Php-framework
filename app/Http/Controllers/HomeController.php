<?php

namespace App\Http\Controllers;

use Timon\PhpFramework\Http\Response\Response;

class HomeController
{
    public function index()
    {
        return (new Response('<h1>HomeController Content</h1>'))->send();
    }

    public function posts(int $id)
    {
        return response()->json(['data' => $id]);
    }
}
