<?php

use common\classes\TextHandler;
use common\models\Language;
use frontend\modules\article\models\Article;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Article */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Статьи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

YiiAsset::register($this);
?>
<div class="article-view">
    <p>
        <?php
        echo '<span class="id" id="'.$model->id.'"></span>';

        echo Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']).'&nbsp';

        echo Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уыеренны, что хотите удалить эту статью?',
                'method' => 'post',
            ],
        ]).'&nbsp';

        //echo Html::button('Перевести', ['class' => 'btn btn-success translate-one', 'id' => $model->id]).'&nbsp';

        echo Html::a('Перевести', ['#'], ['class' => 'btn btn-success', 'type' => 'button',
                'data-toggle' => 'modal',  'data-target' => '#modalSelectLanguages']).'&nbsp';
        ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'source_id',
            'parent_id',
            [
                'format' => 'raw',
                'attribute' => 'Тип источника',
                'value' => function ($data) {
                    if($data->source_type == 1) return 'Добавлено вручную';
                    elseif($data->source_type == 2) return 'Считано из файла';
                    elseif($data->source_type == 3) return 'Перевод';
                    elseif($data->source_type == 4) return 'Считано с сайта';
                    else return '';
                },
            ],
            'language.language',
            [
                'format' => 'raw',
                'attribute' => 'Катеория',
                'value' => function ($data) { return Article::getCategory($data); },
            ],
            [
                'format' => 'raw',
                'attribute' => 'Сайты&nbsp;размещения',
                'value' => function ($data) { return Article::getDestination($data); },
            ],
            'title',
            'description',
            'keywords',
            'url',
            'text:ntext',
        ],
    ]) ?>

    <?php
    //$t = new TextHandler($model->text);
    //$t->showInfo();
    //$t->showText();
    ?>
</div>

<div class="modal fade" id="modalSelectLanguages" tabindex="-1" role="dialog"
     aria-labelledby="modalSelectLanguagesLabel" aria-hidden="true" data-id="">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <?php
                $form = ActiveForm::begin();

                $model = new Language();

                echo $form->field($model, 'id')->widget(Select2::class, [
                    'data' => ArrayHelper::map(Language::find()->all(), 'id', 'language'),
                    'options' => ['placeholder' => '...', 'class' => 'form-control', 'id' => 'language_ids',
                        'multiple' => true],
                    'pluginOptions' => ['allowClear' => true],
                ])->label('Языки');

                echo Html::button('Отправить', ['class' => 'btn btn-success',
                    'id' => 'modalSelectLanguagesButton', 'data-dismiss' => 'modal']).'&nbsp';

                echo Html::button('Отмена', ['class' => 'btn btn-danger', 'data-dismiss' => 'modal',
                    'aria-label' => 'Close']);

                ActiveForm::end();
                ?>
            </div>
        </div>
    </div>
</div>