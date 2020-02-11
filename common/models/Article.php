<?php

namespace common\models;

use Yii;

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
}
