<?php

use kartik\select2\Select2;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model common\models\Article */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-form">

    <?php
    Pjax::begin(['id' => 'reload']);
    $form = ActiveForm::begin();

    echo $form->field($model, 'name')->textInput(['maxlength' => true]);

    echo $form->field($model, 'language_id')->dropDownList(
        ArrayHelper::map(common\models\Language::find()->all(), 'id', 'language'),
        ['prompt' => '...', 'id' => 'language']);

    echo $form->field($model, 'source_type')->dropDownList([
            'Получено с сайта' => 'с сайта',
            'Автоматический перевод' => 'перевод',
            'Добавлено вручную' => 'добавлено вручную',
            'Считано из файла' => 'из файла'
        ], ['prompt' => '...', 'id' => 'source_type']);

    echo $form->field($model, 'article_source')->widget(Select2::class, [
        'data' => [],
        'options' => ['placeholder' => '...', 'id' => 'article_source', 'class' => 'form-control']]);

    echo $form->field($model, 'text')->widget(CKEditor::className(),[
        'editorOptions' => [
            'preset' => 'full',
            'inline' => false,
        ]]);
    ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php
    ActiveForm::end();
    Pjax::end();
    ?>

</div>
