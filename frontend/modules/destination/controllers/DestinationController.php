<?php

namespace frontend\modules\destination\controllers;


use common\classes\Debug;
use common\classes\Settings;
use common\models\DestinationCategory;
use frontend\modules\destination\models\AddForm;
use Yii;
use common\models\Destination;
use frontend\modules\destination\models\DestinationSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DestinationController implements the CRUD actions for Destination model.
 */
class DestinationController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Destination models.
     * @return mixed
     */
    public function actionIndex()
    {
        $content = file_get_contents('https://rep.craft-group.xyz/handler.php');
        $data = json_decode($content);
        $themes = array();
        foreach ($data as $item)
            if($item->type == 'theme')
                array_push($themes, $item);

        $searchModel = new DestinationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query
            ->where(['destination_user.user_id' => Yii::$app->user->identity->id])
            ->innerJoin('destination_user', 'destination.id = destination_user.destination_id');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'themes' => $themes
        ]);
    }

    /**
     * Displays a single Destination model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Destination model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Destination();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Destination model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $post = Yii::$app->request->post('Destination');

            $category_ids = $post['category'];
            $selected_categories = DestinationCategory::find()->where(['destination_id' => $id])->all();

            $new = array();
            $old = array();

            if($category_ids)
                foreach ($category_ids as $val)
                    array_push($new, $val);

            if($selected_categories)
                foreach ($selected_categories as $selected_category)
                    array_push($old, $selected_category->category_id);

            $add = array_diff($new, $old);
            $del = array_diff($old, $new);

            if($add)
                foreach ($add as $item) {
                    $article_category  = new DestinationCategory();
                    $article_category->destination_id = $id;
                    $article_category->category_id = $item;
                    $article_category->save();
                }

            if($del)
                foreach ($del as $item)
                    DestinationCategory::deleteAll(['destination_id' => $id, 'category_id' => $item]);

            $this->sendingData($model->domain, '/set-settings',
                json_encode(new Settings($model['title'], $model['keywords'], $model['description'], $model['theme'])));

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Destination model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @return mixed
     */
    public function actionAdd()
    {
        $model = new AddForm();

        if ($model->load(Yii::$app->request->post())) {
            \frontend\modules\destination\models\Destination::addData($model->domains);
            return $this->redirect('/destination/destination');
        } else {
            return $this->render('add', ['model' => $model]);
        }
    }

    /**
     * Finds the Destination model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Destination the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Destination::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGetTitle()
    {
        $destination = Destination::findOne($_POST['site_id']);

        return $destination->title;
    }

    public function actionGetTheme()
    {
        $destination = Destination::findOne($_POST['site_id']);

        return $destination->theme;
    }

    public function actionGetKeywords()
    {
        $destination = Destination::findOne($_POST['site_id']);

        return $destination->keywords;
    }

    public function actionGetDescription()
    {
        $destination = Destination::findOne($_POST['site_id']);

        return $destination->description;
    }

    public function actionSetTitle()
    {
        $destination = Destination::findOne($_POST['site_id']);
        $destination->title = Yii::$app->request->post('data');

        $destination->save();

        $this->sendingData($destination->domain, '/set-title', $destination->title);
    }

    public function actionSetKeywords()
    {
        $destination = Destination::findOne($_POST['site_id']);
        $destination->keywords = Yii::$app->request->post('data');
        $destination->save();

        $this->sendingData($destination->domain, '/set-keywords', $destination->keywords);
    }

    public function actionSetDescription()
    {
        $destination = Destination::findOne($_POST['site_id']);
        $destination->description = Yii::$app->request->post('data');
        $destination->save();

        $this->sendingData($destination->domain, '/set-description', $destination->description);
    }

    public function actionSetTheme()
    {
        $destination = Destination::findOne($_POST['site_id']);
        $destination->theme = Yii::$app->request->post('data');
        $destination->save();

        $this->sendingData($destination->domain, '/set-theme', $destination->theme);
    }

    public function sendingData($domain, $action, $data)
    {
        $ch = curl_init($domain . $action);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_exec($ch);
        curl_close($ch);
    }
}
