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
            [['csv'], 'file', 'extensions' => 'csv'],
            [['csv'], 'safe'],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->csv->saveAs("articles/{$this->csv->baseName}.{$this->csv->extension}");
        } else return false;
    }
}