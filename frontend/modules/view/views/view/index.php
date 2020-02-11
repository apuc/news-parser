<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\view\models\ViewSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Views';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="view-index">

    <p>
        <?= Html::a('Create View', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'created_at',
            'ip',
            'destination_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
