<?php

use common\classes\Debug;
use common\classes\Destinations;
use common\models\ArticleCategory;
use common\models\Category;
use common\models\DestinationArticle;
use common\models\Language;
use common\models\Source;
use common\services\ParseService;
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

    echo Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) . '&nbsp';
    echo Html::a('Загрузить из файла', ['read'], ['class' => 'btn btn-success']) . '&nbsp';
    echo Html::a('Отправить', ['#'], ['class' => 'btn btn-success', 'type' => 'button',
            'data-toggle' => 'modal', 'data-target' => '#modalSelectDestinations']) . '&nbsp';
    echo Html::a('Перевести', ['#'], ['class' => 'btn btn-success', 'type' => 'button',
            'data-toggle' => 'modal', 'data-target' => '#modalSelectLanguages']) . '&nbsp';

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => [
            'id' => 'article-table',
            'class' => 'table table-striped table-bordered custom-table',
        ],
        'id' => 'grid_articles',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\CheckboxColumn'],
            ['class' => 'yii\grid\ActionColumn'],
            [
                'format' => 'raw',
                'header' => 'Заголовок',
                'filter' => Html::activeTextInput($searchModel, 'name', ['class' => 'form-control']),
                'value' => function ($data) {
                    return '<div class="fixed-height fixed-width" title="' . $data->name . '">' . $data->name . '</div>';
                }
            ],
            [
                'format' => 'raw',
               // 'contentOptions' => ['class' => 'fixed-height fixed-width'],
                'header' => 'Статья',
                'filter' => Html::activeTextInput($searchModel, 'text', ['class' => 'form-control']),
                'value' => function ($data) {
                    return '<div class="fixed-height fixed-width" title="' . strip_tags($data->text) . '">' . strip_tags($data->text) . '</div>';
                }
            ],
            'language.language',
            [
                'format' => 'raw',
                'header' => 'Катеория',
                'value' => function ($data) {
                    $str = Article::getCategory($data);
                    return '<div class="fixed-width" title="' . $str . '">'
                        . '<a type="button" data-toggle="modal" data-target="#modalCategory" data-id="' . $data->id
                        . '" class="category" title="Категории">'
                        . '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>'
                        . '</a>&nbsp' . $str . '</div>';
                },
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
                        . '</a>&nbsp' . $str . '</div>';
                },
            ],
//            [
//                'format' => 'raw',
//                'header' => 'Домен',
//                'value' => function ($data) {
//                    if($data->source_type == 4)
//                        return Source::findOne($data->source_id)->domain;
//                    else
//                        return '';
//                },
//            ],
            [
                'format' => 'raw',
                'attribute' => 'Источник',
                'value' => function ($data) {
                    if($data->source_type == 4) {
                        $link = Source::findOne($data->source_id)->domain . substr($data->url, 1);
                        return '<div class="fixed-width" title="'.$link.'">'.'<a href="'.$link.'" target="blank">'.$link.'</a></div>';
                    } else
                        return $data->source_id;
                },
            ],
//            [
//                'format' => 'raw',
//                'header' => 'URL',
//                'filter' => Html::activeTextInput($searchModel, 'url', ['class' => 'form-control']),
//                'value' => function ($data) {
//                    return '<div class="fixed-height fixed-width" title="' . $data->url . '">' . $data->url . '</div>';
//                }
//            ],
            [
                'format' => 'raw',
                'header' => 'Тайтл',
                'filter' => Html::activeTextInput($searchModel, 'title', ['class' => 'form-control']),
                'value' => function ($data) {
                    return '<div class="fixed-height fixed-width" title="' . $data->title . '">' . $data->title . '</div>';
                }
            ],
            [
                'format' => 'raw',
                'header' => 'Description',
                'filter' => Html::activeTextInput($searchModel, 'description', ['class' => 'form-control']),
                'value' => function ($data) {
                    return '<div class="fixed-height fixed-width" title="' . $data->description . '">' . $data->description . '</div>';
                }
            ],
            [
                'format' => 'raw',
                'header' => 'Keywords',
                'filter' => Html::activeTextInput($searchModel, 'keywords', ['class' => 'form-control']),
                'value' => function ($data) {
                    return '<div class="fixed-height fixed-width" title="' . $data->keywords . '">' . $data->keywords . '</div>';
                }
            ],
            [
                'format' => 'raw',
                'header' => 'Url на сайте размещения',
                'filter' => Html::activeTextInput($searchModel, 'new_url', ['class' => 'form-control']),
                'value' => function ($data) {
                    return '<div class="fixed-height fixed-width" title="' . $data->new_url . '">' . $data->new_url . '</div>';
                }
            ],
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

                    $model = new DestinationArticle();

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

                    $model = new Destinations();

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
                            'id' => 'modalSelectLanguagesButton', 'data-dismiss' => 'modal']) . '&nbsp';

                    echo Html::button('Отмена', ['class' => 'btn btn-danger', 'data-dismiss' => 'modal',
                        'aria-label' => 'Close']);

                    ActiveForm::end();
                    ?>
                </div>
            </div>
        </div>
    </div>