<?php

use common\models\Language;
use common\models\Source;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Source */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="source-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'domain')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php
    echo '<div class="custom-field">' . $form->field($model, 'parent_id')->dropDownList(
        ArrayHelper::map(Source::find()->where(['parent_id' => null])->all(), 'id', 'domain'),
        ['prompt' => '...']) . '</div>';

    echo '<div class="custom-field">' . $form->field($model, 'language_id')->dropDownList(
        ArrayHelper::map(Language::find()->all(), 'id', 'language'),
        ['prompt' => '...']
        ) . '</div>';
    ?>

    <?= $form->field($model, 'links_rule')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title_rule')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'article_rule')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'start_parse')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'end_parse')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
