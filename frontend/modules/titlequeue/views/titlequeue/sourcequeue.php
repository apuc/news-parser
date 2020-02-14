<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Очерердь сайтов источников';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="title-queue-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'source.domain',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
