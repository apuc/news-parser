<?php

use common\models\ArticleCategory;
use common\models\Category;
use frontend\modules\article\Article;
use kartik\select2\Select2;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model Article */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-form">

    <?php
    $form = ActiveForm::begin();

    $values = ArrayHelper::map(ArticleCategory::find()->where(['article_id' => $model->id])->all(), 'category_id', 'category_id');
    $model->category = $values;
    echo $form->field($model, 'category')->widget(Select2::class, [
        'data' => ArrayHelper::map(Category::find()->all(), 'id', 'name'),
        'options' => ['placeholder' => '...', 'class' => 'form-control', 'id' => 'category_ids', 'multiple' => true],
        'pluginOptions' => ['allowClear' => true],
        'value' => $values
    ])->label('Категории');

    echo $form->field($model, 'name')->textInput(['maxlength' => true]);

    echo $form->field($model, 'text')->widget(CKEditor::className(),['editorOptions' => ['preset' => 'full', 'inline' => false,]]);

    echo Html::submitButton('Сохранить', ['class' => 'btn btn-success']);

    ActiveForm::end();
    ?>

</div>