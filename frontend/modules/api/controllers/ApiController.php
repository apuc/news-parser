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
       if(Yii::$app->request->isAjax) {
           $result  = array();
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
       if(Yii::$app->request->isAjax) {
           $keys = $_POST['keys'];
           if($keys)
               foreach ($keys as $key) {
                   $audit = new TitleQueue();
                   $audit->source_id = $key;
                   $audit->save();
               }
       }
   }

    public function actionTitledestination()
    {
        if(Yii::$app->request->isAjax) {
            $keys = $_POST['keys'];
            if($keys)
                foreach ($keys as $key) {
                    $audit = new TitleQueue();
                    $audit->destination_id = $key;
                    $audit->save();
                }
        }
    }

    public function actionRead()
    {
        if(Yii::$app->request->isAjax) {
            $filename = $_POST['filename'];
            if (($handle = fopen('articles/' . $filename, 'r')) !== FALSE) {
                while (($data = fgetcsv($handle, 0, ',','"')) !== FALSE) {
                    $article  = new \frontend\modules\article\models\Article();
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
        if(Yii::$app->request->isAjax) {
            $article = Article::findOne($_POST['id']);
            if (isset($article->articleCategories)) {
                foreach ($article->articleCategories as $val) {
                    array_push($themes, $val->category_id);
                }
            }
        }
        return json_encode($themes);
    }

    public function actionDselected()
    {
        $themes = array();
        if(Yii::$app->request->isAjax) {
            $site = Destination::findOne($_POST['id']);
            if (isset($site->destinationCategories)) {
                foreach ($site->destinationCategories as $val) {
                    array_push($themes, $val->category_id);
                }
            }
        }
        return json_encode($themes);
    }

    public function actionCategory()
    {
        if(Yii::$app->request->isAjax) {
            $category_ids = json_decode($_POST['category_ids']);

            if ($category_ids) {
                ArticleCategory::deleteAll(['article_id' => $_POST['article_id']]);

                foreach ($category_ids as $item) {
                    $category = new ArticleCategory();
                    $category->article_id = $_POST['article_id'];
                    $category->category_id = $item->id;

                    $category->save();
                }
            }
        }
    }

    public function actionDcategory()
    {
        if(Yii::$app->request->isAjax) {
            $category_ids = json_decode($_POST['category_ids']);

            if ($category_ids) {
                DestinationCategory::deleteAll(['destination_id' => $_POST['destination_id']]);

                foreach ($category_ids as $item) {
                    $category = new DestinationCategory();
                    $category->destination_id = $_POST['destination_id'];
                    $category->category_id = $item->id;

                    $category->save();
                }
            }
        }
    }
}
