<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%destination}}`.
 */
class m200414_094446_add_theme_column_to_destination_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%destination}}', 'theme', $this->string());
        $this->addColumn('{{%destination}}', 'keywords', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%destination}}', 'keywords');
        $this->dropColumn('{{%destination}}', 'theme');
    }
}
