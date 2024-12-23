<?php 

namespace App\Http\Controllers;

use Timon\PhpFramework\Http\Response\Response;

class HomeController
{
    public function index()
    {
        return new Response("<h1>HomeController Content</h1>");
    }
}