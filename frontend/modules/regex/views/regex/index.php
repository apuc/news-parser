<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\regex\models\RegexSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Регулярные выражения';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="regex-index">

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\ActionColumn'],
            'regex',
            'sample',
        ],
    ]); ?>


</div>
