<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Destination */

$this->title = 'Редактировать сайт размещения: ' . $model->domain;
$this->params['breadcrumbs'][] = ['label' => 'Сайт размещения', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->domain, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="destination-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
