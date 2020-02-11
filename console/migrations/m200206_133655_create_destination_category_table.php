<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%destination_category}}`.
 */
class m200206_133655_create_destination_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%destination_category}}', [
            'id' => $this->primaryKey(),
        ]);

        $this->addColumn('{{%destination_category}}', 'destination_id', $this->integer());

        $this->createIndex(
            '{{%idx-destination_category-destination_id}}',
            '{{%destination_category}}',
            'destination_id'
        );

        $this->addForeignKey(
            '{{%fk-destination_category-destination_id}}',
            '{{%destination_category}}',
            'destination_id',
            '{{%destination}}',
            'id',
            'CASCADE'
        );

        $this->addColumn('{{%destination_category}}', 'category_id', $this->integer());

        $this->createIndex(
            '{{%idx-destination_category-category_id}}',
            '{{%destination_category}}',
            'category_id'
        );

        $this->addForeignKey(
            '{{%fk-destination_category-category_id}}',
            '{{%destination_category}}',
            'category_id',
            '{{%category}}',
            'id',
            'CASCADE'
        );
    }
}
