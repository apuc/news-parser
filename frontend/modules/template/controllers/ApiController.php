<?php


namespace frontend\modules\template\controllers;


use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\Controller;

class ApiController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public $enableCsrfValidation = false;

    public function actions()
    {
        return [
            'options' => [
                'class' => 'yii\rest\OptionsAction',
            ],
        ];
    }


    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // add CORS filter
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                'Origin' => ['http://localhost:8000'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
            ],

        ];


        unset($behaviors['authenticator']);
        $behaviors['authenticator'] = [
            'class' =>  HttpBearerAuth::className(),
        ];

        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ];

        return $behaviors;
    }


    public function actionDownload()
    {
        //header("Access-Control-Allow-Origin: *");

        return 'it works!';
    }
}