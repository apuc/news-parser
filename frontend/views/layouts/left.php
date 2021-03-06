<?php

use yii\helpers\Html;

/**
 *  @var $directoryAsset
*/
?>
<aside class="main-sidebar">

    <section class="sidebar">
        <?php
        try {
            echo '<div class="user-panel">
            <div class="pull-left image">
                <img src="' . $directoryAsset . '/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info"><p>'
                . Yii::$app->user->identity->username . '</p>'
                . Html::a('<span class="glyphicon glyphicon-log-out"></span> Выйти',
                    ['/site/logout'],
                    ['data-method' => 'post'])
                . '</div></div>';
        } catch (Exception $e) { }
        ?>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    [
                        'label' => 'Статьи',
                        'icon' => 'book',
                        'url' => ['/article/article'],
                        'active' => \Yii::$app->controller->id == 'article',
                    ],
                    [
                        'label' => 'Сайты источники',
                        'icon' => 'file',
                        'url' => ['/source/source'],
                        'active' => \Yii::$app->controller->id == 'source',
                    ],
                    [
                        'label' => 'Сайты размещения',
                        'icon' => 'list-alt',
                        'url' => ['/destination/destination'],
                        'active' => \Yii::$app->controller->id == 'destination',
                    ],
                    [
                        'label' => 'Регулярные выражения',
                        'icon' => 'cog',
                        'url' => ['/regex/regex'],
                        'active' => \Yii::$app->controller->id == 'regex',
                    ],
//                    [
//                        'label' => 'Сайты',
//                        'icon' => 'list-alt',
//                        'items' => [
//                            ['label' => 'Сайты источники', 'icon' => 'list-alt', 'url' => ['/source/source'], 'active' => \Yii::$app->controller->id == 'source'],
//                            ['label' => 'Сайты размещения', 'icon' => 'list-alt', 'url' => ['/destination/destination'], 'active' => \Yii::$app->controller->id == 'destination'],
//                        ]
//                    ],
                    [
                        'label' => 'Очередь',
                        'icon' => 'hourglass',
                        'active' => \Yii::$app->controller->id == 'queue',
                        'items' => [
                            ['label' => 'Парсинг', 'icon' => 'hourglass', 'url' => ['/queue/parsequeue/'],],
                            ['label' => 'Перевод', 'icon' => 'hourglass', 'url' => ['/queue/translatequeue/'],],
                            ['label' => 'Заголовки', 'icon' => 'hourglass', 'url' => ['/queue/titlequeue/sourcequeue'],],
                        ]
                    ],
                    [
                        'label' => 'Категории',
                        'icon' => 'tags',
                        'url' => ['/category/category'],
                        'active' => \Yii::$app->controller->id == 'category',
                    ],
                    [
                        'label' => 'Языки',
                        'icon' => 'comment',
                        'url' => ['/language/language'],
                        'active' => \Yii::$app->controller->id == 'language',
                    ],
//                    [
//                        'label' => 'Картинки',
//                        'icon' => 'image',
//                        'url' => ['/image/image'],
//                        'active' => \Yii::$app->controller->id == 'image',
//                    ],
//                    [
//                        'label' => 'Шаблоны',
//                        'icon' => 'file-o',
//                        'url' => ['/template/template'],
//                        'active' => \Yii::$app->controller->id == 'template',
//                    ],
//                    [
//                        'label' => 'Просмотры',
//                        'icon' => 'eye',
//                        'url' => ['/view/view'],
//                        'active' => \Yii::$app->controller->id == 'view',
//                    ],
                    [
                        'label' => 'Пользователи',
                        'icon' => 'user',
                        'url' => ['/user/user'],
                        'active' => \Yii::$app->controller->id == 'user',
                    ],
//                    [
//                        'label' => 'Настройки',
//                        'icon' => 'cog',
//                        'url' => ['/site/settings'],
//                        'active' => \Yii::$app->controller->id == 'site',
//                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
