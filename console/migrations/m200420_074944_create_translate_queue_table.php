<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%translate_queue}}`.
 */
class m200420_074944_create_translate_queue_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%translate_queue}}', [
            'id' => $this->primaryKey(),
            'article_id' => $this->integer(),
            'language_id' => $this->integer()
        ]);
    }
}