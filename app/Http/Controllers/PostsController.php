<?php

namespace App\Http\Controllers;

use App\Entities\Post;
use App\Services\PostService;
use Timon\PhpFramework\Http\Controller\AbstractController;
use Timon\PhpFramework\Http\Request\Request;
use Timon\PhpFramework\Http\Response\RedirectResponse;

class PostsController extends AbstractController
{
    public function __construct(
       private PostService $service
    ) {}
    public function index() {}

    public function show(int $id)
    {
        $post = $this->service->findOrFail($id);
        return $this->render('posts.html.twig', ['post' => $post]);
    }

    public function create()
    {
        return $this->render('create-post.html.twig');
    }

    public function store()
    {
        $post = Post::create($this->request->postParam('title'), $this->request->postParam('body'));
        $post = $this->service->save($post);
        return new RedirectResponse("/posts/" . $post->id());
    }

}
