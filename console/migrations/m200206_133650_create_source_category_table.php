<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%source_category}}`.
 */
class m200206_133650_create_source_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%source_category}}', [
            'id' => $this->primaryKey(),
        ]);

        $this->addColumn('{{%source_category}}', 'source_id', $this->integer());

        $this->createIndex(
            '{{%idx-source_category-source_id}}',
            '{{%source_category}}',
            'source_id'
        );

        $this->addForeignKey(
            '{{%fk-source_category-source_id}}',
            '{{%source_category}}',
            'source_id',
            '{{%source}}',
            'id',
            'CASCADE'
        );

        $this->addColumn('{{%source_category}}', 'category_id', $this->integer());

        $this->createIndex(
            '{{%idx-source_category-category_id}}',
            '{{%source_category}}',
            'category_id'
        );

        $this->addForeignKey(
            '{{%fk-source_category-category_id}}',
            '{{%source_category}}',
            'category_id',
            '{{%category}}',
            'id',
            'CASCADE'
        );
    }
}
