<?php

namespace Timon\PhpFramework\Console\Command;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\Types\Types;
use Exception;
use Timon\PhpFramework\Console\CommandInterface;

class MigrateCommand implements CommandInterface
{
    private string $name = 'migrate';

    private const MIGRATION_TABLE = 'migrations';

    public function __construct(
        private Connection $connection,
        private string $migrationDir
    ) {}

    public function execute(array $params = []): int
    {
        try {
            $this->createMigrationTable();
            $appliedMigrations = $this->getAppliedMigrations();
            $migrations = $this->getMigrationFiles();
            $newMigrations = array_values(array_diff($migrations, $appliedMigrations));
            $schema = new Schema();
            foreach($newMigrations as $migration)
            {
                $migrationInstance = require $this->migrationDir . $migration;
                $migrationInstance->up($schema); 
                $this->addExistingMigration($migration);
            }
        } catch (Exception $e) {
            dd($e);
        }
        $sqlArray = $schema->toSql($this->connection->getDatabasePlatform());
        $this->executeQueries($sqlArray);
        $this->showAddedMigrations($schema->getTables());
        return 0;
    }

    private function createMigrationTable(): void
    {

        $migrationTableExists = $this->checkMigrationTableExists();
        if (! $migrationTableExists) {
            $schema = new Schema;
            $table = $schema->createTable(self::MIGRATION_TABLE);
            $table->addColumn(
                'id',
                Types::INTEGER,
                [
                    'unsigned' => true,
                    'autoincrement' => true,
                ]
            );
            $table->addColumn('migration', Types::STRING, [
                'length' => 256,
            ]);
            $table->addColumn('created_at', Types::DATETIME_IMMUTABLE, [
                'default' => 'CURRENT_TIMESTAMP',
            ]);
            $table->setPrimaryKey(['id']);
            $sqlArray = $schema->toSql($this->connection->getDatabasePlatform());
            $this->connection->executeQuery($sqlArray[0]);
            echo "\e[32mMigration table created!".PHP_EOL;
        }
    }

    private function checkMigrationTableExists(): bool
    {
        $schemaManager = $this->connection->createSchemaManager();

        return $schemaManager->tableExists(self::MIGRATION_TABLE);
    }

    private function getAppliedMigrations()
    {
        $builder = $this->connection->createQueryBuilder();
        $res = $builder->select('migration')->from(self::MIGRATION_TABLE)->executeQuery()->fetchFirstColumn();

        return $res;
    }

    private function getMigrationFiles()
    {
        $files = [];
        $items = scandir($this->migrationDir);
        $files = array_filter($items, function ($item) {
            if ($item != '.' && $item != '..') {
                return ! in_array($item, ['.', '..']);
            }
        });

        return array_values($files);
    }

    private function addExistingMigration(string $migration):void
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->insert(self::MIGRATION_TABLE)
        ->values(['migration' => ':migration'])->setParameter('migration', $migration)->executeQuery();
    }

    /**
     * Summary of showAddedMigrations
     * @param Table[] $tables
     * @return void
     */
    private function showAddedMigrations(array $tables)
    {
        foreach($tables as $table)
        {
            echo "\e[95mMIGRATE TABLE {$table->getName()}" . PHP_EOL . "\e[39m";
        }
    }

    private function executeQueries(array $sqlArray)
    {
        foreach($sqlArray as $sqlQuery)
        {
            $this->connection->executeQuery($sqlQuery);
        }
    }
}
