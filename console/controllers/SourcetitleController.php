<?php
namespace console\controllers;

use common\classes\AuditService;
use common\models\Source;
use common\models\TitleQueue;
use yii\console\Controller;

class SourcetitleController extends Controller
{
    public function actionRun()
    {
        $title = TitleQueue::find()->where(['not', ['source_id' => null]])->limit(1)->all();
        if ($title)
            foreach ($title as $value) {
                TitleQueue::deleteAll(['id' => $value->id]);
                $site = Source::findOne($value->source_id);
                $site->title = AuditService::getTitle($site->domain);
                $site->save();
            }

        return 0;
    }
}