<?php

namespace common\models;

use common\classes\Debug;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $article_source
 * @property string|null $source_type
 * @property string|null $text
 * @property int|null $language_id
 *
 * @property Language $language
 * @property ArticleCategory[] $articleCategories
 * @property ArticleUser[] $articleUsers
 * @property DestinationArticle[] $destinationArticles
 * @property View[] $views
 */
class Article extends \yii\db\ActiveRecord
{
    public $category;
    public $destination;

    public function init()
    {
        $category = ArrayHelper::getColumn(
            ArticleCategory::find()
                ->where(['article_id' => \Yii::$app->request->get('id')])
                ->all(),
            'category_id'
        );

//        $destination = ArrayHelper::getColumn(
//            DestinationCategory::find()
//                ->where(['article_id' => \Yii::$app->request->get('id')])
//                ->innerJoin('article_category', 'destination_category.category_id = article_category.category_id')
//                ->all(),
//            'destination_id'
//        );

        if (!empty($category)) {
            $this->category = $category;
        }

//        if (!empty($destination)) {
//            $this->destination = $destination;
//        }
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
            [['language_id'], 'integer'],
            [['name', 'article_source', 'source_type'], 'string', 'max' => 255],
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
            'name' => 'Заголовок',
            'article_source' => 'Источник статьи',
            'source_type' => 'Тип источника',
            'text' => 'Статья',
            'language_id' => 'Язык',
        ];
    }

    /**
     * Gets query for [[Language]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'language_id']);
    }

    /**
     * Gets query for [[ArticleCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticleCategories()
    {
        return $this->hasMany(ArticleCategory::className(), ['article_id' => 'id']);
    }

    /**
     * Gets query for [[ArticleUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticleUsers()
    {
        return $this->hasMany(ArticleUser::className(), ['article_id' => 'id']);
    }

    /**
     * Gets query for [[DestinationArticles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDestinationArticles()
    {
        return $this->hasMany(DestinationArticle::className(), ['article_id' => 'id']);
    }

    /**
     * Gets query for [[Views]].
     *
     * @return \yii\db\ActiveQuery
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

    public function beforeSave($insert)
    {
        //$language = Language::findOne(['language' => 'Русский']);
        //$this->language_id = $language->id;
        $this->source_type = 'Добавлено вручную';
        $this->article_source = Yii::$app->user->identity->id;

        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        $post = \Yii::$app->request->post('Article');
        $category_ids = $post['category'];
        $selected_categories = ArticleCategory::find()->where(['article_id' => $this->id])->all();
        $new = array();
        $old = array();

        if($category_ids)
            foreach ($category_ids as $val)
                array_push($new, $val);

        if($selected_categories)
            foreach ($selected_categories as $selected_category)
                array_push($old, $selected_category->category_id);

        $add = array_diff($new, $old);
        $del = array_diff($old, $new);

        if($add)
            foreach ($add as $item) {
                $article_category  = new ArticleCategory();
                $article_category->article_id = $this->id;
                $article_category->category_id = $item;
                $article_category->save();
            }

        if($del)
            foreach ($del as $item)
                ArticleCategory::deleteAll(['article_id' => $this->id, 'category_id' => $item]);

        $destination_ids = $post['destination'];
        $existing_destinations = DestinationArticle::find()->where(['article_id' => $this->id])->all();
        $new_d = array();
        $old_d = array();

        if($destination_ids)
            foreach ($destination_ids as $val)
                array_push($new_d, $val);

        if($existing_destinations)
            foreach ($existing_destinations as $existing_destination)
                array_push($old_d, $existing_destination->destination_id);

        $add_d = array_diff($new_d, $old_d);
        $del_d = array_diff($old_d, $new_d);

        if($add_d)
            foreach ($add_d as $item) {
                $destination_article  = new DestinationArticle();
                $destination_article->article_id = $this->id;
                $destination_article->destination_id = $item;
                $destination_article->save();
            }

        if($del_d)
            foreach ($del_d as $item)
                DestinationArticle::deleteAll(['article_id' => $this->id, 'destination_id' => $item]);


        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }
}
