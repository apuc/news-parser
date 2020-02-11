<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Destination */

$this->title = 'Добавить';
$this->params['breadcrumbs'][] = ['label' => 'Сайты размещения', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="destination-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
