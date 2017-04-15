<?php

/* @var $this yii\web\View */

use edofre\sliderpro\models\Slide;
use edofre\sliderpro\models\slides\Caption;
use edofre\sliderpro\models\slides\Image;
use edofre\sliderpro\models\slides\Layer;

$this->title = 'Slider pro';

?>
<div class="site-slider-pro">
    <div class="body-content">

        <?php
        $slides = [
            new Slide([
                'items' => [
                    new Image(['src' => '/images/test.jpg']),
                ],
            ]),
            new Slide([
                'items' => [
                    new Image(['src' => '/images/test1.png']),
                    new Caption(['tag' => 'p', 'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.']),
                ],
            ]),
            new Slide([
                'items' => [
                    new Image(['src' => '/images/test2.png']),
                    new Layer(['tag' => 'h3', 'content' => 'Lorem ipsum dolor sit amet', 'htmlOptions' => ['class' => 'sp-black', 'data-position' => "bottomLeft", 'data-horizontal' => "10%", 'data-show-transition' => "left", 'data-show-delay' => "300", 'data-hide-transition' => "right"]]),
                    new Layer(['tag' => 'p', 'content' => 'consectetur adipisicing elit', 'htmlOptions' => ['class' => 'sp-white sp-padding', 'data-width' => "200", 'data-horizontal' => "center", 'data-vertical' => "40%", 'data-show-transition' => "down", 'data-hide-transition' => "up"]]),
                    new Layer(['tag' => 'div', 'content' => 'Static content', 'htmlOptions' => ['class' => 'sp-static']]),
                ],
            ]),
            new Slide([
                'content' =>
                    '<a class="sp-video" href="http://vimeo.com/109354891">
                        <img src="http://lorempixel.com/960/500/sports/5" width="500" height="300"/>
                    </a>',
            ]),
            new Slide([
                'items' => [
                    new Layer(['tag' => 'h3', 'content' => 'Lorem ipsum dolor sit amet']),
                    new Layer(['tag' => 'p', 'content' => 'Consectetur adipisicing elit']),
                ],
            ]),
        ];

        $thumbnails = [
            new \edofre\sliderpro\models\Thumbnail(['tag' => 'img', 'htmlOptions' => ['src' => "/images/ttest.jpg", 'data-src' => "/images/test.jpg"]]),
            new \edofre\sliderpro\models\Thumbnail(['tag' => 'img', 'htmlOptions' => ['src' => "/images/ttest1.png", 'data-src' => "/images/test1.png"]]),
            new \edofre\sliderpro\models\Thumbnail(['tag' => 'img', 'htmlOptions' => ['src' => "/images/ttest2.png", 'data-src' => "/images/test2.png"]]),
            new \edofre\sliderpro\models\Thumbnail(['tag' => 'p', 'content' => 'Thumbnail for video']),
            new \edofre\sliderpro\models\Thumbnail(['tag' => 'p', 'content' => 'Thumbnail 5']),
        ];
        ?>

        <?= \edofre\sliderpro\SliderPro::widget([
            'id'            => 'my-slider',
            'slides'        => $slides,
            'thumbnails'    => $thumbnails,
            'sliderOptions' => [
                'width'  => 960,
                'height' => 500,
                'arrows' => true,
                'init'   => new \yii\web\JsExpression("
			function() {
				console.log('slider is initialized');
			}
		"),
            ],
        ]);
        ?>

    </div>
</div>
