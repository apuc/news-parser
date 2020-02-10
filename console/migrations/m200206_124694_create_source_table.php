<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%source}}`.
 */
class m200206_124694_create_source_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%source}}', [
            'id' => $this->primaryKey(),
            'domain' => $this->string(),
            'title' => $this->string(),
            'description' => $this->string(),
            'status' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'links' => $this->string(),
            'start_parse' => $this->string(),
            'end_parse' => $this->string()
        ]);

        $this->addColumn('{{%source}}', 'theme_id', $this->integer());

        $this->createIndex(
            '{{%idx-source-theme_id}}',
            '{{%source}}',
            'theme_id'
        );

        $this->addForeignKey(
            '{{%fk-source-theme_id}}',
            '{{%source}}',
            'theme_id',
            '{{%theme}}',
            'id',
            'CASCADE'
        );
    }
}