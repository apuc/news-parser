<?php


namespace console\controllers;


use common\models\TranslateQueue;
use common\services\TranslateHandler;
use yii\console\Controller;

class TranslateController extends Controller
{
    public function actionRun()
    {
        $tq = TranslateQueue::find()->limit(1)->all();
        if($tq) {
            foreach ($tq as $item) {
                TranslateQueue::deleteAll(['id' => $item->id]);
                $tr = new TranslateHandler('google');
                $tr->makeTranslate($item->article_id, $item->language_id);
            }
            echo 'end' . "\n";
        }
    }
}