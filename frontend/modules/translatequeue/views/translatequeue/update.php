<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TranslateQueue */

$this->title = 'Update Translate Queue: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Translate Queues', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="translate-queue-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>