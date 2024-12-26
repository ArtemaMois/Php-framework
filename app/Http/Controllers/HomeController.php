<?php

namespace App\Http\Controllers;

use Timon\PhpFramework\Http\Controller\AbstractController;
use Timon\PhpFramework\Http\Response\Response;
use Twig\Environment;

class HomeController extends AbstractController
{

    public function index()
    {
        $response = $this->render('home.html.twig', ['twig' => '123']);
        return $response;
    }

    public function posts(int $id)
    {
        return response()->json(['data' => $id]);
    }
}
