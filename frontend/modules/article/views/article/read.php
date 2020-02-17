<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php
$this->title = 'Загрузка из файла';

$form = ActiveForm::begin();
echo Html::img('/img/1.png', ['width' => '40']).'&nbsp';
echo $form->field($model, 'csv[]')->fileInput();
echo '<br>';

echo Html::img('/img/2.png', ['width' => '40']).'&nbsp';
echo Html::submitButton('Сохранить', ['class' => 'btn btn-primary']);
echo '<br><br>';

echo Html::img('/img/3.png', ['width' => '40']).'&nbsp';
echo Html::button('Считать статьи из файла', [
    'class' => 'btn btn-primary read',
    'id' => $model->csv ? $model->csv[0]->name: 0,
    'title' => 'Чтобы счиать данные выберите файл'
]);

ActiveForm::end();
 ?>
