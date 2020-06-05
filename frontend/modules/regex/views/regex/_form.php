<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Regex */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="regex-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'regex')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sample')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
