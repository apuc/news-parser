<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "regex".
 *
 * @property int $id
 * @property string|null $regex
 * @property string|null $sample
 *
 * @property SourceRegex[] $sourceRegexes
 */
class Regex extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'regex';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['regex', 'sample'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'regex' => 'Регулярное выражение',
            'sample' => 'Пример',
        ];
    }

    /**
     * Gets query for [[SourceRegexes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSourceRegexes()
    {
        return $this->hasMany(SourceRegex::className(), ['regex_id' => 'id']);
    }
}
