<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "destination".
 *
 * @property int $id
 * @property string|null $domain
 * @property string|null $title
 * @property string|null $description
 * @property int|null $status
 *
 * @property DestinationArticle[] $destinationArticles
 * @property DestinationCategory[] $destinationCategories
 * @property DestinationUser[] $destinationUsers
 * @property View[] $views
 */
class Destination extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'destination';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['domain', 'title', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'domain' => 'Domain',
            'title' => 'Title',
            'description' => 'Description',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[DestinationArticles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDestinationArticles()
    {
        return $this->hasMany(DestinationArticle::className(), ['destination_id' => 'id']);
    }

    /**
     * Gets query for [[DestinationCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDestinationCategories()
    {
        return $this->hasMany(DestinationCategory::className(), ['destination_id' => 'id']);
    }

    /**
     * Gets query for [[DestinationUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDestinationUsers()
    {
        return $this->hasMany(DestinationUser::className(), ['destination_id' => 'id']);
    }

    /**
     * Gets query for [[Views]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getViews()
    {
        return $this->hasMany(View::className(), ['destination_id' => 'id']);
    }
}
