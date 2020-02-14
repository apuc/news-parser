<?php

namespace frontend\modules\api\controllers;

use common\models\Article;
use common\models\Source;
use common\models\TitleQueue;
use common\models\User;
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
}
