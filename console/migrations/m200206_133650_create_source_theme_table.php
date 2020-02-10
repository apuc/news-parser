<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%source_theme}}`.
 */
class m200206_133650_create_source_theme_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%source_theme}}', [
            'id' => $this->primaryKey(),
        ]);

        $this->addColumn('{{%source_theme}}', 'source_id', $this->integer());

        $this->createIndex(
            '{{%idx-source_theme-source_id}}',
            '{{%source_theme}}',
            'source_id'
        );

        $this->addForeignKey(
            '{{%fk-source_theme-source_id}}',
            '{{%source_theme}}',
            'source_id',
            '{{%source}}',
            'id',
            'CASCADE'
        );

        $this->addColumn('{{%source_theme}}', 'theme_id', $this->integer());

        $this->createIndex(
            '{{%idx-source_theme-theme_id}}',
            '{{%source_theme}}',
            'theme_id'
        );

        $this->addForeignKey(
            '{{%fk-source_theme-theme_id}}',
            '{{%source_theme}}',
            'theme_id',
            '{{%theme}}',
            'id',
            'CASCADE'
        );
    }
}
