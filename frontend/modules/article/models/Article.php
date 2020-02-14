<?php


namespace frontend\modules\article\models;


use common\classes\Debug;
use common\models\Language;
use Yii;

class Article extends \common\models\Article
{
    public function init()
    {
        parent::init();
    }

    public function beforeSave($insert)
    {
        $language = Language::findOne(['language' => 'Русский']);
        $this->language_id = $language->id;
        $this->source_type = 'Добавлено вручную';
        $this->article_source = Yii::$app->user->identity->id;

        return parent::beforeSave($insert);
    }
}