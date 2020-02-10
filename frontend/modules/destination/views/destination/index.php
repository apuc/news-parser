<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\destination\models\DestinationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Сайты назначения';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="destination-index">

    <p>
        <?= Html::a('Добавить', ['add'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Ручное добавление', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'domain',
            'theme_id',
            //'user_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
