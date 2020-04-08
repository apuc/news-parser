<?php

namespace frontend\modules\api\controllers;

use common\models\Article;
use common\models\ArticleCategory;
use common\models\Destination;
use common\models\DestinationArticle;
use common\models\DestinationCategory;
use common\models\Source;
use common\models\Template;
use common\models\TitleQueue;
use frontend\modules\api\models\Theme;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;


class ApiController extends Controller
{
    // returns type of article (unnecessary now)
    public function actionType()
    {
        if (Yii::$app->request->isAjax) {
            $result = array();
            switch ($_POST['value']) {
                case 'Получено с сайта':
                    $result = ArrayHelper::map(Source::find()->all(), 'id', 'domain');
                    break;
                case 'Автоматический перевод': //add where language
                    $result = ArrayHelper::map(Article::find()->all(), 'id', 'name');
                    break;
                case 'Добавлено вручную':
                    $result[Yii::$app->user->identity->id] = Yii::$app->user->identity->username;
                    break;
                case 'Считано из файла':
                    $result['имя файла'] = 'имя файла';
                    break;
                default:
                    break;
            }

            return json_encode($result);
        }
    }
    // returns existing templates (unnecessary now)
    public function actionTemplates()
    {
        $templates = Template::find()->all();

        $model = array();
        foreach ($templates as $value) {

            $img = '<img src="https://placement-site.craft-group.xyz/workspace/modules/themes/themes/' . $value->name . '/preview.jpg" class="img" />';
            array_push($model, new Theme($value->id, $value->name, $value->description, $img, $value->version, 'не скачано'));
        }

        return json_encode($model);
    }
    // doing nothing. supposed to return articles array (unnecessary now)
    public function actionArticles()
    {
        $articles = array();
        if (Yii::$app->request->isAjax) {
            $ids = json_decode($_POST['ids']);
            foreach ($ids as $id) {
                $article = Article::findOne($id);
                array_push($articles, $article);
            }
        }
        //return articles array
    }

    // reads articles from file
    public function actionRead()
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

    // add source sites into queue for parsing titles
    public function actionTitlesource()
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
    // add destination sites into queue for parsing titles
    public function actionTitledestination()
    {
        if (Yii::$app->request->isAjax) {
            $keys = $_POST['keys'];
            if ($keys)
                foreach ($keys as $key) {
                    $audit = new TitleQueue();
                    $audit->destination_id = $key;
                    $audit->save();
                }
        }
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
    public function actionSelecteddestination()
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

    // show selected categories for destinations
    public function actionDselected()
    {
        $themes = array();
        if (Yii::$app->request->isAjax) {
            $site = Destination::findOne($_POST['id']);
            if (isset($site->destinationCategories)) {
                foreach ($site->destinationCategories as $val) {
                    array_push($themes, $val->category_id);
                }
            }
        }
        return json_encode($themes);
    }
    // select categories for destinations
    public function actionDcategory()
    {
        if (Yii::$app->request->isAjax) {
            $category_ids = json_decode($_POST['category_ids']);
            $selected_categories = DestinationCategory::find()->where(['destination_id' => $_POST['destination_id']])->all();
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
                    $article_category = new DestinationCategory();
                    $article_category->destination_id = $_POST['destination_id'];
                    $article_category->category_id = $item;
                    $article_category->save();
                }

            if ($del)
                foreach ($del as $item)
                    DestinationCategory::deleteAll(['destination_id' => $_POST['destination_id'], 'category_id' => $item]);
        }
    }
}