<?php


namespace frontend\models;


use yii\base\Model;

class SettingsForm extends Model
{
    public $theme;
    public $title;
    public $keywords;
    public $description;
    public $h1;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['theme', 'title', 'keywords', 'description', 'h1'], 'safe'],
        ];
    }
}