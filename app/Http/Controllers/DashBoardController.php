<?php 

namespace App\Http\Controllers;

use Timon\PhpFramework\Http\Controller\AbstractController;

class DashBoardController extends AbstractController
{

    public function index()
    {
        return $this->render('dashboard.html.twig');
    } 
}