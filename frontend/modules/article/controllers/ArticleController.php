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
        $model = new \frontend\modules\article\models\Article();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->relatedData($model->id);

            if (isset($model->desctination))
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
            $this->relatedData($id);

            if (isset($model->desctination))
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

    public function relatedData($id)
    {
        $post = \Yii::$app->request->post('Article');
        $category_ids = $post['category'];
        $selected_categories = ArticleCategory::find()->where(['article_id' => $this->id])->all();

        $new = array();
        if($category_ids)
            foreach ($category_ids as $val)
                array_push($new, $val);

        $old = array();
        if($selected_categories)
            foreach ($selected_categories as $selected_category)
                array_push($old, $selected_category->category_id);

        $add = array_diff($new, $old);
        $del = array_diff($old, $new);

        if($add)
            foreach ($add as $item) {
                $article_category  = new ArticleCategory();
                $article_category->article_id = $id;
                $article_category->category_id = $item;
                $article_category->save();
            }

        if($del)
            foreach ($del as $item)
                ArticleCategory::deleteAll(['article_id' => $this->id, 'category_id' => $item]);

        $destination_ids = $post['destination'];
        $existing_destinations = DestinationArticle::find()->where(['article_id' => $this->id])->all();

        $new = array();
        if($destination_ids)
            foreach ($destination_ids as $val)
                array_push($new, $val);

        $old = array();
        if($existing_destinations)
            foreach ($existing_destinations as $existing_destination)
                array_push($old, $existing_destination->destination_id);

        $add = array_diff($new, $old);
        $del = array_diff($old, $new);

        if($add)
            foreach ($add as $item) {
                $destination_article  = new DestinationArticle();
                $destination_article->article_id = $id;
                $destination_article->destination_id = $item;
                $destination_article->save();
            }

        if($del)
            foreach ($del as $item)
                DestinationArticle::deleteAll(['article_id' => $this->id, 'destination_id' => $item]);

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

    public function actionShowDestinations()
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

//    public function actionSend()
//    {
//        $articles = array();
//        $categories = array();
//        foreach ($_POST['keys'] as $key) {
//            $article = Article::findOne($key);
//            $article_category = ArticleCategory::find()->where(['article_id' => $article->id])->all();
//
//            foreach ($article_category as $value) {
//                $category = Category::findOne($value->category_id);
//                array_push($categories, $category->name);
//            }
//
//            $data = new \common\classes\Article($article->id, $article->name, $article->text, $article->language_id, $categories,
//                'news.jpg', $article->title, $article->description, $article->keywords, $article->url);
//            array_push($articles, $data);
//        }
//    }

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

    public function actionTranslateQueue()
    {
        if (Yii::$app->request->isAjax) {
            $article_id = Yii::$app->request->post('article_id');
            $article_ids = Yii::$app->request->post('article_ids');
            $language_ids = json_decode(Yii::$app->request->post('language_ids'));

            if (!empty($article_id))
                foreach ($language_ids as $language)
                    $this->setTranslateQueue($article_id, $language->id);
            else
                foreach ($article_ids as $id)
                    foreach ($language_ids as $language)
                        $this->setTranslateQueue($id, $language->id);
            return 1;
        } else
            return -1;
    }

    public function setTranslateQueue($article_id, $language_id)
    {
        $tq = new TranslateQueue();
        $tq->article_id = $article_id;
        $tq->language_id = $language_id;
        $tq->save();
    }

    // selected categories for articles
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
    // select categories for articles
    public function actionCategory()
    {
        if (Yii::$app->request->isAjax) {
            $category_ids = json_decode($_POST['category_ids']);
            $selected_categories = ArticleCategory::find()->where(['article_id' => $_POST['article_id']])->all();
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
                    $article_category = new ArticleCategory();
                    $article_category->article_id = $_POST['article_id'];
                    $article_category->category_id = $item;
                    $article_category->save();
                }

            if ($del)
                foreach ($del as $item)
                    ArticleCategory::deleteAll(['article_id' => $_POST['article_id'], 'category_id' => $item]);
        }
    }

    // selected destinations for articles
    public function actionSelectedDestination()
    {
        $destinations = array();
        if (Yii::$app->request->isAjax) {
            $site = Article::findOne($_POST['id']);
            if (isset($site->destinationArticles))
                foreach ($site->destinationArticles as $val)
                    array_push($destinations, $val->destination_id);
        }
        return json_encode($destinations);
    }
    // select destinations for articles
    public function actionDestination()
    {
        if (Yii::$app->request->isAjax) {
            $destination_ids = json_decode($_POST['destination_ids']);
            $selected_destinations = DestinationArticle::find()->where(['article_id' => $_POST['article_id']])->all();
            $new = array();
            $old = array();

            if ($destination_ids)
                foreach ($destination_ids as $val)
                    array_push($new, $val->id);

            if ($selected_destinations)
                foreach ($selected_destinations as $selected_destination)
                    array_push($old, $selected_destination->destination_id);

            $add = array_diff($new, $old);
            $del = array_diff($old, $new);

            if ($add)
                foreach ($add as $item) {
                    $article_destination = new DestinationArticle();
                    $article_destination->article_id = $_POST['article_id'];
                    $article_destination->destination_id = $item;
                    $article_destination->save();
                }

            if ($del)
                foreach ($del as $item)
                    DestinationArticle::deleteAll(['article_id' => $_POST['article_id'], 'destination_id' => $item]);
        }
    }

    // auto select destinations when create or update article
    public function actionDestinations()
    {
        if (Yii::$app->request->isAjax) {
            $category_ids = json_decode($_POST['category_ids']);
            $res = array();
            foreach ($category_ids as $val) {
                $destination = DestinationCategory::find()
                    ->where(['category_id' => $val->id])
                    ->all();
                foreach ($destination as $item)
                    array_push($res, $item->destination_id);
            }
            $res = array_unique($res);

            $map = array();
            foreach ($res as $item)
                array_push($map, $item);

            return json_encode($map);
        } else return 0;
    }

    // reads articles from file
    public function actionReadFile()
    {
        if (Yii::$app->request->isAjax) {
            $filename = $_POST['filename'];
            if (($handle = fopen('articles/' . $filename, 'r')) !== FALSE) {
                while (($data = fgetcsv($handle, 0, ',', '"')) !== FALSE) {
                    $article = new \frontend\modules\article\models\Article();
                    $article->name = $data[0];
                    $article->text = $data[1];
                    $article->save();
                }
                fclose($handle);
            }
        }
    }
    // parse articles
    public function actionParse()
    {
        if (Yii::$app->request->isAjax) {
            $keys = $_POST['keys'];
            if ($keys)
                foreach ($keys as $key) {
                    $parse = new ParseQueue();
                    $parse->source_id = $key;
                    $parse->save();
                }
        }
    }
}