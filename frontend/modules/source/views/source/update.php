<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Source */

$this->title = 'Редактировать сайт источник: ' . $model->domain;
$this->params['breadcrumbs'][] = ['label' => 'Сайты источники', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="source-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
