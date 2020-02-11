<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%destination}}`.
 */
class m200206_124624_create_destination_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%destination}}', [
            'id' => $this->primaryKey(),
            'domain' => $this->string(),
            'title' => $this->string(),
            'description' => $this->string(),
            'status' => $this->integer()
        ]);
    }
}
