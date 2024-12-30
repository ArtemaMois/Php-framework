<?php 

namespace Timon\PhpFramework\Authenticate;

interface AuthInterface
{
    public function authenticate(string $email, string $password): bool;

    public function login(AuthUserInterface $user);

    public function logout();

    public function user(): AuthUserInterface;
}