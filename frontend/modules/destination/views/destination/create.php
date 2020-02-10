<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Destination */

$this->title = 'Create Destination';
$this->params['breadcrumbs'][] = ['label' => 'Destinations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="destination-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
