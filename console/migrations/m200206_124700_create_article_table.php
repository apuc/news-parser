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
            'source_id' => $this->string(),
            'source_type' => $this->string(),
            'language' => $this->string(),
            'text' => $this->text()
        ]);

        $this->addColumn('{{%article}}', 'category_id', $this->integer());

        $this->createIndex(
            '{{%idx-article-category_id}}',
            '{{%article}}',
            'category_id'
        );

        $this->addForeignKey(
            '{{%fk-article-category_id}}',
            '{{%article}}',
            'category_id',
            '{{%category}}',
            'id',
            'CASCADE'
        );

        $this->addColumn('{{%article}}', 'user_id', $this->integer());

        $this->createIndex(
            '{{%idx-article-user_id}}',
            '{{%article}}',
            'user_id'
        );

        $this->addForeignKey(
            '{{%fk-article-user_id}}',
            '{{%article}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }
}
