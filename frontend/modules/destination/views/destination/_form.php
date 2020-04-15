<?php

use common\models\Category;
use common\models\DestinationCategory;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Destination */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="destination-form">

    <?php
    $form = ActiveForm::begin();

    echo $form->field($model, 'domain')->textInput(['maxlength' => true]);

    $values = ArrayHelper::map(DestinationCategory::find()->where(['destination_id' => $model->id])->all(), 'category_id', 'category_id');
    $model->category = $values;
    echo $form->field($model, 'category')->widget(Select2::class, [
        'data' => ArrayHelper::map(Category::find()->all(), 'id', 'name'),
        'options' => ['placeholder' => '...', 'class' => 'form-control', 'id' => 'category_ids', 'multiple' => true],
        'pluginOptions' => ['allowClear' => true],
        'value' => $values
    ])->label('Категории');

    $content = file_get_contents('https://rep.craft-group.xyz/handler.php');
    $data = json_decode($content);
    $themes = array();
    foreach ($data as $item)
        if($item->type == 'theme')
            array_push($themes, $item);
    echo $form->field($model, 'theme')->dropDownList(
        ArrayHelper::map($themes, 'name', 'name'),
        ['prompt' => '...', 'id' => 'theme']
    );

    echo $form->field($model, 'title')->textInput(['maxlength' => true]);

    echo $form->field($model, 'keywords')->textInput(['maxlength' => true]);

    echo $form->field($model, 'description')->textInput(['maxlength' => true]);

    echo Html::submitButton('Save', ['class' => 'btn btn-success']);

    ActiveForm::end();
    ?>

</div>
