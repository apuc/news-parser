<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%template}}`.
 */
class m200206_124217_create_template_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%template}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()
        ]);
    }
}
