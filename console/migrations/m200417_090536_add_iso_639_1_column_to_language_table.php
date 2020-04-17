<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%language}}`.
 */
class m200417_090536_add_iso_639_1_column_to_language_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%language}}', 'iso_639_1', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%language}}', 'iso_639_1');
    }
}
