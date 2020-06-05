<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Regex */

$this->title = 'Редактировать: ' . $model->regex;
$this->params['breadcrumbs'][] = ['label' => 'Регулярные выражения', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="regex-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
