<?php

use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;

return new class
{
    public function up(Schema $schema)
    {
        $table = $schema->createTable('posts');
        $table->addColumn('id', Types::INTEGER, [
            'autoincrement' => true,
            'unsigned' => true,
        ]);
        $table->addColumn('title', Types::STRING)->setLength(255);
        $table->addColumn('body', Types::TEXT)->setLength(1255);
        $table->addColumn('created_at', Types::DATETIME_IMMUTABLE, [
            'default' => 'CURRENT_TIMESTAMP',
        ]);
        $table->setPrimaryKey(['id']);
    }

    public function down(AbstractSchemaManager $schema)
    {
        $schema->dropTable('posts');
    }
};
