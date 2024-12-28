<?php

namespace App\Http\Controllers;

use Timon\PhpFramework\Http\Controller\AbstractController;

class PostsController extends AbstractController
{
    public function index() {}

    public function create()
    {
        return $this->render('create-post.html.twig');
    }
}
