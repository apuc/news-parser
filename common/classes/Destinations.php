<?php


namespace common\classes;

/**
 * @property int $destinations_ids
 */

class Destinations extends \yii\db\ActiveRecord
{
    public $destinations_ids;

    public function rules()
    {
        return [
            [['destinations_ids'], 'integer'],
        ];
    }

}