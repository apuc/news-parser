<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TranslateQueue */

$this->title = 'Create Translate Queue';
$this->params['breadcrumbs'][] = ['label' => 'Translate Queues', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="translate-queue-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
