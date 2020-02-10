<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $source_id
 * @property string|null $source_type
 * @property string|null $language
 * @property string|null $text
 * @property int|null $category_id
 * @property int|null $user_id
 *
 * @property Category $category
 * @property User $user
 * @property ArticleUser[] $articleUsers
 * @property DestinationArticle[] $destinationArticles
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
            [['category_id', 'user_id'], 'integer'],
            [['name', 'source_id', 'source_type', 'language'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'source_id' => 'Source ID',
            'source_type' => 'Source Type',
            'language' => 'Язык',
            'text' => 'Статья',
            'category_id' => 'Category ID',
            'user_id' => 'User ID',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
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
}
