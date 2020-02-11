<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%article_category}}`.
 */
class m200206_133660_create_article_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%article_category}}', [
            'id' => $this->primaryKey(),
        ]);

        $this->addColumn('{{%article_category}}', 'category_id', $this->integer());

        $this->createIndex(
            '{{%idx-article_category-category_id}}',
            '{{%article_category}}',
            'category_id'
        );

        $this->addForeignKey(
            '{{%fk-article_category-category_id}}',
            '{{%article_category}}',
            'category_id',
            '{{%category}}',
            'id',
            'CASCADE'
        );

        $this->addColumn('{{%article_category}}', 'article_id', $this->integer());

        $this->createIndex(
            '{{%idx-article_category-article_id}}',
            '{{%article_category}}',
            'article_id'
        );

        $this->addForeignKey(
            '{{%fk-article_category-article_id}}',
            '{{%article_category}}',
            'article_id',
            '{{%article}}',
            'id',
            'CASCADE'
        );
    }
}
