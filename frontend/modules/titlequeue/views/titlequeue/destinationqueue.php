<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Очередь сайтов размещения';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="title-queue-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'destination.domain',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
