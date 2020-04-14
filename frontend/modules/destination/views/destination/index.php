<?php

use common\models\ArticleCategory;
use common\models\Category;
use common\models\Destination;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\destination\models\DestinationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $themes */

$this->title = 'Сайты размещения';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="destination-index">

    <p>
        <?= Html::a('Добавить', ['add'], ['class' => 'btn btn-success']) ?>
<!--        --><?php //echo Html::button('Получить заголовки', ['class' => 'btn btn-success title_destination']); ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'id' => 'grid',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //['class' => 'yii\grid\CheckboxColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
//                'buttons' => [
//                    'delete' => function ($data) {
//                        return Html::a("<span class='glyphicon glyphicon-trash' aria-hidden='true'></span>", ['/domain/site/customdelete', 'id' => $data]);},
//                ],
            ],
            [
                'format' => 'raw',
                'header' => 'Домен',
                'value' => function ($data) { return $data->domain; },
            ],
            [
                'format' => 'raw',
                'header' => 'Катеория',
                'value' => function ($data) { return '<div class="custom-cell"><a type="button" data-toggle="modal" data-target="#modalDCategory" data-id="' . $data->id
                    . '" class="dcategory" title="Категории"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>&nbsp'
                    . Destination::getCategory($data) . '</div>';},
            ],
            [
                'format' => 'raw',
                'header' => 'Тема',
                'value' => function ($data) { return '<a type="button" data-toggle="modal" data-target="#modalTheme" data-id="' . $data->id
                    . '" class="modal-theme" title="Edit theme"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>&nbsp'
                    . $data->theme;
                },
            ],
            [
                'format' => 'raw',
                'header' => 'Title',
                'value' => function ($data) { return '<a type="button" data-toggle="modal" data-target="#modalTitle" data-id="' . $data->id
                    . '" class="modal-title" title="Edit title"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>&nbsp'
                    . $data->title;
                },
            ],
            [
                'format' => 'raw',
                'header' => 'Keywords',
                'value' => function ($data) { return '<a type="button" data-toggle="modal" data-target="#modalKeywords" data-id="' . $data->id
                    . '" class="modal-keywords" title="Edit keywords"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>&nbsp'
                    . $data->keywords;
                },
            ],
            [
                'format' => 'raw',
                'header' => 'Description',
                'value' => function ($data) { return '<a type="button" data-toggle="modal" data-target="#modalDescription" data-id="' . $data->id
                    . '" class="modal-description" title="Edit description"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>&nbsp'
                    . $data->description;
                },
            ],
        ],
    ]); ?>
</div>

<div class="modal fade" id="modalDCategory" tabindex="-1" role="dialog" aria-labelledby="modalCategoryLabel" aria-hidden="true" data-destination-id="">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <?php
                $form = ActiveForm::begin();

                $model = new ArticleCategory();

                echo $form->field($model, 'category_id')->widget(Select2::class, [
                    'data' => ArrayHelper::map(Category::find()->all(), 'id', 'name'),
                    'options' => ['placeholder' => '...', 'class' => 'form-control', 'id' => 'dcategory_ids', 'multiple' => true],
                    'pluginOptions' => ['allowClear' => true],
                ])->label('Категории');

                echo Html::button('Сохранить', ['class' => 'btn btn-success', 'id' => 'modalDCategoryButton', 'data-dismiss' => "modal"]).'&nbsp';

                echo Html::button('Отмена', ['class' => 'btn btn-danger', 'data-dismiss' => "modal", 'aria-label' => 'Close']);

                ActiveForm::end();
                ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTheme" tabindex="-1" role="dialog" aria-labelledby="modalThemeLabel" aria-hidden="true" data-site-id="">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <?php
                $form = ActiveForm::begin();

                $model = new Destination(); ?>

                <?= $form->field($model, 'theme')->dropDownList(
                    ArrayHelper::map($themes, 'name', 'name'),
                    ['prompt' => '...', 'id' => 'theme']
                    ) ?>

                <?= Html::button('Сохранить', ['class' => 'btn btn-success', 'id' => 'modalThemeButton', 'data-dismiss' => "modal"]) ?>

                <?= Html::button('Отмена', ['class' => 'btn btn-danger', 'data-dismiss' => "modal", 'aria-label' => 'Close']) ?>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTitle" tabindex="-1" role="dialog" aria-labelledby="modalTitleLabel" aria-hidden="true" data-site-id="">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <?php
                $form = ActiveForm::begin();

                $model = new Destination(); ?>

                <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'id' => 'title']) ?>

                <?= Html::button('Сохранить', ['class' => 'btn btn-success', 'id' => 'modalTitleButton', 'data-dismiss' => "modal"]) ?>

                <?= Html::button('Отмена', ['class' => 'btn btn-danger', 'data-dismiss' => "modal", 'aria-label' => 'Close']) ?>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalKeywords" tabindex="-1" role="dialog" aria-labelledby="modalKeywordsLabel" aria-hidden="true" data-site-id="">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <?php
                $form = ActiveForm::begin();

                $model = new Destination(); ?>

                <?= $form->field($model, 'keywords')->textInput(['maxlength' => true, 'id' => 'keywords']) ?>

                <?= Html::button('Сохранить', ['class' => 'btn btn-success', 'id' => 'modalKeywordsButton', 'data-dismiss' => "modal"]) ?>

                <?= Html::button('Отмена', ['class' => 'btn btn-danger', 'data-dismiss' => "modal", 'aria-label' => 'Close']) ?>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDescription" tabindex="-1" role="dialog" aria-labelledby="modalDescriptionLabel" aria-hidden="true" data-site-id="">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <?php
                $form = ActiveForm::begin();

                $model = new Destination(); ?>

                <?= $form->field($model, 'description')->textInput(['maxlength' => true, 'id' => 'description']) ?>

                <?= Html::button('Сохранить', ['class' => 'btn btn-success', 'id' => 'modalDescriptionButton', 'data-dismiss' => "modal"]) ?>

                <?= Html::button('Отмена', ['class' => 'btn btn-danger', 'data-dismiss' => "modal", 'aria-label' => 'Close']) ?>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>