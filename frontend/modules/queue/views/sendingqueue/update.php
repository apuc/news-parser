<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SendingQueue */

$this->title = 'Update Sending Queue: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Sending Queues', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sending-queue-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
