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

$this->title = 'Сайты размещения';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="destination-index">

    <p>
        <?= Html::a('Добавить', ['add'], ['class' => 'btn btn-success']) ?>
        <?= Html::button('Получить заголовки', ['class' => 'btn btn-success title_destination']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'id' => 'grid',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\CheckboxColumn'],
            ['class' => 'yii\grid\ActionColumn'],
            'domain',
            'title',
            [
                'format' => 'raw',
                'header' => 'Катеория',
                'value' => function ($data) { return '<a type="button" data-toggle="modal" data-target="#modalDCategory" data-id="' . $data->id
                    . '" class="dcategory" title="Категории"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>&nbsp'
                    . Destination::getCategory($data); },
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
