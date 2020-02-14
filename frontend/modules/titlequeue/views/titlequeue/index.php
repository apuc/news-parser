<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\titlequeue\models\TitlequeueSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Title Queues';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="title-queue-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Title Queue', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'source_id',
            'destination_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
