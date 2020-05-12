<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "parse_queue".
 *
 * @property int $id
 * @property int|null $source_id
 */
class ParseQueue extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'parse_queue';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['source_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'source_id' => 'Source ID',
        ];
    }
}
