<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%destination}}`.
 */
class m200206_124624_create_destination_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%destination}}', [
            'id' => $this->primaryKey(),
            'domain' => $this->string()
        ]);

        $this->addColumn('{{%destination}}', 'theme_id', $this->integer());

        $this->createIndex(
            '{{%idx-destination-theme_id}}',
            '{{%destination}}',
            'theme_id'
        );

        $this->addForeignKey(
            '{{%fk-destination-theme_id}}',
            '{{%destination}}',
            'theme_id',
            '{{%theme}}',
            'id',
            'CASCADE'
        );

        $this->addColumn('{{%destination}}', 'user_id', $this->integer());

        $this->createIndex(
            '{{%idx-destination-user_id}}',
            '{{%destination}}',
            'user_id'
        );

        $this->addForeignKey(
            '{{%fk-destination-user_id}}',
            '{{%destination}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }
}
