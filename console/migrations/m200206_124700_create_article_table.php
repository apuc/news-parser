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
            'name' => $this->string(),
            'article_source' => $this->string(),
            'source_type' => $this->string(),
            'text' => $this->text()
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
