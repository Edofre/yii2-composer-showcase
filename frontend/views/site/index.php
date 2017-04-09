<?php

/* @var $this yii\web\View */
/* @var $packages [] */

use yii\bootstrap\Html;
use yii\grid\GridView;

$this->title = 'My Yii Packages';
?>
<div class="site-index">
    <div class="body-content">
        <div class="row">
            <?= GridView::widget([
                'dataProvider' => new \yii\data\ArrayDataProvider(['allModels' => $packages]),
                'columns'      => [
                    'name',
                    [
                        'label'  => 'Link',
                        'format' => 'raw',
                        'value'  => function ($data) {
                            return Html::a($data['name'], [$data['link']]);
                        },
                    ],
                    'github:url',
                    'composer:url',
                    'version',
                ],
            ]) ?>
        </div>
    </div>
</div>
