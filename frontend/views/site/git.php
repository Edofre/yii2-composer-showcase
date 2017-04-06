<script type="text/javascript">jQuery(document).ready(function () {
        jQuery('#calendar').fullCalendar({
            "loading": function (isLoading, view) {
                jQuery('#calendar').find('.fc-loading').toggle(isLoading);
            },
            "events": "/scheduler/events",
            "resources": "/scheduler/resources",
            "schedulerLicenseKey": "CC-Attribution-NonCommercial-NoDerivatives",
            "now": "2016-12-19",
            "displayEventTime": true,
            "droppable": true,
            "displayEventEnd": true,
            "eventDurationEditable": true,
            "scrollTime": "09:00",
            "defaultView": "timelineDay",
            "timeFormat": "HH:mm",
            "resourceAreaWidth": "15%",
            "views": {"timelineDay": {"slotDuration": "00:30", "snapDuration": "00:10", "slotLabelFormat": ["HH:mm"]}},
            "resourceLabelText": "Empleados",
            "eventOverlap": true,
            "resourceColumns": [{
                "render": function (resource, el) {
                    el.css('color', '#696969');
                    //el.css('font-weight', 'bold');
                    el.html('<i class="fa fa-user" style="color:' + resource.eventBackgroundColor + '" aria-hidden="true"></i>&nbsp; ' + resource.title);
                }
            }],
            "drop": function (date, jsEvent, ui, resourceId) {
                console.log('wat');
                var employeeid = resourceId;
                console.log('hier');

                var rolid = $.trim($(this).attr('data-rolid'));
                var date_start = date.format();
                $.ajax({url: '/scheduler/create', data: 'rolid=' + rolid + '&employeeid=' + employeeid + '&date_start=' + date_start, type: 'POST', beforeSend: loading('show'),}).done(function (data) {
                    if (data.success) {
                        $.notify(data.message, {type: 'success', delay: 1});
                        $('#calendar').fullCalendar('removeEvents');
                        $('#calendar').fullCalendar('refetchEvents');
                    } else {
                        $.notify(data.message, {type: 'error', delay: 10});
                        $('#calendar').fullCalendar('removeEvents');
                        $('#calendar').fullCalendar('refetchEvents');
                    }
                }).always(function () {
                    loading('hide');
                }).fail(function (response) {
                    $.notify(response, {type: 'error', delay: 10});
                    $('#calendar').fullCalendar('removeEvents');
                    $('#calendar').fullCalendar('refetchEvents');
                });
            },
            "eventReceive": function (event) {// called when a proper external event is dropped
                event.editable = true;
                event.resourceEditable = true;
                event.eventDurationEditable = true;
            },
            "eventClick": function (calEvent, jsEvent, view) {
                var eventid = calEvent.id;
                if (bootbox.confirm('Está seguro que desea eliminar el evento ?', function (result) {
                        if (result) {
                            $.ajax({
                                url: '/scheduler/delete/?id=' + eventid, data: 'id=' + eventid, type: 'POST', async: false, beforeSend: function () {
                                    loading('show');
                                },
                            }).done(function (data) {
                                if (data.success) {
                                    $('#calendar').fullCalendar('removeEvents', eventid);
                                    $.notify(data.message, {type: 'success', delay: 1});
                                    $('#calendar').fullCalendar('removeEvents');
                                    $('#calendar').fullCalendar('refetchEvents');
                                } else {
                                    $.notify(data.message, {type: 'error', delay: 10});
                                }
                            }).always(function () {
                                loading('hide');
                            }).fail(function (response) {
                                $.notify(response, {type: 'error', delay: 10});
                            });
                        }
                    }));
            },
            "eventDrop": function (event) { // called when an event (already on the calendar) is moved
                var schedulerid = event.id;
                var employeeid = event.resourceId;
                var date_start = event.start.format();
                var date_stop = event.end.format();
                $.ajax({url: '/scheduler/update/?id=' + schedulerid, data: 'id=' + schedulerid + '&employeeid=' + employeeid + '&date_start=' + date_start + '&date_stop=' + date_stop, type: 'POST', beforeSend: loading('show'),}).done(function (data) {
                    if (data.success) {
                        $.notify(data.message, {type: 'success', delay: 1});
                    } else {
                        $.notify(data.message, {type: 'error', delay: 10});
                        $('#calendar').fullCalendar('removeEvents');
                        $('#calendar').fullCalendar('refetchEvents');
                    }
                }).always(function () {
                    loading('hide');
                }).fail(function (response) {
                    $.notify(response, {type: 'error', delay: 10});
                    $('#calendar').fullCalendar('removeEvents');
                    $('#calendar').fullCalendar('refetchEvents');
                });
            },
            "eventResize": function (event, delta, revertFunc) {
                var schedulerid = event.id;
                var employeeid = event.resourceId;
                var date_start = event.start.format();
                var date_stop = event.end.format();
                $.ajax({url: '/scheduler/update/?id=' + schedulerid, data: 'id=' + schedulerid + '&employeeid=' + employeeid + '&date_start=' + date_start + '&date_stop=' + date_stop, type: 'POST', beforeSend: loading('show'),}).done(function (data) {
                    if (data.success) {
                        $.notify(data.message, {type: 'success', delay: 1});
                    } else {
                        $.notify(data.message, {type: 'error', delay: 10});
                        $('#calendar').fullCalendar('removeEvents');
                        $('#calendar').fullCalendar('refetchEvents');
                    }
                }).always(function () {
                    loading('hide');
                }).fail(function (response) {
                    $.notify(response, {type: 'error', delay: 10});
                    $('#calendar').fullCalendar('removeEvents');
                    $('#calendar').fullCalendar('refetchEvents');
                });
            },
            "header": {"left": "today prev,next", "center": "title", "right": "timelineDay,agendaWeek,month,listDay"}
        });
    });
</script>