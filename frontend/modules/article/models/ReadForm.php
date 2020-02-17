<?php


namespace frontend\modules\article\models;


use common\classes\Debug;
use yii\base\Model;

class ReadForm extends Model
{
    public $csv;

    public function rules()
    {
        return [
            [['csv'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'csv' => '',
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->csv[0]->saveAs("articles/{$this->csv[0]->name}");
        } else return false;
    }
}