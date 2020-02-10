<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%destination_theme}}`.
 */
class m200206_133655_create_destination_theme_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%destination_theme}}', [
            'id' => $this->primaryKey(),
        ]);

        $this->addColumn('{{%destination_theme}}', 'destination_id', $this->integer());

        $this->createIndex(
            '{{%idx-destination_theme-destination_id}}',
            '{{%destination_theme}}',
            'destination_id'
        );

        $this->addForeignKey(
            '{{%fk-destination_theme-destination_id}}',
            '{{%destination_theme}}',
            'destination_id',
            '{{%destination}}',
            'id',
            'CASCADE'
        );

        $this->addColumn('{{%destination_theme}}', 'theme_id', $this->integer());

        $this->createIndex(
            '{{%idx-destination_theme-theme_id}}',
            '{{%destination_theme}}',
            'theme_id'
        );

        $this->addForeignKey(
            '{{%fk-destination_theme-theme_id}}',
            '{{%destination_theme}}',
            'theme_id',
            '{{%theme}}',
            'id',
            'CASCADE'
        );
    }
}
