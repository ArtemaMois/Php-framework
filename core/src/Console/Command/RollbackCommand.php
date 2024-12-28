<?php

namespace Timon\PhpFramework\Console\Command;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\SchemaManagerFactory;
use Exception;
use Timon\PhpFramework\Console\CommandInterface;

class RollbackCommand implements CommandInterface
{
    private string $name = 'migrate-rollback';
    private const MIGRATION_TABLE = 'migrations';
    public function __construct(
        private Connection $connection,
        private string $migrationDir
    ) {}
    public function execute(array $params = []): int
    {
        try {
            $schema = $this->connection->createSchemaManager();
            $migrationFiles = $this->getMigrationsFromTable();
            $this->dropTables(array_values($migrationFiles), $schema);
            foreach ($migrationFiles as $key => $value) {
                $this->deleteMigrationRow($key);
            }
        } catch (Exception $e) {
            dd($e);
        }
        echo "\e[95mALL TABLES HAVE DROPPED\e[39m" . PHP_EOL ;
        return 0;
    }

    private function getMigrationsFromTable()
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $migrationFiles = $queryBuilder->select('id, migration')->from(self::MIGRATION_TABLE)->orderBy('id')->fetchAllKeyValue();
        return $migrationFiles;
    }

    private function dropTables(array $migrationFiles, AbstractSchemaManager $schema)
    {
        foreach ($migrationFiles as $file) {
            $migrationInstance = require $this->migrationDir . "/$file";
            $migrationInstance->down($schema);
        }
    }

    private function deleteMigrationRow(int $id)
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->delete(self::MIGRATION_TABLE)
            ->values(['id' => ':id'])->setParameter('id', $id)->executeQuery();
    }

    private function showDroppingTable(string $table) {}
}
