<?php

namespace common\models;

use common\classes\Debug;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property int|null $source_id
 * @property int|null $source_type
 * @property int|null $parent_id
 * @property string|null $name
 * @property string|null $text
 * @property int|null $language_id
 * @property string|null $title
 * @property string|null $description
 * @property string|null $keywords
 * @property string|null $url
 * @property string|null $new_url
 *
 * @property Language $language
 * @property ArticleCategory[] $articleCategories
 * @property DestinationArticle[] $destinationArticles
 * @property View[] $views
 */
class Article extends ActiveRecord
{
    public $category;
    public $destination;

    public function init()
    {
//        $category = ArrayHelper::getColumn(
//            ArticleCategory::find()
//                //->where(['article_id' => \Yii::$app->request->get('id')])
//                ->all(),
//            'category_id'
//        );

//        if (!empty($category))
//            $this->category = $category;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text'], 'string'],
            [['language_id', 'source_id', 'source_type', 'parent_id'], 'integer'],
            [['name', 'title', 'description', 'keywords', 'url', 'new_url'], 'string', 'max' => 255],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(),
                'targetAttribute' => ['language_id' => 'id']],
            [['category', 'destination'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'source_id' => 'Источник статьи',
            'source_type' => 'Тип источника',
            'parent_id' => 'Оригинал статьи',
            'name' => 'Заголовок',
            'text' => 'Статья',
            'language_id' => 'Язык',
            'title' => 'Title',
            'description' => 'Description',
            'keywords' => 'Keywords',
            'url' => 'Url',
            'new_url' => 'Url на сайте размещения'
        ];
    }

    /**
     * Gets query for [[Language]].
     *
     * @return ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'language_id']);
    }

    /**
     * Gets query for [[ArticleCategories]].
     *
     * @return ActiveQuery
     */
    public function getArticleCategories()
    {
        return $this->hasMany(ArticleCategory::className(), ['article_id' => 'id']);
    }

    /**
     * Gets query for [[DestinationArticles]].
     *
     * @return ActiveQuery
     */
    public function getDestinationArticles()
    {
        return $this->hasMany(DestinationArticle::className(), ['article_id' => 'id']);
    }

    /**
     * Gets query for [[Views]].
     *
     * @return ActiveQuery
     */
    public function getViews()
    {
        return $this->hasMany(View::className(), ['article_id' => 'id']);
    }

    public static function getCategory($data)
    {
        $result = '';
        if($data->articleCategories)
            foreach ($data->articleCategories as $value) {
                $category = Category::findOne($value->category_id);
                $result .= $category->name . ', ';
            }

        $result = substr($result, 0, strlen($result)-2);

        return $result;
    }

    public static function getDestination($data)
    {
        $result = '';
        if($data->destinationArticles)
            foreach ($data->destinationArticles as $value) {
                $destination = Destination::findOne($value->destination_id);
                $result .= $destination->domain . ', ';
            }

        $result = substr($result, 0, strlen($result)-2);

        return $result;
    }

    public function beforeSave($insert)
    {
        ($this->source_type) ? $this->source_type : $this->source_type = 1;
        ($this->source_id) ? $this->source_id : $this->source_id = Yii::$app->user->identity->id;
        ($this->parent_id) ? $this->parent_id : $this->parent_id = 0;

        return parent::beforeSave($insert);
    }

    public function save_parse($title, $text, $url, $source_id)
    {
        $source = Source::findOne($source_id);
        $source_categories = SourceCategory::find()->where(['source_id' => $source_id])->all();

        $this->name = $title;
        $this->text = $text;
        $this->source_type = 4;
        $this->source_id = $source_id;
        $this->url = $url;
        $this->title = $title;
        $this->description = $this->description($text);
        $this->language_id = $source->language_id;

        $this->save();

        foreach ($source_categories as $category) {
            $ac = new ArticleCategory();
            $ac->article_id = $this->id;
            $ac->category_id = $category->category_id;
            $ac->save();
        }
    }

    public function description($text)
    {
        $regex = Regex::find()->all();
        foreach ($regex as $item)
            $text = preg_replace($item->regex, '', $text);
        $text = str_replace(['});', "\n"], '', $text);
        $text = substr(strip_tags($text), 0, 220) . ' ...';

        return $text;
    }
}