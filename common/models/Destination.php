<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "destination".
 *
 * @property int $id
 * @property string|null $domain
 * @property int|null $theme_id
 * @property int|null $user_id
 *
 * @property Theme $theme
 * @property User $user
 * @property DestinationArticle[] $destinationArticles
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
            [['theme_id', 'user_id'], 'integer'],
            [['domain'], 'string', 'max' => 255],
            [['theme_id'], 'exist', 'skipOnError' => true, 'targetClass' => Theme::className(), 'targetAttribute' => ['theme_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'theme_id' => 'Theme ID',
            'user_id' => 'User ID',
        ];
    }

    /**
     * Gets query for [[Theme]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTheme()
    {
        return $this->hasOne(Theme::className(), ['id' => 'theme_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
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
