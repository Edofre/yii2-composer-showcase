<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = Yii::t('scheduler', 'Planificación');
$this->params['breadcrumbs'][] = ['label' => Yii::t('scheduler', 'Planificación'), 'url' => ['index']];

$this->registerJs("

/* initialize the external events
-----------------------------------------------------------------/
var loading = function (data) {
if (data=='show') {
Pace.restart();
$('#loading_scheduler').removeClass('hide');
} else {
$('#loading_scheduler').addClass('hide');
}
}
/ initialize the external events
-----------------------------------------------------------------*/
$('#external-events .fc-event').each(function() {
// store data so the calendar knows to render an event upon drop
$(this).data('event', {
title: $.trim($(this).text()), // use the element's text as the event title
stick: true // maintain when user navigates (see docs on the renderEvent method)
});
// make the event draggable using jQuery UI
$(this).draggable({
zIndex: 999,
revert: true, // will cause the event to go back to its
revertDuration: 0 // original position after the drag
});
});
", \yii\web\View::POS_END);

?>

<div class="row">
    <div class="col-xs-12 col-sm-12">
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <?= Yii::t('app', 'Filtros') ?>
                </h3>
                <img src="<?= Yii::getAlias('@web'); ?>/img/loading.gif" style="margin-left:10px;margin-top:-5px" alt="" id="loading_scheduler" class="hide" />
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-2">
                        <div id="external-events">
                            <h4>
                                <?= Yii::t('rol', 'Roles') ?>
                            </h4>
                            <?php
                            foreach ($dataProvider->models as $model) {
                                echo '<div class="fc-event" data-rolid="'.$model->id.'" data-duration="'.date('i\:s', mktime(0,0,Yii::$app->params['duration'])).'">'.$model->name.'</div>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-10">
                        <?= \edofre\fullcalendarscheduler\FullcalendarScheduler::widget([
                            'header'        => [
                                'left'   => 'today prev,next',
                                'center' => 'title',
                                'right'  => 'timelineDay,agendaWeek,month,listDay',
                            ],
                            'clientOptions' => [
                                'schedulerLicenseKey' => 'CC-Attribution-NonCommercial-NoDerivatives',
                                'now'                 => date('Y-m-d'),
                                //'aspectRatio'       => 3.8,
                                'displayEventTime'    => true,
                                'droppable'           => true,
                                'displayEventEnd'     => true,
                                /*'dragRevertDuration'  => 0,*/
                                //'durationEditable'    => true,
                                //'resourceEditable'    => true,
                                'eventDurationEditable' => true,
                                'scrollTime'          => '09:00',
                                'defaultView'         => 'timelineDay',
                                'timeFormat'          => 'HH:mm',
                                'resourceAreaWidth'   => '15%',
                                'views'               => [
                                    'timelineDay'       => [
                                        'slotDuration'    => '00:30',
                                        'snapDuration'    => '00:10',
                                        'slotLabelFormat' => ['HH:mm']
                                    ],
                                ],
                                'resourceLabelText' => Yii::t('employee', 'Empleados'),
                                'eventOverlap'      => true,
                                'resources'         => \yii\helpers\Url::to(['scheduler/resources2']),
                                'events'            => \yii\helpers\Url::to(['scheduler/events2']),
                                'resourceColumns'   => [
                                    ['render' => new \yii\web\JsExpression("
              function(resource, el) {
                el.css('color', '#696969');
                //el.css('font-weight', 'bold');
                el.html('<i class=\"fa fa-user\" style=\"color:'+resource.eventBackgroundColor+'\" aria-hidden=\"true\"></i>&nbsp; '+resource.title);
              }
              "),
                                    ],
                                ],
                                'drop' => new \yii\web\JsExpression("
          function(date, jsEvent, ui, resourceId) {
            var employeeid = resourceId;
            var rolid      = $.trim($(this).attr('data-rolid'));
            var date_start = date.format();
            $.ajax({
              url: '".\yii\helpers\Url::to(['scheduler/create'])."',
              data: 'rolid='+ rolid +'&employeeid='+ employeeid +'&date_start='+ date_start,
              type: 'POST',
              beforeSend: loading('show'),
            }).done(function(data){
              if (data.success)
              {
                $.notify(data.message,{type:'success', delay:1});
                $('#calendar').fullCalendar('removeEvents');
                $('#calendar').fullCalendar('refetchEvents');
              } else {
                $.notify(data.message,{type:'error', delay:10});
                $('#calendar').fullCalendar('removeEvents');
                $('#calendar').fullCalendar('refetchEvents');
              }
            }).always(function(){
              loading('hide');
            }).fail(function(response){
              $.notify(response,{type:'error', delay:10});
              $('#calendar').fullCalendar('removeEvents');
              $('#calendar').fullCalendar('refetchEvents');
            });
          }
        "),
                                'eventReceive' => new \yii\web\JsExpression("
          function(event) { // called when a proper external event is dropped
            event.editable = true;
            event.resourceEditable = true;
            event.eventDurationEditable = true;
          }
        "),
                                'eventClick' => new \yii\web\JsExpression("
          function(calEvent, jsEvent, view) {
            var eventid = calEvent.id;
            if (bootbox.confirm('".Yii::t('scheduler', 'Está seguro que desea eliminar el evento ?')."', function(result) {
              if (result){
                $.ajax({
                  url: '".\yii\helpers\Url::to(['scheduler/delete'])."/?id=' + eventid,
                  data: 'id='+ eventid,
                  type: 'POST',
                  async: false,
                  beforeSend: function(){
                    loading('show');
                  },
                }).done(function(data){
                  if (data.success)
                  {
                    $('#calendar').fullCalendar('removeEvents', eventid);
                    $.notify(data.message,{type:'success', delay:1});
                    $('#calendar').fullCalendar('removeEvents');
                    $('#calendar').fullCalendar('refetchEvents');
                  } else {
                    $.notify(data.message,{type:'error', delay:10});
                  }
                }).always(function(){
                  loading('hide');
                }).fail(function(response){
                  $.notify(response,{type:'error', delay:10});
                });
              }
            }));
          }
        "),
                                'eventDrop'    => new \yii\web\JsExpression("
          function(event) { // called when an event (already on the calendar) is moved
            var schedulerid = event.id;
            var employeeid  = event.resourceId;
            var date_start  = event.start.format();
            var date_stop   = event.end.format();
            $.ajax({
              url: '".\yii\helpers\Url::to(['scheduler/update'])."/?id=' + schedulerid,
              data: 'id='+ schedulerid +'&employeeid='+ employeeid +'&date_start='+ date_start +'&date_stop='+ date_stop,
              type: 'POST',
              beforeSend: loading('show'),
            }).done(function(data){
              if (data.success)
              {
                $.notify(data.message,{type:'success', delay:1});
              } else {
                $.notify(data.message,{type:'error', delay:10});
                $('#calendar').fullCalendar('removeEvents');
                $('#calendar').fullCalendar('refetchEvents');
              }
            }).always(function(){
              loading('hide');
            }).fail(function(response){
              $.notify(response,{type:'error', delay:10});
              $('#calendar').fullCalendar('removeEvents');
              $('#calendar').fullCalendar('refetchEvents');
            });
          }
        "),
                                'eventResize' => new \yii\web\JsExpression("
          function(event, delta, revertFunc) {
            var schedulerid = event.id;
            var employeeid  = event.resourceId;
            var date_start  = event.start.format();
            var date_stop   = event.end.format();
            $.ajax({
              url: '".\yii\helpers\Url::to(['scheduler/update'])."/?id=' + schedulerid,
              data: 'id='+ schedulerid +'&employeeid='+ employeeid +'&date_start='+ date_start +'&date_stop='+ date_stop,
              type: 'POST',
              beforeSend: loading('show'),
            }).done(function(data){
              if (data.success)
              {
                $.notify(data.message,{type:'success', delay:1});
              } else {
                $.notify(data.message,{type:'error', delay:10});
                $('#calendar').fullCalendar('removeEvents');
                $('#calendar').fullCalendar('refetchEvents');
              }
            }).always(function(){
              loading('hide');
            }).fail(function(response){
              $.notify(response,{type:'error', delay:10});
              $('#calendar').fullCalendar('removeEvents');
              $('#calendar').fullCalendar('refetchEvents');
            });
          }
        "),
                            ],
                        ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->registerCss('
#wrap {
width: 1100px;
margin: 0 auto;
}
#external-events {
float: left;
width: 100%;
padding: 0 10px;
border: 1px solid #ccc;
background: #eee;
text-align: left;
margin-bottom: 10px;
}
#external-events h4 {
font-size: 16px;
margin-top: 0;
padding-top: 1em;
}
#external-events .fc-event {
margin: 10px 0;
cursor: pointer;
line-height: 1.8em;
padding-left: 5px;
background: #f4f4f4;
color: #000;
border: 1px solid #ddd;
}
.fc-event-container:hover {
cursor: pointer!important;
}
');
?>`