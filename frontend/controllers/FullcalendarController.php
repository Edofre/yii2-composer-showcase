<?php
namespace frontend\controllers;

use edofre\fullcalendarscheduler\models\Event;
use edofre\fullcalendarscheduler\models\Resource;
use Yii;
use yii\web\Controller;

/**
 * Class SchedulerController
 * @package frontend\controllers
 */
class SchedulerController extends Controller
{
    public function actionEvents2()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return '[{"id":203,"resourceId":11,"title":"Anestesia","allDay":false,"start":"2016-10-07 11:00:00","end":"2016-10-07 14:00:00","url":null,"className":null,"editable":true,"startEditable":true,"durationEditable":true,"rendering":null,"overlap":true,"constraint":null,"source":null,"color":null,"backgroundColor":null,"borderColor":null,"textColor":null},{"id":289,"resourceId":13,"title":"Anestesia","allDay":false,"start":"2016-10-10 10:00:00","end":"2016-10-10 14:00:00","url":null,"className":null,"editable":true,"startEditable":true,"durationEditable":true,"rendering":null,"overlap":true,"constraint":null,"source":null,"color":null,"backgroundColor":null,"borderColor":null,"textColor":null}]';
    }

    public function actionResources2()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return '[{"id":13,"title":"Analia","eventColor":null,"eventBackgroundColor":"#423824","eventBorderColor":"#423824","eventTextColor":null,"eventClassName":null,"children":[],"parentId":null,"parent":null},{"id":11,"title":"Catalina","eventColor":null,"eventBackgroundColor":"#32ba79","eventBorderColor":"#32ba79","eventTextColor":null,"eventClassName":null,"children":[],"parentId":null,"parent":null}]';
    }

    /**
     * @param $id
     * @return array
     */
    //	public function actionResources($id)
    public function actionResources()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return [
            new Resource(["id" => "a", "title" => "Auditorium A"]),
            new Resource(["id" => "b", "title" => "Auditorium B", "eventColor" => "green"]),
            new Resource(["id" => "c", "title" => "Auditorium C", "eventColor" => "orange"]),
            new Resource([
                "id"       => "d",
                "title"    => "Auditorium D",
                "children" => [
                    new Resource(["id" => "d1", "title" => "Room D1"]),
                    new Resource(["id" => "d2", "title" => "Room D2"]),
                ],
            ]),
            new Resource(["id" => "e", "title" => "Auditorium E"]),
            new Resource(["id" => "f", "title" => "Auditorium F", "eventColor" => "red"]),
            new Resource(["id" => "g", "title" => "Auditorium G"]),
            new Resource(["id" => "h", "title" => "Auditorium H"]),
            new Resource(["id" => "i", "title" => "Auditorium I"]),
            new Resource(["id" => "j", "title" => "Auditorium J"]),
            new Resource(["id" => "k", "title" => "Auditorium K"]),
            new Resource(["id" => "l", "title" => "Auditorium L"]),
            new Resource(["id" => "m", "title" => "Auditorium M"]),
            new Resource(["id" => "n", "title" => "Auditorium N"]),
            new Resource(["id" => "o", "title" => "Auditorium O"]),
            new Resource(["id" => "p", "title" => "Auditorium P"]),
            new Resource(["id" => "q", "title" => "Auditorium Q"]),
            new Resource(["id" => "r", "title" => "Auditorium R"]),
            new Resource(["id" => "s", "title" => "Auditorium S"]),
            new Resource(["id" => "t", "title" => "Auditorium T"]),
            new Resource(["id" => "u", "title" => "Auditorium U"]),
            new Resource(["id" => "v", "title" => "Auditorium V"]),
            new Resource(["id" => "w", "title" => "Auditorium W"]),
            new Resource(["id" => "x", "title" => "Auditorium X"]),
            new Resource(["id" => "y", "title" => "Auditorium Y"]),
            new Resource(["id" => "z", "title" => "Auditorium Z"]),
        ];
    }

    /**
     * @param $id
     * @param $start
     * @param $end
     * @return array
     */
    //	public function actionEvents($id, $start, $end)
    public function actionEvents()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

//        return [
//            ['id' => '1', 'resourceId' => 'b', 'start' => '2016-05-07T02:00:00', 'end' => '2016-05-07T07:00:00', 'title' => 'event 1', 'editable' => true],
//            ['id' => '2', 'resourceId' => 'c', 'start' => '2016-05-07T05:00:00', 'end' => '2016-05-07T22:00:00', 'title' => 'event 2', 'editable' => true],
//            ['id' => '3', 'resourceId' => 'd', 'start' => '2016-05-06', 'end' => '2016-05-08', 'title' => 'event 3', 'editable' => true],
//            ['id' => '4', 'resourceId' => 'e', 'start' => '2016-05-07T03:00:00', 'end' => '2016-05-07T08:00:00', 'title' => 'event 4', 'editable' => true],
//            ['id' => '5', 'resourceId' => 'f', 'start' => '2016-05-07T00:30:00', 'end' => '2016-05-07T02:30:00', 'title' => 'event 5', 'editable' => true],
//        ];
        return [
            new Event(["id" => "1", "resourceId" => "b", "start" => "2016-05-07T02:00:00", "end" => "2016-05-07T07:00:00", "title" => "event 1", 'editable' => true]),
            new Event(["id" => "2", "resourceId" => "c", "start" => "2016-05-07T05:00:00", "end" => "2016-05-07T22:00:00", "title" => "event 2", 'editable' => true]),
            new Event(["id" => "3", "resourceId" => "d", "start" => "2016-05-06", "end" => "2016-05-08", "title" => "event 3", 'editable' => true]),
            new Event(["id" => "4", "resourceId" => "e", "start" => "2016-05-07T03:00:00", "end" => "2016-05-07T08:00:00", "title" => "event 4", 'editable' => true]),
            new Event(["id" => "5", "resourceId" => "f", "start" => "2016-05-07T00:30:00", "end" => "2016-05-07T02:30:00", "title" => "event 5", 'editable' => true]),
        ];
    }
}
