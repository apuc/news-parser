<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%destination_article}}`.
 */
class m200206_133642_create_destination_article_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%destination_article}}', [
            'id' => $this->primaryKey(),
        ]);

        $this->addColumn('{{%destination_article}}', 'destination_id', $this->integer());

        $this->createIndex(
            '{{%idx-destination_article-destination_id}}',
            '{{%destination_article}}',
            'destination_id'
        );

        $this->addForeignKey(
            '{{%fk-destination_article-destination_id}}',
            '{{%destination_article}}',
            'destination_id',
            '{{%destination}}',
            'id',
            'CASCADE'
        );

        $this->addColumn('{{%destination_article}}', 'article_id', $this->integer());

        $this->createIndex(
            '{{%idx-destination_article-article_id}}',
            '{{%destination_article}}',
            'article_id'
        );

        $this->addForeignKey(
            '{{%fk-destination_article-article_id}}',
            '{{%destination_article}}',
            'article_id',
            '{{%article}}',
            'id',
            'CASCADE'
        );
    }
}
