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
            [['status'], 'integer'],
            [['domain', 'title', 'description', 'links', 'start_parse', 'end_parse'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'domain' => 'Domain',
            'title' => 'Title',
            'description' => 'Description',
            'links' => 'Links',
            'start_parse' => 'Start Parse',
            'end_parse' => 'End Parse',
            'status' => 'Status',
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
}
