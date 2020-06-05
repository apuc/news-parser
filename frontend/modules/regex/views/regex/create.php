<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Regex */

$this->title = 'Добавить';
$this->params['breadcrumbs'][] = ['label' => 'Регулярные выражения', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="regex-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
