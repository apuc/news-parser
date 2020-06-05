<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%regex}}`.
 */
class m200605_075212_create_regex_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%regex}}', [
            'id' => $this->primaryKey(),
            'regex' => $this->string(),
            'sample' => $this->string()
        ]);
    }
}
