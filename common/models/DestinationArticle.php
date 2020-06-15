<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "destination_article".
 *
 * @property int $id
 * @property int|null $destination_id
 * @property int|null $article_id
 * @property int|null $status
 *
 * @property Article $article
 * @property Destination $destination
 */
class DestinationArticle extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'destination_article';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['destination_id', 'article_id', 'status'], 'integer'],
            [['article_id'], 'exist', 'skipOnError' => true, 'targetClass' => Article::className(), 'targetAttribute' => ['article_id' => 'id']],
            [['destination_id'], 'exist', 'skipOnError' => true, 'targetClass' => Destination::className(), 'targetAttribute' => ['destination_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'destination_id' => 'Destination ID',
            'article_id' => 'Article ID',
        ];
    }

    /**
     * Gets query for [[Article]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(Article::className(), ['id' => 'article_id']);
    }

    /**
     * Gets query for [[Destination]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDestination()
    {
        return $this->hasOne(Destination::className(), ['id' => 'destination_id']);
    }

    public function _save($article_id, $destination_id, $status) {
        $this->article_id = $article_id;
        $this->destination_id = $destination_id;
        $this->status = $status;
        $this->save();
    }
}
