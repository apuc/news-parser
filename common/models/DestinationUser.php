<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "destination_user".
 *
 * @property int $id
 * @property int|null $destination_id
 * @property int|null $user_id
 *
 * @property Destination $destination
 * @property User $user
 */
class DestinationUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'destination_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['destination_id', 'user_id'], 'integer'],
            [['destination_id'], 'exist', 'skipOnError' => true, 'targetClass' => Destination::className(), 'targetAttribute' => ['destination_id' => 'id']],
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
            'destination_id' => 'Destination ID',
            'user_id' => 'User ID',
        ];
    }

    /**
     * Gets query for [[Destination]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDestination()
    {
        return $this->hasOne(Destination::className(), ['id' => 'destination_id']);
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
}
