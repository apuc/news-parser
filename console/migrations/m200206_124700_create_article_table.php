<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%article}}`.
 */
class m200206_124700_create_article_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%article}}', [
            'id' => $this->primaryKey(),
            'source_id' => $this->integer(),
            'source_type' => $this->integer(),
            'parent_id' => $this->integer(),
            'name' => $this->string(),
            'text' => $this->text(),
            'title' => $this->string(),
            'description' => $this->string(),
            'keywords' => $this->string(),
            'url' => $this->string()
        ]);

        $this->addColumn('{{%article}}', 'language_id', $this->integer());

        $this->createIndex(
            '{{%idx-article-language_id}}',
            '{{%article}}',
            'language_id'
        );

        $this->addForeignKey(
            '{{%fk-article-language_id}}',
            '{{%article}}',
            'language_id',
            '{{%language}}',
            'id',
            'CASCADE'
        );
    }
}
