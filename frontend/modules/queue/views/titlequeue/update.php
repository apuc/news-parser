<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TitleQueue */

$this->title = 'Update Title Queue: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Title Queues', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="title-queue-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
