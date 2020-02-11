<?php

use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model common\models\Article */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-form">

    <?php
//    $data = array();
//    Pjax::begin(['id' => 'reload']);
    $form = ActiveForm::begin();

    echo $form->field($model, 'name')->textInput(['maxlength' => true]);

    echo $form->field($model, 'language_id')->dropDownList(
        \yii\helpers\ArrayHelper::map(common\models\Language::find()->all(), 'id', 'language'),
        ['prompt' => '...']
    );

    echo $form->field($model, 'source_type')->dropDownList([
            'Получено с сайта' => 'с сайта',
            'Автоматический перевод' => 'перевод',
            'Добавлено вручную' => 'добавлено вручную',
            'Считано из файла' => 'из файла'
        ], ['id' => 'rel',
            'prompt' => '...',
        ]
    );

//    switch ($model->source_type) {
//        case 'Получено с сайта':
//            break;
//        case 'Автоматический перевод':
//            break;
//        case 'Добавлено вручную':
//            $data = \yii\helpers\ArrayHelper::map(common\models\User::find()->all(), 'id', 'username');
//            break;
//        case 'Считано из файла':
//            break;
//    }
//
//    echo $form->field($model, 'article_source')->dropDownList(
//        $data,
//        ['prompt' => '...', 'onchange' => 'reload();']
//    );

    echo $form->field($model, 'article_source')->textInput(['maxlength' => true]);

    echo $form->field($model, 'text')->widget(CKEditor::className(),[
        'editorOptions' => [
            'preset' => 'full',
            'inline' => false,
        ],
    ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php
    ActiveForm::end();
    //Pjax::end();
    ?>

</div>
