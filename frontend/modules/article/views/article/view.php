<?php

use common\classes\Debug;
use common\classes\TextHandler;
use frontend\modules\article\models\Article;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Article */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Статьи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="article-view">

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уыеренны, что хотите удалить эту статью?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'article_source',
            'source_type',
            'language.language',
            [
                'format' => 'raw',
                'attribute' => 'Катеория',
                'value' => function ($data) { return Article::getCategory($data); },
            ],
            'text:ntext',
        ],
    ]) ?>

    <?php
    $t = new TextHandler($model->text);
    $t->handle();
    $colors = $t->getColors();
    $amount = $t->getAmount();

    echo 'Значение цветов:<br>';
    for($i = 0; $i < count($amount); $i++) {
        echo '<span style="background-color: rgb('. $colors[$i] .', 196, 0)">Частота: ' . $amount[$i] . '</span><br>';
    }

    echo '<h3>Предпросмотр:</h3>';
    echo '<pre style="background: lightgray; border: 1px solid lightgray; padding: 2px">';
    echo $t->getColoredText();
    echo '</pre>';
    ?>

</div>
