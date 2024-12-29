<?php

namespace App\Http\Controllers;

use App\Entities\Post;
use Timon\PhpFramework\Http\Controller\AbstractController;
use Timon\PhpFramework\Http\Request\Request;

class PostsController extends AbstractController
{
    public function index() {}

    public function create()
    {
        return $this->render('create-post.html.twig');
    }

    public function store()
    {
        $post = Post::create($this->request->postParam('title'), $this->request->postParam('body'));
        dd($post);
    }
}
