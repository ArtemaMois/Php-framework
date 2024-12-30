<?php

namespace App\Http\Controllers;

use App\Forms\User\RegisterForm;
use App\Services\UserService;
use Timon\PhpFramework\Authenticate\AuthInterface;
use Timon\PhpFramework\Authenticate\SessionAuth;
use Timon\PhpFramework\Http\Controller\AbstractController;
use Timon\PhpFramework\Http\Response\RedirectResponse;
use Timon\PhpFramework\Http\Response\Response;

class AuthController extends AbstractController
{

    public function __construct(
        private UserService $service,
        private AuthInterface $auth
    ) {}
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
            $this->request->input('password_confirmation'),
            $this->request->input('name')
        );
        if ($form->hasValidationErrors()) {
            $this->setValidationErrorsInSession($form->getValidationErrors());
            return new RedirectResponse('/register');
        }
        $user = $form->save();

        $this->request->getSession()->setFlash("success", "Пользователь {$user->getEmail()} успешно зарегистрирован");
        return new RedirectResponse('/register');
    }

    public function loginForm()
    {
        return $this->render('login.html.twig');
    }

    public function login(): RedirectResponse
    {
        $isAuth = $this->auth->authenticate($this->request->input('email'), $this->request->input('password'));
        if(!$isAuth)
        {
            $this->request->getSession()->setFlash('error', 'Неверный логин или пароль');
            return new RedirectResponse('/login');
        }

        $this->request->getSession()->setFlash('success', 'Вы успешно авторизировались');
        return new RedirectResponse('/dashboard');
    }
}
