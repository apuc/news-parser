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

    <?php $form = ActiveForm::begin();

    echo $form->field($model, 'domain')->textInput(['maxlength' => true]);

    echo $form->field($model, 'title')->textInput(['maxlength' => true]);

    echo '<div class="custom-field">' . $form->field($model, 'parent_id')->dropDownList(
        ArrayHelper::map(Source::find()->where(['parent_id' => null])->all(), 'id', 'domain'),
        ['prompt' => '...']) . '</div>';

    echo '<div class="custom-field">' . $form->field($model, 'language_id')->dropDownList(
        ArrayHelper::map(Language::find()->all(), 'id', 'language'),
        ['prompt' => '...']
        ) . '</div>';

    echo $form->field($model, 'links_rule')->textInput(['maxlength' => true]);

    echo $form->field($model, 'title_rule')->textInput(['maxlength' => true]);

    echo $form->field($model, 'article_rule')->textInput(['maxlength' => true]);
//
//    $pt[0] = "обычный";
//    $pt[1] = "с регулярными выражениями";
//    echo '<div class="custom-field">' . $form->field($model, 'parse_type')->dropDownList($pt,
//            ['prompt' => '...']) . '</div>';
//
//    echo $form->field($model, 'regex')->textInput(['maxlength' => true]);

    echo $form->field($model, 'start_parse')->textInput(['maxlength' => true]);

    echo $form->field($model, 'end_parse')->textInput(['maxlength' => true]);

    echo Html::submitButton('Save', ['class' => 'btn btn-success']);

    ActiveForm::end(); ?>

</div>
