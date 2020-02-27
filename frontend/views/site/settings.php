<?php

use common\models\Template;
use frontend\models\SettingsForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

    $this->title = 'Настройки';

    $settings = file_get_contents('http://localhost:8000/get-options');
    $settings = json_decode($settings);

    $form = ActiveForm::begin();

    $model = new SettingsForm();

    $model->theme = $settings[0]->value;
    echo $form->field($model, 'theme')->dropDownList(
        ArrayHelper::map(Template::find()->all(), 'name', 'name'),
        ['prompt' => '...']
    );

    $model->title = $settings[1]->value;
    echo $form->field($model, 'title')->textInput(['maxlength' => true]);

    $model->keywords = $settings[2]->value;
    echo $form->field($model, 'keywords')->textInput(['maxlength' => true]);

    $model->description = $settings[3]->value;
    echo $form->field($model, 'description')->textInput(['maxlength' => true]);

    $model->h1 = $settings[4]->value;
    echo $form->field($model, 'h1')->textInput(['maxlength' => true]);

    echo Html::button('Сохранить', ['class' => 'btn btn-success', 'id' => 'SettingsAjaxButton']);

    ActiveForm::end();