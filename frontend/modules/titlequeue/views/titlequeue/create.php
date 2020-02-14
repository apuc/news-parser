<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TitleQueue */

$this->title = 'Create Title Queue';
$this->params['breadcrumbs'][] = ['label' => 'Title Queues', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="title-queue-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
