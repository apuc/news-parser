<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\queue\models\SendingqueueSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sending Queues';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sending-queue-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Sending Queue', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'destination_id',
            'article_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
