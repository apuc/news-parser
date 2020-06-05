<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%template}}`.
 */
class m200320_073709_add_columns_to_template_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%template}}', 'version', $this->string());
        $this->addColumn('{{%template}}', 'description', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%template}}', 'version');
        $this->dropColumn('{{%template}}', 'description');
    }
}
