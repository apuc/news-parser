<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%article_user}}`.
 */
class m200206_133644_create_article_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%article_user}}', [
            'id' => $this->primaryKey(),
        ]);

        $this->addColumn('{{%article_user}}', 'user_id', $this->integer());

        $this->createIndex(
            '{{%idx-article_user-user_id}}',
            '{{%article_user}}',
            'user_id'
        );

        $this->addForeignKey(
            '{{%fk-article_user-user_id}}',
            '{{%article_user}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        $this->addColumn('{{%article_user}}', 'article_id', $this->integer());

        $this->createIndex(
            '{{%idx-article_user-article_id}}',
            '{{%article_user}}',
            'article_id'
        );

        $this->addForeignKey(
            '{{%fk-article_user-article_id}}',
            '{{%article_user}}',
            'article_id',
            '{{%article}}',
            'id',
            'CASCADE'
        );
    }
}
