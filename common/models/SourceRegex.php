<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "source_regex".
 *
 * @property int $id
 * @property int $source_id
 * @property int $regex_id
 *
 * @property Regex $regex
 * @property Source $source
 */
class SourceRegex extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'source_regex';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['source_id', 'regex_id'], 'required'],
            [['source_id', 'regex_id'], 'integer'],
            [['regex_id'], 'exist', 'skipOnError' => true, 'targetClass' => Regex::className(), 'targetAttribute' => ['regex_id' => 'id']],
            [['source_id'], 'exist', 'skipOnError' => true, 'targetClass' => Source::className(), 'targetAttribute' => ['source_id' => 'id']],
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
            'regex_id' => 'Regex ID',
        ];
    }

    /**
     * Gets query for [[Regex]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegex()
    {
        return $this->hasOne(Regex::className(), ['id' => 'regex_id']);
    }

    /**
     * Gets query for [[Source]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSource()
    {
        return $this->hasOne(Source::className(), ['id' => 'source_id']);
    }
}
