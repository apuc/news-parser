<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

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
        $category = ArrayHelper::getColumn(
            ArticleCategory::find()
                //->where(['article_id' => \Yii::$app->request->get('id')])
                ->all(),
            'category_id'
        );

        if (!empty($category))
            $this->category = $category;
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
            [['name', 'title', 'description', 'keywords', 'url'], 'string', 'max' => 255],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['language_id' => 'id']],
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
            'url' => 'URL'
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
        if($data->articleCategories) {
            foreach ($data->articleCategories as $value) {
                $category = Category::findOne($value->category_id);
                $result .= $category->name . ', ';
            }
        }
        $result = substr($result, 0, strlen($result)-2);
        return $result;
    }

    public static function getDestination($data)
    {
        $result = '';
        if($data->articleCategories) {
            foreach ($data->destinationArticles as $value) {
                $destination = Destination::findOne($value->destination_id);
                $result .= $destination->domain . ', ';
            }
        }
        $result = substr($result, 0, strlen($result)-2);
        return $result;
    }

    public function beforeSave($insert)
    {
        ($this->source_type) ? $this->source_type : $this->source_type = 1;
        ($this->source_id) ? $this->source_id : $this->source_id = Yii::$app->user->identity->id;
        ($this->parent_id) ? $this->parent_id : $this->parent_id = 0;
//        ($this->title) ? $this->title : $this->title = 'not set';
//        ($this->keywords) ? $this->keywords : $this->keywords = 'not set';
//        ($this->description) ? $this->description : $this->description = 'not set';

        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
//        $post = \Yii::$app->request->post('Article');
//        $category_ids = $post['category'];
//        $selected_categories = ArticleCategory::find()->where(['article_id' => $this->id])->all();
//
//        $new = array();
//        if($category_ids)
//            foreach ($category_ids as $val)
//                array_push($new, $val);
//
//        $old = array();
//        if($selected_categories)
//            foreach ($selected_categories as $selected_category)
//                array_push($old, $selected_category->category_id);
//
//        $add = array_diff($new, $old);
//        $del = array_diff($old, $new);
//
//        if($add)
//            foreach ($add as $item) {
//                $article_category  = new ArticleCategory();
//                $article_category->article_id = $this->id;
//                $article_category->category_id = $item;
//                $article_category->save();
//            }
//
//        if($del)
//            foreach ($del as $item)
//                ArticleCategory::deleteAll(['article_id' => $this->id, 'category_id' => $item]);
//
//        $destination_ids = $post['destination'];
//        $existing_destinations = DestinationArticle::find()->where(['article_id' => $this->id])->all();
//
//        $new = array();
//        if($destination_ids)
//            foreach ($destination_ids as $val)
//                array_push($new, $val);
//
//        $old = array();
//        if($existing_destinations)
//            foreach ($existing_destinations as $existing_destination)
//                array_push($old, $existing_destination->destination_id);
//
//        $add = array_diff($new, $old);
//        $del = array_diff($old, $new);
//
//        if($add)
//            foreach ($add as $item) {
//                $destination_article  = new DestinationArticle();
//                $destination_article->article_id = $this->id;
//                $destination_article->destination_id = $item;
//                $destination_article->save();
//            }
//
//        if($del)
//            foreach ($del as $item)
//                DestinationArticle::deleteAll(['article_id' => $this->id, 'destination_id' => $item]);

        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }
}