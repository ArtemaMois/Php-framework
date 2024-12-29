<?php

namespace App\Services;

use App\Entities\Post;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Timon\PhpFramework\Http\Exceptions\NotFoundException;

class PostService
{
    public function __construct(
        private Connection $connection
    ) {}
    public function save(Post $post)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->insert('posts')->values(
            [
                'title' => ':title',
                'body' => ':body',
                'created_at' => ':created_at'
            ]
        )->setParameters([
            'title' => $post->title(),
            'body' => $post->body(),
            'created_at' => $post->created_at()->format('Y-m-d H:i:s')
        ])->executeQuery();
        $id = $this->connection->lastInsertId();
        $post->setId($id);
        return $post;
    }

    private function getQueryBuilder(): QueryBuilder
    {
        return $this->connection->createQueryBuilder();
    }

    public function find(int $id): ?Post
    {
        $queryBuilder = $this->getQueryBuilder();
        $result = $queryBuilder->select('*')->from('posts')->where('id=:id')->setParameter('id', $id)->executeQuery()->fetchAssociative();
        if(!$result)
        {
            return null;
        }
        return Post::create(
            $result['title'],
            $result['body'],
            $result['id'],
            new \DateTimeImmutable($result['created_at'])
        );
    }

    public function findOrFail(int $id)
    {
        $post = $this->find($id);
        if(is_null($post))
        {
            throw new NotFoundException("Post with id {$id} not found");
        }
        return $post;
    }
}
