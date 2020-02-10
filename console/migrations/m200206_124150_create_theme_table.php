<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%theme}}`.
 */
class m200206_124150_create_theme_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%theme}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer(),
            'name' => $this->string()
        ]);
    }
}
