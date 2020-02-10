<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%source_user}}`.
 */
class m200206_133645_create_source_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%source_user}}', [
            'id' => $this->primaryKey(),
        ]);

        $this->addColumn('{{%source_user}}', 'source_id', $this->integer());

        $this->createIndex(
            '{{%idx-source_user-source_id}}',
            '{{%source_user}}',
            'source_id'
        );

        $this->addForeignKey(
            '{{%fk-source_user-source_id}}',
            '{{%source_user}}',
            'source_id',
            '{{%source}}',
            'id',
            'CASCADE'
        );

        $this->addColumn('{{%source_user}}', 'user_id', $this->integer());

        $this->createIndex(
            '{{%idx-source_user-user_id}}',
            '{{%source_user}}',
            'user_id'
        );

        $this->addForeignKey(
            '{{%fk-source_user-user_id}}',
            '{{%source_user}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }
}
