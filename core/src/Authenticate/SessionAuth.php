<?php 

namespace Timon\PhpFramework\Authenticate;

use App\Entities\User;
use App\Services\UserService;
use Timon\PhpFramework\Session\SessionInterface;

class SessionAuth implements AuthInterface
{

    private AuthUserInterface $user; 

    public function __construct(
        private AuthUserServiceInterface $service,
        private SessionInterface $session,
    ) {}

    /**
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function authenticate(string $email, string $password): bool
    {
        /**
         * @var User $user
         */
        $user = $this->service->findByEmail($email);
        if(is_null($user))
        {
            return false;
        }
        if(!password_verify($password, $user->getPassword()))
        {
            return false;
        }
        $this->login($user);
        return true;
    }
/**
 *
 * @param User $user
 * @return void
 */
    public function login(AuthUserInterface $user)
    {
        $this->session->set('user_id', $user->getId());
        $this->user = $user;
    }

    public function logout()
    {}

    public function user(): AuthUserInterface
    {
        return $this->user;
    }
}