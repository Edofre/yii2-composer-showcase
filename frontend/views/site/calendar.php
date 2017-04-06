<?php

/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\web\JsExpression;

$this->title = 'Calendar';
?>
<div class="site-calendar">
    <div class="body-content">

        <!--        --><? //= edofre\fullcalendar\Fullcalendar::widget([
        //            'options'       => [
        //                'id'       => 'calendar',
        //                'language' => 'nl',
        //            ],
        //            'clientOptions' => [
        //                'now'         => '2016-03-17',
        //                'weekNumbers' => true,
        ////                'selectable'  => true,
        //                'defaultView' => 'agendaWeek',
        ////                'eventResize' => new JsExpression("
        ////                    function(event, delta, revertFunc, jsEvent, ui, view) {
        ////                        console.log(event);
        ////                    }
        ////                "),
        //            ],
        //            //            'events'        => Url::to(['site/events', 'id' => uniqid()]),
        //            'events'        => $events,
        //        ]);
        //        ?>

        <?=
        edofre\fullcalendar\Fullcalendar::widget([
            'options'       => [
                'id'       => 'calendar',
                'language' => 'nl',
            ],
            'clientOptions' => [
                'now'          => '2016-03-17',
                'weekNumbers'  => true,
                'selectable'   => true,
                'selectHelper' => true,
                'editable'     => true,
                'droppable'    => true,
                'draggable'    => true,
                'defaultView'  => 'agendaWeek',
                'eventResize'  => new JsExpression("
function(event, delta, revertFunc, jsEvent, ui, view) {
console.log(event);
}
"),
            ],
            'events'        => $events,
        ]);


        ?>

    </div>
</div>
