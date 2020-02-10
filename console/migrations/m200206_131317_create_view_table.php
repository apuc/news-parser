<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%view}}`.
 */
class m200206_131317_create_view_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%view}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer(),
            'ip' => $this->string(),
        ]);

        $this->addColumn('{{%view}}', 'destination_id', $this->integer());

        $this->createIndex(
            '{{%idx-view-destination_id}}',
            '{{%view}}',
            'destination_id'
        );

        $this->addForeignKey(
            '{{%fk-view-destination_id}}',
            '{{%view}}',
            'destination_id',
            '{{%destination}}',
            'id',
            'CASCADE'
        );
    }
}
