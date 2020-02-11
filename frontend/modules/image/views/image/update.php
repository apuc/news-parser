<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Image */

$this->title = 'Update Image: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Images', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="image-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
