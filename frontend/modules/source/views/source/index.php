<?php

use common\models\ArticleCategory;
use common\models\Category;
use common\models\Source;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\source\models\SourceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Сайты источники';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="source-index">
    <?php
    echo Html::a('Добавить', ['add'], ['class' => 'btn btn-success']).'&nbsp';

    echo Html::button('Получить заголовки', ['class' => 'btn btn-success title_source']);

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'id' => 'grid',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\ActionColumn'],
            ['class' => 'yii\grid\CheckboxColumn'],

            'domain',
            [
                'format' => 'raw',
                'header' => 'Родитель',
                'value' => function ($data) {
                    $src = Source::findOne($data->parent_id);
                    if($src)
                        return $src->domain;
                    else
                        return '';
                },
            ],
            'title',
            'links_rule',
            'title_rule',
            'article_rule',
            'start_parse',
            'end_parse',
        ],
    ]);
    ?>
</div>
