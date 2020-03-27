<?php

use common\classes\Debug;
use common\models\ArticleCategory;
use common\models\Category;
use frontend\modules\article\models\Article;
use kartik\select2\Select2;
use PhpQuery\PhpQuery;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\article\models\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Статьи';
$this->params['breadcrumbs'][] = $this->title;

    echo Html::a('Добавить статью вручную', ['create'], ['class' => 'btn btn-success']).'&nbsp';
    echo Html::a('Загрузить статьи из файла', ['read'], ['class' => 'btn btn-success']);
    echo Html::button('Разместить сатьи на сатах размещения', ['class' => 'btn btn-success send-articles']);
    // echo Html::button('Спарсить сатьи', ['class' => 'btn btn-success parse']);
    // echo Html::button('Перевести статьи', ['class' => 'btn btn-success translate']);

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\CheckboxColumn'],
            ['class' => 'yii\grid\ActionColumn'],
            'name',
            [
                'format' => 'raw',
                'header' => 'Статья',
                'filter' => Html::activeTextInput($searchModel, 'text', ['class' => 'form-control']),
                'value' => function ($data) { return '<div class="fixed-height">'.$data->text.'</div>'; }
            ],
            [
                'format' => 'raw',
                'header' => 'Катеория',
                'filter' => Html::activeTextInput($searchModel, 'category', ['class' => 'form-control']),
                'value' => function ($data) { return '<a type="button" data-toggle="modal" data-target="#modalCategory" data-id="' . $data->id
                    . '" class="category" title="Категории"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>&nbsp'
                    . Article::getCategory($data); },
            ],
            'language.language',
        ],
    ]);
    ?>

<div class="modal fade" id="modalCategory" tabindex="-1" role="dialog" aria-labelledby="modalCategoryLabel" aria-hidden="true" data-site-id="">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <?php
                $form = ActiveForm::begin();

                $model = new ArticleCategory();

                echo $form->field($model, 'category_id')->widget(Select2::class, [
                    'data' => ArrayHelper::map(Category::find()->all(), 'id', 'name'),
                    'options' => ['placeholder' => '...', 'class' => 'form-control', 'id' => 'category_ids', 'multiple' => true],
                    'pluginOptions' => ['allowClear' => true],
                ])->label('Категории');
                ?>
                <div class="form-group">
                    <?= Html::button('Сохранить', ['class' => 'btn btn-success', 'id' => 'modalCategoryButton', 'data-dismiss' => "modal"]) ?>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Отмена</button>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
