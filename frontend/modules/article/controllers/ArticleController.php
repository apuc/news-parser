<?php

namespace frontend\modules\article\controllers;


use common\classes\Debug;
use common\models\ArticleCategory;
use common\models\Category;
use common\models\Destination;
use common\models\DestinationArticle;
use common\models\Language;
use frontend\modules\article\models\ReadForm;
use Yii;
use common\models\Article;
use frontend\modules\article\models\ArticleSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends Controller
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
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Article model.
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
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new \frontend\modules\article\models\Article();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->sendingData($model, $this->dataToSend($model), '/store-article');

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->sendingData($model, $this->dataToSend($model), '/update-article');

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Article model.
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
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionRead()
    {
        $model = new ReadForm();

        if (Yii::$app->request->isPost) {
            $model->csv = UploadedFile::getInstances($model, 'csv');
            $model->upload();
            return $this->render('read', ['model' => $model]);
        }
        return $this->render('read', ['model' => $model]);
    }

    public function actionShowdestinations()
    {
        if (Yii::$app->request->isAjax) {
            $destinations_ids = json_decode($_POST['destinations_ids']);
            $articles_ids = $_POST['articles_ids'];

            foreach ($articles_ids as $id) {
                $article = Article::findOne($id);
                $article = $this->dataToSend($article);

                foreach ($destinations_ids as $destinations) {
                    $destination = Destination::findOne($destinations->id);
                    $ch = curl_init($destination->domain . '/store-article');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $article);
                    curl_exec($ch);
                    curl_close($ch);
                }
            }
        }
    }

    public function actionSend()
    {
        $articles = array();
        $categories = array();
        foreach ($_POST['keys'] as $key) {
            $article = Article::findOne($key);
            $article_category = ArticleCategory::find()->where(['article_id' => $article->id])->all();

            foreach ($article_category as $value) {
                $category = Category::findOne($value->category_id);
                array_push($categories, $category->name);
            }

            $data = new \common\classes\Article($article->id, $article->name, $article->text, $article->language_id, $categories,
                'news.jpg', $article->title, $article->description, $article->keywords, $article->url);
            array_push($articles, $data);
        }
    }

    public function dataToSend($model)
    {
        $categories = array();

        $language = Language::findOne($model->language_id);

        $article_category = ArticleCategory::find()->where(['article_id' => $model->id])->all();
        foreach ($article_category as $value) {
            $category = Category::findOne($value->category_id);
            array_push($categories, $category->name);
        }

        $data = new \common\classes\Article($model->id, $model->name, $model->text, $language->language, $categories,
            'news.jpg', $model->title, $model->description, $model->keywords, $model->url);

        return json_encode($data);
    }

    public function sendingData($model, $post, $action)
    {
        foreach ($model->destination as $id) {
            $destination = Destination::findOne($id);

            $ch = curl_init($destination->domain . $action);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            curl_exec($ch);
            curl_close($ch);
        }
    }
}