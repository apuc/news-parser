<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%source}}`.
 */
class m200604_084919_add_parse_type_column_to_source_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%source}}', 'parse_type', $this->integer());
        $this->addColumn('{{%source}}', 'regex', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%source}}', 'regex');
        $this->dropColumn('{{%source}}', 'parse_type');
    }
}
