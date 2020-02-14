<?php

use yii\db\Migration;


class m200214_064733_create_title_queue_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%title_queue}}', [
            'id' => $this->primaryKey(),
        ]);

        $this->addColumn('{{%title_queue}}', 'source_id', $this->integer());

        $this->createIndex(
            '{{%idx-title_queue-source_id}}',
            '{{%title_queue}}',
            'source_id'
        );

        $this->addForeignKey(
            '{{%fk-title_queue-source_id}}',
            '{{%title_queue}}',
            'source_id',
            '{{%source}}',
            'id',
            'CASCADE'
        );

        $this->addColumn('{{%title_queue}}', 'destination_id', $this->integer());

        $this->createIndex(
            '{{%idx-title_queue-destination_id}}',
            '{{%title_queue}}',
            'destination_id'
        );

        $this->addForeignKey(
            '{{%fk-title_queue-destination_id}}',
            '{{%title_queue}}',
            'destination_id',
            '{{%destination}}',
            'id',
            'CASCADE'
        );
    }
}
