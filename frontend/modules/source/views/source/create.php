<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Source */

$this->title = 'Добавить сайт источник';
$this->params['breadcrumbs'][] = ['label' => 'Сайты источники', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="source-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
