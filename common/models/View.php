<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "view".
 *
 * @property int $id
 * @property int|null $created_at
 * @property string|null $ip
 * @property int|null $destination_id
 *
 * @property Destination $destination
 */
class View extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'view';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'destination_id'], 'integer'],
            [['ip'], 'string', 'max' => 255],
            [['destination_id'], 'exist', 'skipOnError' => true, 'targetClass' => Destination::className(), 'targetAttribute' => ['destination_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'ip' => 'Ip',
            'destination_id' => 'Destination ID',
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
}
