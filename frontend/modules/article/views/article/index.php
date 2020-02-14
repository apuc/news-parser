<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\article\models\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Статьи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">
    <p>
        <?= Html::a('Добавить статью вручную', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Загрузить статьи из файла', ['read'], ['class' => 'btn btn-success']) ?>
        <?= Html::button('Спарсить сатьи', ['class' => 'btn btn-success parse']) ?>
        <?= Html::button('Перевести статьи', ['class' => 'btn btn-success translate']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\CheckboxColumn'],
            ['class' => 'yii\grid\ActionColumn'],

            'name',
            'article_source',
            'source_type',
            'language.language',
            'text:ntext',
        ],
    ]); ?>

</div>
