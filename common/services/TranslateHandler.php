<?php


namespace common\services;


use common\classes\Debug;
use common\models\Article;
use common\models\Language;


class TranslateHandler
{
    protected $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function makeTranslate($article_id, $language_id)
    {
        $article = Article::findOne($article_id);
        $parent = Article::findOne($article->parent_id);
        $target_language = Language::findOne($language_id);

        $allow = true;

        if(!$parent)
            if(!$article->language_id)
                $language = '';
            else {
                $source_language = Language::findOne($article->language_id);
                $language = $source_language->iso_639_1;
            }
        else {
            if(!$parent->language_id)
                $language = '';
            else {
                $parent_language = Language::findOne($parent->language_id);
                $language = $parent_language->iso_639_1;
            }

            if ($language == $target_language->iso_639_1)
                $allow = false;
        }

        if ($allow) {
            $count = 0; $name = null; $text = null; $title = null; $keywords = null; $description = null;

            while (!$name) {
                try {
                    echo 'we\'re in try' . "\n";
                    $translate_service = new TranslateService($this->type, rand(0,9));
                    echo 'Step: ' . $count++ . "\n";

                    $translate_service->setLocales($language, $target_language->iso_639_1);

                    $name =  $translate_service->translate($this->type, $article->name);
                    if($name) {
                        $title = $translate_service->translate($this->type,
                            (!empty($article->title)) ? $article->title : $article->name);
                        $keywords = $translate_service->translate($this->type,
                            (!empty($article->keywords)) ? $article->keywords : 'null');
                        $description = $translate_service->translate($this->type,
                            (!empty($article->description)) ? $article->description : 'null');
                        $text = $translate_service->translate($this->type, $article->text);
                    }
                } catch (\Exception $e) {
                    echo $e . "\n";
                }
            }

            $existed = Article::findOne(['source_id' => $article_id, 'language_id' => $target_language->id,
                'source_type' => 3]);

            if (!$existed)
                $this->setTranslate(new Article(), $article, $target_language, $name, $text, $title, $keywords,
                    $description);
            else
                $this->setTranslate($existed, $article, $target_language, $name, $text, $title, $keywords,
                    $description);
        }
    }

    public function setTranslate($model, $data, $target_language, $name, $text, $title, $keywords, $description)
    {
        $model->source_id = $data->id;
        $model->source_type = 3;
        $model->parent_id = ($data->source_type == 3) ? $data->parent_id : $data->id;
        $model->name = $name;
        $model->text = $text;
        $model->language_id = $target_language->id;
        $model->title = $title;
        $model->keywords = $keywords;
        $model->description = $description;
        $model->url = $data->url;
        $model->save();

        return $model->id;
    }
}