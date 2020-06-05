<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ParseQueue */

$this->title = 'Create Parse Queue';
$this->params['breadcrumbs'][] = ['label' => 'Parse Queues', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parse-queue-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
