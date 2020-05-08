<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%source}}`.
 */
class m200508_074041_add_parent_id_column_to_source_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%source}}', 'parent_id', $this->integer());
        $this->addColumn('{{%source}}', 'links_rule', $this->string());
        $this->addColumn('{{%source}}', 'title_rule', $this->string());
        $this->addColumn('{{%source}}', 'article_rule', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%source}}', 'parent_id');
    }
}
