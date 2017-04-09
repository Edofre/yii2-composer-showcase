<?= \edofre\fullcalendarscheduler\FullcalendarScheduler::widget([
    'header'        => [
        'left'   => 'today prev,next',
        'center' => 'title',
        'right'  => 'timelineDay,timelineThreeDays,agendaWeek,month',
    ],
    'options'       => [
        'language' => 'es',
    ],
    'clientOptions' => [
        'now'               => '2016-05-07',
        'aspectRatio'       => 1.8,
        'scrollTime'        => '00:00', // undo default 6am scrollTime
        'defaultView'       => 'timelineDay',
        'views'             => [
            'timelineThreeDays' => [
                'type'     => 'timeline',
                'duration' => [
                    'days' => 3,
                ],
            ],
        ],
        'resourceLabelText' => 'Rooms',
        'resources'         => \yii\helpers\Url::to(['fullcalendar-scheduler/resources', 'id' => 1]),
        'events'            => \yii\helpers\Url::to(['fullcalendar-scheduler/events', 'id' => 2]),
    ],
]);
?>