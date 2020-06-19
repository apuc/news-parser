<?php

namespace frontend\modules\article\controllers;


use common\classes\Debug;
use common\models\Article;
use common\models\ArticleCategory;
use common\models\Category;
use common\models\Destination;
use common\models\DestinationArticle;
use common\models\DestinationCategory;
use common\models\Language;
use common\models\ParseQueue;
use common\models\TranslateQueue;
use common\services\ParseService;
use common\services\TranslateHandler;
use frontend\modules\article\models\ArticleSearch;
use frontend\modules\article\models\ReadForm;
use Yii;
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
        $model = new Article();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->relatedData($model->id);

            if (isset($model->desctination))
                $model->sendingData('/store-article');

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
            $model->relatedData($id);

            if (isset($model->desctination))
                $model->sendingData('/update-article');

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

    /**
     * Read article from file
     * @return mixed
     */
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

    /**
     * Read article from file
     */
    public function actionReadFile()
    {
        if (Yii::$app->request->isAjax) {
            $filename = $_POST['filename'];
            if (($handle = fopen('articles/' . $filename, 'r')) !== FALSE) {
                while (($data = fgetcsv($handle, 0, ',', '"')) !== FALSE) {
                    $article = new Article();
                    $article->_save($data[0], $data[1]);
                }
                fclose($handle);
            }
        }
    }

    /**
     * Sends articles to placement sites
     */
    public function actionShowDestinations()
    {
        if (Yii::$app->request->isAjax) {
            $destinations_ids = json_decode($_POST['destinations_ids']);
            $articles_ids = $_POST['articles_ids'];

            foreach ($articles_ids as $id) {
                $article = Article::findOne($id);

                foreach ($destinations_ids as $destinations) {
                    $destination_article  = new DestinationArticle();
                    $destination_article->_save($id, $destinations->id, 1);

                    $article->sendData($destinations->id, '/store-article');
                }
            }
        }
    }

    /**
     * Add articles to translate queue
     * @return integer
     */
    public function actionTranslateQueue()
    {
        if (Yii::$app->request->isAjax) {
            $article_id = Yii::$app->request->post('article_id');
            $article_ids = Yii::$app->request->post('article_ids');
            $language_ids = json_decode(Yii::$app->request->post('language_ids'));

            if (!empty($article_id))
                foreach ($language_ids as $language) {
                    $tq = new TranslateQueue();
                    $tq->_save($article_id, $language->id);
                }
            else
                foreach ($article_ids as $id)
                    foreach ($language_ids as $language) {
                        $tq = new TranslateQueue();
                        $tq->_save($id, $language->id);
                    }
            return 1;
        } else return -1;
    }

    /**
     * Add articles in parse queue
     */
    public function actionParse()
    {
        if (Yii::$app->request->isAjax) {
            $keys = $_POST['keys'];
            if ($keys)
                foreach ($keys as $key) {
                    $parse = new ParseQueue();
                    $parse->_save($key);
                }
        }
    }

    /**
     * Returns selected categories for article
     */
    public function actionSelected()
    {
        $themes = array();
        if (Yii::$app->request->isAjax) {
            $site = Article::findOne($_POST['id']);
            if (isset($site->articleCategories))
                foreach ($site->articleCategories as $val)
                    array_push($themes, $val->category_id);
        }
        return json_encode($themes);
    }

    /**
     * Returns selected destinations for article
     */
    public function actionSelectedDestination()
    {
        $destinations = array();
        if (Yii::$app->request->isAjax) {
            $site = Article::findOne(['id' => $_POST['id'], 'status' => 1]);
            if (isset($site->destinationArticles))
                foreach ($site->destinationArticles as $val)
                    array_push($destinations, $val->destination_id);
        }
        return json_encode($destinations);
    }

    /**
     * Auto select destinations when create or update article
     */
    public function actionDestinations()
    {
        if (Yii::$app->request->isAjax) {
            $category_ids = json_decode($_POST['category_ids']);
            $res = array();
            foreach ($category_ids as $val) {
                $destination = DestinationCategory::find()->where(['category_id' => $val->id])->all();
                foreach ($destination as $item)
                    array_push($res, $item->destination_id);
            }
            $map = Article::getArray(array_unique($res));

            return json_encode($map);
        } else return 0;
    }

    /**
     * Saves changes in selected categories for article
     */
    public function actionCategory()
    {
        if (Yii::$app->request->isAjax) {
            $category_ids = json_decode($_POST['category_ids']);
            $selected_categories = ArticleCategory::find()->where(['article_id' => $_POST['article_id']])->all();

            $new = Article::getArray($category_ids, 'id');
            $old = Article::getArray($selected_categories, 'category_id');

            $add = array_diff($new, $old);
            $del = array_diff($old, $new);

            if ($add)
                foreach ($add as $item) {
                    $article_category = new ArticleCategory();
                    $article_category->_save($_POST['article_id'], $item);
                }
            if ($del)
                foreach ($del as $item)
                    ArticleCategory::deleteAll(['article_id' => $_POST['article_id'], 'category_id' => $item]);
        }
    }

    /**
     * Saves changes in selected destinations for articles
     * and sends articles to an placement sites
     */
    public function actionDestination()
    {
        if (Yii::$app->request->isAjax) {
            $destination_ids = json_decode($_POST['destination_ids']);
            $selected_destinations = DestinationArticle::find()->where(['article_id' => $_POST['article_id']])->all();

            $new = Article::getArray($destination_ids, 'id');
            $old = Article::getArray($selected_destinations, 'destination_id');

            $add = array_diff($new, $old);
            $del = array_diff($old, $new);

            if ($add)
                foreach ($add as $item) {
                    $article_destination = new DestinationArticle();
                    $article_destination->_save($_POST['article_id'], $item, 1);
                }
            if ($del)
                foreach ($del as $item) {
                    $change_status = DestinationArticle::findOne(['article_id' => $_POST['article_id'], 'destination_id' => $item]);
                    $change_status->status = 0;
                    $change_status->save();
                }

            $article = Article::findOne($_POST['article_id']);

            $da = DestinationArticle::find()->where(['article_id' => $_POST['article_id'], 'status' => 1])->all();
            foreach ($da as $item)
                $article->sendData($item->destination_id, '/store-article');
        }
    }
}