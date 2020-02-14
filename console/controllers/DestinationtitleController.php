<?php
namespace console\controllers;

use common\classes\AuditService;
use common\models\Destination;
use common\models\TitleQueue;
use yii\console\Controller;

class DestinationtitleController extends Controller
{
    public function actionRun()
    {
        $title = TitleQueue::find()->where(['not', ['destination_id' => null]])->limit(1)->all();
        if ($title) {
            foreach ($title as $value) {
                TitleQueue::deleteAll(['id' => $value->id]);
                $site = Destination::findOne($value->destination_id);
                $site->title = AuditService::getTitle($site->domain);
                $site->save();
                echo $site->title;
                print_r($site->errors);
            }
        }
        return 0;
    }
}