<?php

use common\models\Destination;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Destination */

$this->title = $model->domain;
$this->params['breadcrumbs'][] = ['label' => 'Сайт размещения', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="destination-view">

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверенны, что хотите удалить этот сайт',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'domain',
            'title',
            [
                'format' => 'raw',
                'attribute' => 'Катеория',
                'value' => function ($data) { return Destination::getCategory($data); },
            ],
            'description'
        ],
    ]) ?>

</div>
