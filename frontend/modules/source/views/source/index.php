<?php

use common\models\ArticleCategory;
use common\models\Category;
use common\models\Language;
use common\models\Source;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\source\models\SourceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Сайты источники';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="source-index">
    <?php
    echo Html::a('Добавить', ['add'], ['class' => 'btn btn-success']).'&nbsp';

    echo Html::button('Получить заголовки', ['class' => 'btn btn-success title_source']).'&nbsp';

    echo Html::button('Спарсить', ['class' => 'btn btn-success parse']);

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'id' => 'grid',
        'tableOptions' => [
            'id' => 'source-table',
            'class' => 'table table-striped table-bordered custom-table',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\ActionColumn'],
            ['class' => 'yii\grid\CheckboxColumn'],
            'domain:url',
            [
                'format' => 'raw',
                'header' => 'Родитель',
                'value' => function ($data) {
                    $src = Source::findOne($data->parent_id);
                    if($src) return '<a href="'.$src->domain.'">'.$src->domain.'</a>';
                    else return '';
                },
            ],
            [
                'format' => 'raw',
                'header' => 'Язык',
                'value' => function ($data) {
                    try {
                        $lang = Language::findOne($data->language_id);
                        if($lang) return $lang->language;
                        else return '';
                    } catch (Exception $e) {
                        return '';
                    }
                },
            ],
            [
                'format' => 'raw',
                'header' => 'Катеория',
                'value' => function ($data) {
                    $str = Source::getCategory($data);
                    return '<div class="fixed-width" title="' . $str . '">'
                        . '<a type="button" data-toggle="modal" data-target="#modalSourceCategory" data-id="' . $data->id
                        . '" class="category_source" title="Категории">'
                        . '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>'
                        . '</a>&nbsp' . $str . '</div>';
                },
            ],
            [
                'format' => 'raw',
                'header' => 'Тайтл',
                'value' => function ($data) {
                    return '<div class="fixed-height fixed-width" title="' . $data->title . '">' . $data->title . '</div>';
                }
            ],
            'links_rule',
            'title_rule',
            'article_rule',
            'parse_type',
            'regex',
            'start_parse',
            'end_parse',
        ],
    ]);
    ?>
</div>

<div class="modal fade" id="modalSourceCategory" tabindex="-1" role="dialog" aria-labelledby="modalSourceCategoryLabel"
     aria-hidden="true" data-site-id="">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <?php
                $form = ActiveForm::begin();

                $model = new ArticleCategory();

                echo $form->field($model, 'category_id')->widget(Select2::class, [
                    'data' => ArrayHelper::map(Category::find()->all(), 'id', 'name'),
                    'options' => ['placeholder' => '...', 'class' => 'form-control', 'id' => 'category_source_ids',
                        'multiple' => true],
                    'pluginOptions' => ['allowClear' => true],
                ])->label('Категории');
                ?>
                <div class="form-group">
                    <?= Html::button('Сохранить', ['class' => 'btn btn-success', 'id' => 'modalSourceCategoryButton',
                        'data-dismiss' => "modal"]) ?>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Отмена</button>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
