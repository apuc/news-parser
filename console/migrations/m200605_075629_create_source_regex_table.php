<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%source_regex}}`.
 */
class m200605_075629_create_source_regex_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%source_regex}}', [
            'id' => $this->primaryKey(),
            'source_id' => $this->integer()->notNull(),
            'regex_id' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-source_regex-source_id',
            'source_regex',
            'source_id'
        );

        $this->addForeignKey(
            'fk-source_regex-source_id',
            'source_regex',
            'source_id',
            'source',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-source_regex-regex_id',
            'source_regex',
            'regex_id'
        );

        $this->addForeignKey(
            'fk-source_regex-regex_id',
            'source_regex',
            'regex_id',
            'regex',
            'id',
            'CASCADE'
        );
    }
}
