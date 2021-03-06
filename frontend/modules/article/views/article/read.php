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

$name = $model->csv ? $model->csv[0]->name: 'файл не выбран';
echo Html::img('/img/3.png', ['width' => '40']).'&nbsp';
echo 'Считать статьи из файла: ' .  $name . '<br><br>';
echo Html::button('Считать', [
    'class' => 'btn btn-primary read',
    'id' => $model->csv ? $model->csv[0]->name: 0,
    'title' => 'Чтобы счиать данные выберите файл'
]);
echo '<br><br>';

echo 'Выполните последовательно 1, 2 и 3 шаги, и перейдите на вклдаку "Статьи".';

ActiveForm::end();
 ?>
