<?php


namespace console\controllers;


use common\services\ParseService;
use yii\console\Controller;

class ParseController extends Controller
{
    public function actionParse()
    {
        $parse = new ParseService();
        $parse->parse();
    }
}