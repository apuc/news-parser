<?php

use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Article */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-form">

    <?php

    $form = ActiveForm::begin();

    echo $form->field($model, 'name')->textInput(['maxlength' => true]);

    echo $form->field($model, 'text')->widget(CKEditor::className(),['editorOptions' => ['preset' => 'full', 'inline' => false,]]);

    echo Html::submitButton('Сохранить', ['class' => 'btn btn-success']);

    ActiveForm::end();
    ?>

</div>