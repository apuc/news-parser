<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Language */

$this->title = 'Редактировть язык: ' . $model->language;
$this->params['breadcrumbs'][] = ['label' => 'Языки', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="language-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
