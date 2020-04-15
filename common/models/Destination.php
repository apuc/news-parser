<?php

namespace common\models;

use common\classes\Debug;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "destination".
 *
 * @property int $id
 * @property string|null $domain
 * @property string|null $title
 * @property string|null $description
 * @property string|null $theme
 * @property string|null $keywords
 * @property int|null $status
 *
 * @property DestinationArticle[] $destinationArticles
 * @property DestinationCategory[] $destinationCategories
 * @property DestinationUser[] $destinationUsers
 * @property View[] $views
 *
 */
class Destination extends \yii\db\ActiveRecord
{
    public $category;
//    public $flag;

    public function init()
    {
        $category = ArrayHelper::getColumn(
            DestinationCategory::find()->where(['destination_id' => \Yii::$app->request->get('id')])->all(),
            'category_id'
        );

        if (!empty($category)) {
            $this->category = $category;
        }

//        $this->flag = 0;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'destination';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['domain', 'title', 'description', 'theme', 'keywords'], 'string', 'max' => 255],
            [['category', 'flag'], 'safe']
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
            'title' => 'Title',
            'description' => 'Description',
            'status' => 'Status',
            'theme' => 'Тема',
            'keywords' => 'Keywords'
        ];
    }

    /**
     * Gets query for [[DestinationArticles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDestinationArticles()
    {
        return $this->hasMany(DestinationArticle::className(), ['destination_id' => 'id']);
    }

    /**
     * Gets query for [[DestinationCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDestinationCategories()
    {
        return $this->hasMany(DestinationCategory::className(), ['destination_id' => 'id']);
    }

    /**
     * Gets query for [[DestinationUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDestinationUsers()
    {
        return $this->hasMany(DestinationUser::className(), ['destination_id' => 'id']);
    }

    /**
     * Gets query for [[Views]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getViews()
    {
        return $this->hasMany(View::className(), ['destination_id' => 'id']);
    }

//    public function afterSave($insert, $changedAttributes)
//    {
//        $post = \Yii::$app->request->post('Destination');
//
//        if(!isset($post['flag'])) {
//            $category_ids = $post['category'];
//            $selected_categories = DestinationCategory::find()->where(['destination_id' => $this->id])->all();
//            $new = array();
//            $old = array();
//
//            if($category_ids)
//                foreach ($category_ids as $val)
//                    array_push($new, $val);
//
//            if($selected_categories)
//                foreach ($selected_categories as $selected_category)
//                    array_push($old, $selected_category->category_id);
//
//            $add = array_diff($new, $old);
//            $del = array_diff($old, $new);
//
//            if($add)
//                foreach ($add as $item) {
//                    $article_category  = new DestinationCategory();
//                    $article_category->destination_id = $this->id;
//                    $article_category->category_id = $item;
//                    $article_category->save();
//                }
//
//            if($del)
//                foreach ($del as $item)
//                    DestinationCategory::deleteAll(['destination_id' => $this->id, 'category_id' => $item]);
//
//            parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
//        }
//    }

    public static function getCategory($data)
    {
        $result = '';
        if($data->destinationCategories) {
            foreach ($data->destinationCategories as $value) {
                $category = Category::findOne($value->category_id);
                $result .= $category->name . ', ';
            }
        }
        $result = substr($result, 0, strlen($result)-2);
        return $result;
    }
}
