<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "image".
 *
 * @property int $id
 * @property string|null $src
 * @property string|null $alt
 *
 * @property ImageCategory[] $imageCategories
 */
class Image extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'image';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['src', 'alt'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'src' => 'Src',
            'alt' => 'Alt',
        ];
    }

    /**
     * Gets query for [[ImageCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImageCategories()
    {
        return $this->hasMany(ImageCategory::className(), ['image_id' => 'id']);
    }
}
