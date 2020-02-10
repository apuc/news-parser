<?php

use yii\helpers\Html;

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
                        'icon' => 'pencil',
                        'url' => ['/article/article'],
                        'active' => \Yii::$app->controller->id == 'article',
                    ],
                    [
                        'label' => 'Сайты назначения',
                        'icon' => 'list-alt',
                        'url' => ['/destination/destination'],
                        'active' => \Yii::$app->controller->id == 'destination',
                    ],
                    [
                        'label' => 'Сайты источники',
                        'icon' => 'list-alt',
                        'url' => ['/source/source'],
                        'active' => \Yii::$app->controller->id == 'source',
                    ],
                    [
                        'label' => 'Категории',
                        'icon' => 'tags',
                        'url' => ['/category/category'],
                        'active' => \Yii::$app->controller->id == 'category',
                    ],
                    [
                        'label' => 'Темы',
                        'icon' => 'tags',
                        'url' => ['/theme/theme'],
                        'active' => \Yii::$app->controller->id == 'theme',
                    ],
                    [
                        'label' => 'Картинки',
                        'icon' => 'image',
                        'url' => ['/image/image'],
                        'active' => \Yii::$app->controller->id == 'image',
                    ],
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
                ],
            ]
        ) ?>

    </section>

</aside>
