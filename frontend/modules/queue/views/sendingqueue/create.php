<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SendingQueue */

$this->title = 'Create Sending Queue';
$this->params['breadcrumbs'][] = ['label' => 'Sending Queues', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sending-queue-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
