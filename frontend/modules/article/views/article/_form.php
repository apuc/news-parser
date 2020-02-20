<?php

use common\models\ArticleCategory;
use common\models\Category;
use common\models\Destination;
use frontend\modules\article\Article;
use kartik\select2\Select2;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model Article */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-form">

    <?php
    $form = ActiveForm::begin();

    Pjax::begin(['id' => 'reload']);

    echo $form->field($model, 'name')->textInput(['maxlength' => true]);

    $values = ArrayHelper::map(ArticleCategory::find()->where(['article_id' => $model->id])->all(), 'category_id', 'category_id');
    $model->category = $values;
    echo $form->field($model, 'category')->widget(Select2::class, [
        'data' => ArrayHelper::map(Category::find()->all(), 'id', 'name'),
        'options' => ['placeholder' => '...', 'class' => 'form-control', 'id' => 'categories', 'multiple' => true],
        'pluginOptions' => ['allowClear' => true],
        'value' => $values
    ])->label('Категории');

    $destination = Destination::find()
        ->leftJoin('destination_category', 'destination.id = destination_category.destination_id')
        ->innerJoin('article_category', 'destination_category.category_id = article_category.category_id')
        ->where(['article_category.article_id' => \Yii::$app->request->get('id')])
        ->all();
    $domains = ArrayHelper::getColumn($destination, 'id');
    $model->destination = $domains;
    echo $form->field($model, 'destination')->widget(Select2::class, [
        'data' => ArrayHelper::map(
            Destination::find()->all(),
            'id', 'domain'),
        'options' => ['placeholder' => '...', 'class' => 'form-control', 'id' => 'destinations_ids', 'multiple' => true],
        'pluginOptions' => ['allowClear' => true],
    ])->label('Сайты размещения');

    echo $form->field($model, 'text')->widget(CKEditor::className(),['editorOptions' => ['preset' => 'full', 'inline' => false,]]);

    echo Html::submitButton('Сохранить', ['class' => 'btn btn-success']);

    Pjax::end();

    ActiveForm::end();
    ?>

</div>