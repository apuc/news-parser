<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%sending_queue}}`.
 */
class m200604_122059_create_sending_queue_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%sending_queue}}', [
            'id' => $this->primaryKey(),
        ]);

        $this->addColumn('{{%sending_queue}}', 'destination_id', $this->integer());

        $this->createIndex(
            '{{%idx-sending_queue-destination_id}}',
            '{{%sending_queue}}',
            'destination_id'
        );

        $this->addForeignKey(
            '{{%fk-sending_queue-destination_id}}',
            '{{%sending_queue}}',
            'destination_id',
            '{{%destination}}',
            'id',
            'CASCADE'
        );

        $this->addColumn('{{%sending_queue}}', 'article_id', $this->integer());

        $this->createIndex(
            '{{%idx-sending_queue-article_id}}',
            '{{%sending_queue}}',
            'article_id'
        );

        $this->addForeignKey(
            '{{%fk-sending_queue-article_id}}',
            '{{%sending_queue}}',
            'article_id',
            '{{%article}}',
            'id',
            'CASCADE'
        );
    }
}
