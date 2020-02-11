<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%language}}`.
 */
class m200206_124060_create_language_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%language}}', [
            'id' => $this->primaryKey(),
            'language' => $this->string()
        ]);
    }
}
