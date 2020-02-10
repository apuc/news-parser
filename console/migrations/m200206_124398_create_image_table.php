<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%image}}`.
 */
class m200206_124398_create_image_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%image}}', [
            'id' => $this->primaryKey(),
            'src' => $this->string(),
            'alt' => $this->string(),
            'category_id' => $this->integer()
        ]);

        $this->createIndex(
            '{{%idx-image-category_id}}',
            '{{%image}}',
            'category_id'
        );

        $this->addForeignKey(
            '{{%fk-image-category_id}}',
            '{{%image}}',
            'category_id',
            '{{%category}}',
            'id',
            'CASCADE'
        );
    }
}