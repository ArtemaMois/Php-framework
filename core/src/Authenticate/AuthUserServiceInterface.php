<?php 

namespace Timon\PhpFramework\Authenticate;

use App\Entities\User;

interface AuthUserServiceInterface
{
    public function findByEmail(string $email): AuthUserInterface|null;
}