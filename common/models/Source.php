<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "source".
 *
 * @property int $id
 * @property string|null $domain
 * @property string|null $title
 * @property string|null $description
 * @property string|null $links
 * @property string|null $start_parse
 * @property string|null $end_parse
 * @property int|null $status
 * @property int|null $parent_id
 * @property int|null $language_id
 * @property string|null $links_rule
 * @property string|null $title_rule
 * @property string|null $article_rule
 * @property int|null $parse_type
 * @property string|null $regex
 *
 * @property SourceCategory[] $sourceCategories
 * @property SourceUser[] $sourceUsers
 */
class Source extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'source';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'parent_id', 'language_id', 'parse_type'], 'integer'],
            [['domain', 'title', 'description', 'links', 'start_parse', 'end_parse', 'links_rule', 'title_rule',
                'article_rule', 'regex'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'domain' => 'Домен',
            'title' => 'Тайтл',
            'description' => 'Описание', // unnecessary
            'links' => 'Links', // unnecessary
            'status' => 'Статус',
            'parent_id' => 'Главный домен',
            'links_rule' => 'Правило парсинга ссылок на статьи',
            'title_rule' => 'Правило парсинга заголовка',
            'article_rule' => 'Правило парсинга статьи',
            'start_parse' => 'Стартовая точка парсинга',
            'end_parse' => 'Конечная точка парсинга',
            'language_id' => 'Язык',
            'parse_type' => 'Тип парсинга',
            'regex' => 'Регулярное выражение'
        ];
    }

    /**
     * Gets query for [[SourceCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSourceCategories()
    {
        return $this->hasMany(SourceCategory::className(), ['source_id' => 'id']);
    }

    /**
     * Gets query for [[SourceUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSourceUsers()
    {
        return $this->hasMany(SourceUser::className(), ['source_id' => 'id']);
    }

    public static function getCategory($data)
    {
        $result = '';
        if($data->sourceCategories)
            foreach ($data->sourceCategories as $value) {
                $category = Category::findOne($value->category_id);
                $result .= $category->name . ', ';
            }

        $result = substr($result, 0, strlen($result)-2);

        return $result;
    }
}
