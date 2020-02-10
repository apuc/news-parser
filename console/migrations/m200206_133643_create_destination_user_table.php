<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%destination_user}}`.
 */
class m200206_133643_create_destination_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%destination_user}}', [
            'id' => $this->primaryKey(),
        ]);

        $this->addColumn('{{%destination_user}}', 'destination_id', $this->integer());

        $this->createIndex(
            '{{%idx-destination_user-destination_id}}',
            '{{%destination_user}}',
            'destination_id'
        );

        $this->addForeignKey(
            '{{%fk-destination_user-destination_id}}',
            '{{%destination_user}}',
            'destination_id',
            '{{%destination}}',
            'id',
            'CASCADE'
        );

        $this->addColumn('{{%destination_user}}', 'user_id', $this->integer());

        $this->createIndex(
            '{{%idx-destination_user-user_id}}',
            '{{%destination_user}}',
            'user_id'
        );

        $this->addForeignKey(
            '{{%fk-destination_user-user_id}}',
            '{{%destination_user}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }
}
