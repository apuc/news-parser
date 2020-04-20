<?php

use common\models\ArticleCategory;
use common\models\Category;
use common\models\Language;
use frontend\modules\article\models\Article;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\article\models\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Статьи';
$this->params['breadcrumbs'][] = $this->title;

    echo Html::a('Добавить', ['create'], ['class' => 'btn btn-success']).'&nbsp';
    echo Html::a('Загрузить из файла', ['read'], ['class' => 'btn btn-success']).'&nbsp';
    echo Html::a('Отправить', ['#'], ['class' => 'btn btn-success', 'type' => 'button',
        'data-toggle' => 'modal',  'data-target' => '#modalSelectDestinations']).'&nbsp';
    echo Html::a('Перевести', ['#'], ['class' => 'btn btn-success', 'type' => 'button',
        'data-toggle' => 'modal',  'data-target' => '#modalSelectLanguages']).'&nbsp';

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'id' => 'grid_articles',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\CheckboxColumn'],
            ['class' => 'yii\grid\ActionColumn'],
//            [
//                'format' => 'raw',
//                'header' => '',
//                'value' => function ($data) {
//                    return '<a type="button" data-toggle="modal" data-target="#modalSelectLanguages" id="'
//                        . $data->id . '" class="id" title="Перевести">'
//                        . '<span class="glyphicon glyphicon-globe" aria-hidden="true"></span>'
//                        . '</a>&nbsp';
//                }
//            ],
            'name',
            [
                'format' => 'raw',
                'header' => 'Статья',
                'filter' => Html::activeTextInput($searchModel, 'text', ['class' => 'form-control']),
                'value' => function ($data) {
                    return '<div class="fixed-height fixed-width" title="' . $data->text . '">'.$data->text.'</div>';
                }
            ],
            [
                'format' => 'raw',
                'header' => 'Катеория',
                'filter' => Html::activeTextInput($searchModel, 'category', ['class' => 'form-control']),
                'value' => function ($data) {
                    $str = Article::getCategory($data);
                    return '<div class="fixed-width" title="' . $str . '">'
                        . '<a type="button" data-toggle="modal" data-target="#modalCategory" data-id="' . $data->id
                        . '" class="category" title="Категории">'
                        . '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>'
                        . '</a>&nbsp' . $str . '</div>'; },
            ],
            [
                'format' => 'raw',
                'header' => 'Сайты размещения',
                'value' => function ($data) {
                    $str = Article::getDestination($data);
                    return '<div class="fixed-width" title="' . $str . '">'
                        . '<a type="button" data-toggle="modal" data-target="#modalDestination" data-id="' . $data->id
                        . '" class="destination" title="Сайты размещения">'
                        . '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>'
                        . '</a>&nbsp' . $str . '</div>'; },
            ],
            'language.language',
            'title',
            'description',
            'keywords',
            'url'
        ],
    ]);
    ?>

<div class="modal fade" id="modalCategory" tabindex="-1" role="dialog" aria-labelledby="modalCategoryLabel"
     aria-hidden="true" data-site-id="">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <?php
                $form = ActiveForm::begin();

                $model = new ArticleCategory();

                echo $form->field($model, 'category_id')->widget(Select2::class, [
                    'data' => ArrayHelper::map(Category::find()->all(), 'id', 'name'),
                    'options' => ['placeholder' => '...', 'class' => 'form-control', 'id' => 'category_ids',
                        'multiple' => true],
                    'pluginOptions' => ['allowClear' => true],
                ])->label('Категории');
                ?>
                <div class="form-group">
                    <?= Html::button('Сохранить', ['class' => 'btn btn-success', 'id' => 'modalCategoryButton',
                        'data-dismiss' => "modal"]) ?>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Отмена</button>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDestination" tabindex="-1" role="dialog" aria-labelledby="modalDestinationLabel"
     aria-hidden="true" data-site-id="">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <?php
                $form = ActiveForm::begin();

                $model = new \common\models\DestinationArticle();

                echo $form->field($model, 'destination_id')->widget(Select2::class, [
                    'data' => ArrayHelper::map(\common\models\Destination::find()->all(), 'id', 'domain'),
                    'options' => ['placeholder' => '...', 'class' => 'form-control', 'id' => 'destination_ids',
                        'multiple' => true],
                    'pluginOptions' => ['allowClear' => true],
                ])->label('Сайты размещения');
                ?>
                <div class="form-group">
                    <?= Html::button('Сохранить', ['class' => 'btn btn-success',
                        'id' => 'modalDestinationButton', 'data-dismiss' => "modal"]) ?>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Отмена</button>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalSelectDestinations" tabindex="-1" role="dialog"
     aria-labelledby="modalSelectDestinationsLabel" aria-hidden="true" data-site-id="">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <?php
                $form = ActiveForm::begin();

                $model = new \common\classes\Destinations();

                echo $form->field($model, 'destinations_ids')->widget(Select2::class, [
                    'data' => ArrayHelper::map(\common\models\Destination::find()->all(), 'id', 'domain'),
                    'options' => ['placeholder' => '...', 'class' => 'form-control', 'id' => 'destinations_idss',
                        'multiple' => true],
                    'pluginOptions' => ['allowClear' => true],
                ])->label('Сайты размещения');
                ?>
                <div class="form-group">
                    <?= Html::button('Отправить', ['class' => 'btn btn-success',
                        'id' => 'modalSelectDestinationsButton', 'data-dismiss' => "modal"]) ?>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Отмена</button>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
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