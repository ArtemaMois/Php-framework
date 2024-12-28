<?php

use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;

return new class
{
    public function up(Schema $schema)
    {
        $table = $schema->createTable('users');
        $table->addColumn('id', Types::INTEGER, [
            'autoincrement' => true,
            'unsigned' => true,
        ]);
        $table->addColumn('name', Types::STRING)->setLength(255);
        $table->addColumn('email', Types::TEXT)->setLength(255);
        $table->addColumn('created_at', Types::DATETIME_IMMUTABLE, [
            'default' => 'CURRENT_TIMESTAMP',
        ]);
        $table->setPrimaryKey(['id']);
    }

    public function down(AbstractSchemaManager $schema)
    {
        $schema->dropTable('users');
    }
};
