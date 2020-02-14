<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\destination\models\DestinationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Сайты размещения';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="destination-index">

    <p>
        <?= Html::a('Добавить', ['add'], ['class' => 'btn btn-success']) ?>
        <?= Html::button('Получить заголовки', ['class' => 'btn btn-success title_destination']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'id' => 'grid',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\CheckboxColumn'],
            'domain',
            'title',
            'description',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
