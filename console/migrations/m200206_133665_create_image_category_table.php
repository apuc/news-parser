<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%image_category}}`.
 */
class m200206_133665_create_image_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%image_category}}', [
            'id' => $this->primaryKey(),
        ]);

        $this->addColumn('{{%image_category}}', 'category_id', $this->integer());

        $this->createIndex(
            '{{%idx-image_category-category_id}}',
            '{{%image_category}}',
            'category_id'
        );

        $this->addForeignKey(
            '{{%fk-image_category-category_id}}',
            '{{%image_category}}',
            'category_id',
            '{{%category}}',
            'id',
            'CASCADE'
        );

        $this->addColumn('{{%image_category}}', 'image_id', $this->integer());

        $this->createIndex(
            '{{%idx-image_category-image_id}}',
            '{{%image_category}}',
            'image_id'
        );

        $this->addForeignKey(
            '{{%fk-image_category-image_id}}',
            '{{%image_category}}',
            'image_id',
            '{{%image}}',
            'id',
            'CASCADE'
        );
    }
}
