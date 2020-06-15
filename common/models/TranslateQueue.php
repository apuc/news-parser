<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "translate_queue".
 *
 * @property int $id
 * @property int|null $article_id
 * @property int|null $language_id
 */
class TranslateQueue extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'translate_queue';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['article_id', 'language_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'article_id' => 'Article ID',
            'language_id' => 'Language ID',
        ];
    }

    public function _save($article_id, $language_id) {
        $this->article_id = $article_id;
        $this->language_id = $language_id;
        $this->save();
    }
}
