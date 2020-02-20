<?php

namespace frontend\modules\api\controllers;

use common\models\Article;
use common\models\ArticleCategory;
use common\models\Destination;
use common\models\DestinationCategory;
use common\models\Source;
use common\models\TitleQueue;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;


class ApiController extends Controller
{
    public function actionType()
    {
        if (Yii::$app->request->isAjax) {
            $result = array();
            switch ($_POST['value']) {
                case 'Получено с сайта':
                    $result = ArrayHelper::map(Source::find()->all(), 'id', 'domain');
                    break;
                case 'Автоматический перевод': //add where language
                    $result = ArrayHelper::map(Article::find()->all(), 'id', 'name');
                    break;
                case 'Добавлено вручную':
                    $result[Yii::$app->user->identity->id] = Yii::$app->user->identity->username;
                    break;
                case 'Считано из файла':
                    $result['имя файла'] = 'имя файла';
                    break;
                default:
                    break;
            }

            return json_encode($result);
        }
    }

    public function actionTitlesource()
    {
        if (Yii::$app->request->isAjax) {
            $keys = $_POST['keys'];
            if ($keys)
                foreach ($keys as $key) {
                    $audit = new TitleQueue();
                    $audit->source_id = $key;
                    $audit->save();
                }
        }
    }

    public function actionTitledestination()
    {
        if (Yii::$app->request->isAjax) {
            $keys = $_POST['keys'];
            if ($keys)
                foreach ($keys as $key) {
                    $audit = new TitleQueue();
                    $audit->destination_id = $key;
                    $audit->save();
                }
        }
    }

    public function actionRead()
    {
        if (Yii::$app->request->isAjax) {
            $filename = $_POST['filename'];
            if (($handle = fopen('articles/' . $filename, 'r')) !== FALSE) {
                while (($data = fgetcsv($handle, 0, ',', '"')) !== FALSE) {
                    $article = new \frontend\modules\article\models\Article();
                    $article->name = $data[0];
                    $article->text = $data[1];
                    $article->save();
                }
                fclose($handle);
            }
        }
    }

    public function actionSelected()
    {
        $themes = array();
        if (Yii::$app->request->isAjax) {
            $site = Article::findOne($_POST['id']);
            if (isset($site->articleCategories)) {
                foreach ($site->articleCategories as $val) {
                    array_push($themes, $val->category_id);
                }
            }
        }
        return json_encode($themes);
    }

    public function actionCategory()
    {
        if (Yii::$app->request->isAjax) {
            $category_ids = json_decode($_POST['category_ids']);
            $selected_categories = ArticleCategory::find()->where(['article_id' => $_POST['article_id']])->all();
            $new = array();
            $old = array();

            if ($category_ids)
                foreach ($category_ids as $val)
                    array_push($new, $val->id);

            if ($selected_categories)
                foreach ($selected_categories as $selected_category)
                    array_push($old, $selected_category->category_id);

            $add = array_diff($new, $old);
            $del = array_diff($old, $new);

            if ($add)
                foreach ($add as $item) {
                    $article_category = new ArticleCategory();
                    $article_category->article_id = $_POST['article_id'];
                    $article_category->category_id = $item;
                    $article_category->save();
                }

            if ($del)
                foreach ($del as $item)
                    ArticleCategory::deleteAll(['article_id' => $_POST['article_id'], 'category_id' => $item]);
        }
    }

    public function actionDselected()
    {
        $themes = array();
        if (Yii::$app->request->isAjax) {
            $site = Destination::findOne($_POST['id']);
            if (isset($site->destinationCategories)) {
                foreach ($site->destinationCategories as $val) {
                    array_push($themes, $val->category_id);
                }
            }
        }
        return json_encode($themes);
    }

    public function actionDcategory()
    {
        if (Yii::$app->request->isAjax) {
            $category_ids = json_decode($_POST['category_ids']);
            $selected_categories = DestinationCategory::find()->where(['destination_id' => $_POST['destination_id']])->all();
            $new = array();
            $old = array();

            if ($category_ids)
                foreach ($category_ids as $val)
                    array_push($new, $val->id);

            if ($selected_categories)
                foreach ($selected_categories as $selected_category)
                    array_push($old, $selected_category->category_id);

            $add = array_diff($new, $old);
            $del = array_diff($old, $new);

            if ($add)
                foreach ($add as $item) {
                    $article_category = new DestinationCategory();
                    $article_category->destination_id = $_POST['destination_id'];
                    $article_category->category_id = $item;
                    $article_category->save();
                }

            if ($del)
                foreach ($del as $item)
                    DestinationCategory::deleteAll(['destination_id' => $_POST['destination_id'], 'category_id' => $item]);
        }
    }

    public function actionDestinations()
    {
        if (Yii::$app->request->isAjax) {
            $category_ids = json_decode($_POST['category_ids']);
            $res = array();
            if ($category_ids) {
                foreach ($category_ids as $val) {
                    $destination = DestinationCategory::find()
                        ->where(['category_id' => $val->id])
                        ->all();
                    foreach ($destination as $item)
                        array_push($res, $item->destination_id);
                }
                $res = array_unique($res);

                $map = array();
                foreach ($res as $item)
                    array_push($map, $item);

                return json_encode($map);
            }
        } else return 0;
    }
}
