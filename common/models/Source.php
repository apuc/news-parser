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
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property string|null $links
 * @property string|null $start_parse
 * @property string|null $end_parse
 *
 * @property SourceTheme[] $sourceThemes
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
            [['status', 'created_at', 'updated_at'], 'integer'],
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
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'links' => 'Links',
            'start_parse' => 'Start Parse',
            'end_parse' => 'End Parse',
        ];
    }

    /**
     * Gets query for [[SourceThemes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSourceThemes()
    {
        return $this->hasMany(SourceTheme::className(), ['source_id' => 'id']);
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
