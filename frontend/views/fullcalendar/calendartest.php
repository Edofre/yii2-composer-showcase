<?php

/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\web\JsExpression;

$this->title = 'Calendar';
?>
<div class="site-calendar">
    <div class="body-content">

        <?= edofre\fullcalendar\Fullcalendar::widget([
            'events'        => $events,
            'options'       => [
                'id'       => 'calendar',
                'language' => 'en',
            ],
            'clientOptions' => [
                'now' => '2017-03-02 12:00:00',
                'weekNumbers'      => true,
                'selectable'       => true,
                'selectHelper'     => true,
                'editable'         => true,
                'startEditable'    => true,
                'durationEditable' => true,
                'droppable'        => true,
                'draggable'        => true,
                'defaultView'      => 'agendaWeek',
                'eventResize'      => new JsExpression("
                    function(event, delta, revertFunc, jsEvent, ui, view) {
                        console.log(event);
                    }
                "),
            ],
        ]);
        ?>

    </div>
</div>
