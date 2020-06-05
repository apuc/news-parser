<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%parse_queue}}`.
 */
class m200512_131559_create_parse_queue_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%parse_queue}}', [
            'id' => $this->primaryKey(),
            'source_id' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%parse_queue}}');
    }
}
