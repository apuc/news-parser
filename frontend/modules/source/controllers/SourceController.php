<?php

namespace frontend\modules\source\controllers;

use common\classes\Debug;
use common\models\SourceCategory;
use common\models\TitleQueue;
use frontend\modules\source\models\AddForm;
use Yii;
use common\models\Source;
use frontend\modules\source\models\SourceSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SourceController implements the CRUD actions for Source model.
 */
class SourceController extends Controller
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
     * Lists all Source models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SourceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query
            ->where(['source_user.user_id' => Yii::$app->user->identity->id])
            ->innerJoin('source_user', 'source.id = source_user.source_id');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Source model.
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
     * Creates a new Source model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Source();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Source model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Source model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
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
            \frontend\modules\source\models\Source::addData($model->domains);
            return $this->redirect('/source/source');
        } else {
            return $this->render('add', ['model' => $model]);
        }
    }

    /**
     * Finds the Source model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Source the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Source::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    // add source sites into queue for parsing titles
    public function actionTitleSource()
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

    // selected categories for sources
    public function actionSelectedSourceCategories()
    {
        $themes = array();
        if (Yii::$app->request->isAjax) {
            $site = \common\models\Source::findOne($_POST['id']);
            if (isset($site->sourceCategories))
                foreach ($site->sourceCategories as $val)
                    array_push($themes, $val->category_id);
        }
        return json_encode($themes);
    }
    // select categories for sources
    public function actionSourceCategory()
    {
        if (Yii::$app->request->isAjax) {
            $category_ids = json_decode($_POST['category_ids']);
            $selected_categories = SourceCategory::find()->where(['source_id' => $_POST['source_id']])->all();
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
                    $article_category = new SourceCategory();
                    $article_category->source_id = $_POST['source_id'];
                    $article_category->category_id = $item;
                    $article_category->save();
                }

            if ($del)
                foreach ($del as $item)
                    SourceCategory::deleteAll(['source_id' => $_POST['source_id'], 'category_id' => $item]);
        }
    }
}
