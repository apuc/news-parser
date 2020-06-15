<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%destination_article}}`.
 */
class m200615_092121_add_status_column_to_destination_article_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%destination_article}}', 'status', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%destination_article}}', 'status');
    }
}
