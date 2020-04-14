<?php

use common\models\ArticleCategory;
use common\models\Category;
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

//    echo Html::button('Получить заголовки', ['class' => 'btn btn-success title_source']);

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'id' => 'grid',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
//            ['class' => 'yii\grid\CheckboxColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
//                'buttons' => [
//                    'delete' => function ($data) {
//                        return Html::a("<span class='glyphicon glyphicon-trash' aria-hidden='true'></span>", ['/domain/site/customdelete', 'id' => $data]);},
//                ],
            ],
            'domain',
//            'title',
//            'description',
        ],
    ]);
    ?>
</div>
