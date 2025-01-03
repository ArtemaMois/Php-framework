<?php 

namespace App\Services;

use App\Entities\User;
use Doctrine\DBAL\Connection;
use Timon\PhpFramework\Authenticate\AuthUserInterface;
use Timon\PhpFramework\Authenticate\AuthUserServiceInterface;

class UserService implements AuthUserServiceInterface
{

    public function __construct(
        private Connection $connection
    ) {}

    public function save(User $user)
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->insert('users')->values(
            [
                'name' => ':name',
                'email' => ':email',
                'password' => ':password',
                'created_at' => ':created_at'
            ]
        )->setParameters([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'created_at' => $user->getCreated_at()->format('Y-m-d H:i:s')
        ])->executeQuery();
        $id = $this->connection->lastInsertId();
        $user->setId($id);
        return $user;
    }

    public function findByEmail(string $email): ?AuthUserInterface  
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $result = $queryBuilder->select('*')->from('users')->where('email=:email')->setParameter('email', $email)->executeQuery()->fetchAssociative();
        if(!$result)
        {
            return null;
        }
        $user = User::create(
            $result['email'],
            $result['password'], 
            $result['name'],
            $result['id'],
            new \DateTimeImmutable($result['created_at'])
        );
        return $user;
    }
}