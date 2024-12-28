<?php

namespace App\Http\Controllers;

use App\Services\YoutubeService;
use Timon\PhpFramework\Http\Controller\AbstractController;

class HomeController extends AbstractController
{
    public function __construct(
        private YoutubeService $youtube
    ) {}

    public function index()
    {
        exit();
        $response = $this->render('home.html.twig', ['youTubeChannel' => $this->youtube->getChannelUrl()]);

        return $response;
    }

    public function posts(int $id)
    {
        return response()->json(['data' => $id]);
    }
}
