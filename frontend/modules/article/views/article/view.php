<?php

use common\classes\TextHandler;
use frontend\modules\article\models\Article;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Article */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Статьи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

YiiAsset::register($this);
?>
<div class="article-view">
    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уыеренны, что хотите удалить эту статью?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'article_source',
            'source_type',
            'language.language',
            [
                'format' => 'raw',
                'attribute' => 'Катеория',
                'value' => function ($data) { return Article::getCategory($data); },
            ],
            'text:ntext',
        ],
    ]) ?>

    <?php
    $t = new TextHandler($model->text);
    $t->showInfo();
    $t->showText();
    ?>
</div>