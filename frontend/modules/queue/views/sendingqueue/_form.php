<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SendingQueue */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sending-queue-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'destination_id')->textInput() ?>

    <?= $form->field($model, 'article_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
