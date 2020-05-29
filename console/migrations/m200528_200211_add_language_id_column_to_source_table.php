<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%source}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%language}}`
 */
class m200528_200211_add_language_id_column_to_source_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%source}}', 'language_id', $this->integer());

        // creates index for column `language_id`
        $this->createIndex(
            '{{%idx-source-language_id}}',
            '{{%source}}',
            'language_id'
        );

        // add foreign key for table `{{%language}}`
        $this->addForeignKey(
            '{{%fk-source-language_id}}',
            '{{%source}}',
            'language_id',
            '{{%language}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%language}}`
        $this->dropForeignKey(
            '{{%fk-source-language_id}}',
            '{{%source}}'
        );

        // drops index for column `language_id`
        $this->dropIndex(
            '{{%idx-source-language_id}}',
            '{{%source}}'
        );

        $this->dropColumn('{{%source}}', 'language_id');
    }
}
