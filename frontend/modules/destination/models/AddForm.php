<?php


namespace frontend\modules\destination\models;


use yii\base\Model;

class AddForm extends Model
{
    public $domains;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['domains', 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'domains' => '',
        ];
    }
}