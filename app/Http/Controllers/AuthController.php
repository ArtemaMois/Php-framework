<?php 

namespace App\Http\Controllers;

use App\Forms\User\RegisterForm;
use App\Services\UserService;
use Timon\PhpFramework\Http\Controller\AbstractController;
use Timon\PhpFramework\Http\Response\RedirectResponse;
use Timon\PhpFramework\Http\Response\Response;

class AuthController extends AbstractController
{

    public function __construct(
        private UserService $service
    ){}
    public function form()
    {
        return $this->render('register.html.twig');
    }

    public function register()
    {
        $form = new RegisterForm($this->service);
        $form->setFields(
            $this->request->input('email'),
            $this->request->input('password'),
            $this->request->input( 'password_confirmation'),
            $this->request->input('name')
        );
        if($form->hasValidationErrors())
        {
            $this->setValidationErrorsInSession($form->getValidationErrors());
            return new RedirectResponse('/register');
        }
        $user = $form->save();

        $this->request->getSession()->setFlash("success", "Пользователь {$user->getEmail()} успешно зарегистрирован");
        return new RedirectResponse('/register');
    }

    private function setValidationErrorsInSession(array $errors)
    {
        foreach($errors as $error)
        {
            $this->request->getSession()->setFlash('error', $error);
        }
    }
}