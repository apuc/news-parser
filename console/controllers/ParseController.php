<?php


namespace console\controllers;


use common\models\ParseQueue;
use common\services\ParseService;
use yii\console\Controller;

class ParseController extends Controller
{
    public function actionRun()
    {
        $pq = ParseQueue::find()->limit(1)->all();
        if($pq)
            foreach ($pq as $item) {
                ParseQueue::deleteAll(['id' => $item->id]);
                $parse = new ParseService();
                $parse->parse_handler($item->source_id);
            }
    }
}