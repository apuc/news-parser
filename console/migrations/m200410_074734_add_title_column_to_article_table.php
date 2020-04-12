<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%article}}`.
 */
class m200410_074734_add_title_column_to_article_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%article}}', 'title', $this->string());
        $this->addColumn('{{%article}}', 'description', $this->string());
        $this->addColumn('{{%article}}', 'keywords', $this->string());
        $this->addColumn('{{%article}}', 'url', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%article}}', 'url');
        $this->dropColumn('{{%article}}', 'keywords');
        $this->dropColumn('{{%article}}', 'description');
        $this->dropColumn('{{%article}}', 'title');
    }
}
