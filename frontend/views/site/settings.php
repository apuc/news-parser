<?php

use common\models\Template;
use frontend\models\SettingsForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $settings
 */

    $this->title = 'Настройки';

    $form = ActiveForm::begin();

    $model = new SettingsForm();

    $model->theme = $settings[0]->value;
    echo '<div class="custom-field">'.$form->field($model, 'theme')->dropDownList(
        ArrayHelper::map(Template::find()->all(), 'name', 'name'),
        ['prompt' => '...']
    ).'</div>';

    $model->title = $settings[1]->value;
    echo '<div class="custom-field">'.$form->field($model, 'title')->textInput(['maxlength' => true]).'</div>';

    $model->keywords = $settings[2]->value;
    echo '<div class="custom-field">'.$form->field($model, 'keywords')->textInput(['maxlength' => true]).'</div>';

    $model->description = $settings[3]->value;
    echo '<div class="custom-field">'.$form->field($model, 'description')->textInput(['maxlength' => true]).'</div>';

    $model->h1 = $settings[4]->value;
    echo '<div class="custom-field">'.$form->field($model, 'h1')->textInput(['maxlength' => true]).'</div>';

    echo Html::button('Сохранить', ['class' => 'btn btn-success', 'id' => 'SettingsAjaxButton']);

    ActiveForm::end();