<?php
namespace frontend\controllers;

use edofre\fullcalendarscheduler\models\Event;
use edofre\fullcalendarscheduler\models\Resource;
use Yii;
use yii\web\Controller;

/**
 * Class FullcalendarSchedulerController
 * @package frontend\controllers
 */
class FullcalendarSchedulerController extends Controller
{

    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @param $id
     * @return array
     */
    public function actionResources($id)
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
    public function actionEvents($id, $start, $end)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return [
            new Event(["id" => "1", "resourceId" => "b", "start" => "2016-05-07T02:00:00", "end" => "2016-05-07T07:00:00", "title" => "event 1", 'editable' => true]),
            new Event(["id" => "2", "resourceId" => "c", "start" => "2016-05-07T05:00:00", "end" => "2016-05-07T22:00:00", "title" => "event 2", 'editable' => true]),
            new Event(["id" => "3", "resourceId" => "d", "start" => "2016-05-06", "end" => "2016-05-08", "title" => "event 3", 'editable' => true]),
            new Event(["id" => "4", "resourceId" => "e", "start" => "2016-05-07T03:00:00", "end" => "2016-05-07T08:00:00", "title" => "event 4", 'editable' => true]),
            new Event(["id" => "5", "resourceId" => "f", "start" => "2016-05-07T00:30:00", "end" => "2016-05-07T02:30:00", "title" => "event 5", 'editable' => true]),
        ];
    }

    public function actionSchedulerResources()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return [
            [
                'id'    => 1,
                'title' => 'test1',
            ],
            [
                'id'       => 2,
                'title'    => 'test2',
                'children' => [
                    [
                        'id'    => 5,
                        'title' => 'Child of 2',
                    ],
                    [
                        'id'                   => 6,
                        'title'                => 'Second child of 2',
                        'eventBackgroundColor' => 'blue',
                        'eventBorderColor'     => 'red',
                        'eventTextColor'       => 'green',
                    ],
                ],
            ],
            [
                'id'    => 3,
                'title' => 'test3',
            ],
            [
                'id'       => 4,
                'title'    => 'Child of 1',
                'parentId' => 1,
            ],
            [
                'id'       => 7,
                'title'    => 'Child of 6',
                'parentId' => 6,
            ],
        ];
    }

    /**
     * @param $id
     * @param $start
     * @param $end
     * @return array
     */
    public function actionSchedulerEvents($id, $start, $end)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return [
            // minimum
            new Event([
                'title' => 'Appointment #' . rand(1, 999),
                'start' => '2016-06-18T14:00:00',
            ]),
            // Everything editable
            new Event([
                'id'               => uniqid(),
                'resourceId'       => 1,
                'title'            => 'Appointment #' . rand(1, 999),
                'start'            => '2016-06-01T12:30:00',
                'end'              => '2016-06-01T13:30:00',
                'editable'         => true,
                'startEditable'    => true,
                'durationEditable' => true,
            ]),
            // No overlap
            new Event([
                'id'               => uniqid(),
                'resourceId'       => 6,
                'title'            => 'Appointment #' . rand(1, 999),
                'start'            => '2016-06-01T12:00:00',
                'end'              => '2016-06-01T14:30:00',
                'overlap'          => false, // Overlap is default true
                'editable'         => true,
                'startEditable'    => true,
                'durationEditable' => true,
            ]),
            // Only duration editable
            new Event([
                'id'               => uniqid(),
                'resourceId'       => 2,
                'rendering'        => 'background',
                'title'            => 'Appointment #' . rand(1, 999),
                'start'            => '2016-06-01T12:30:00',
                'end'              => '2016-06-01T13:30:00',
                'startEditable'    => false,
                'durationEditable' => true,
            ]),
            // Only start editable
            new Event([
                'id'               => uniqid(),
                'resourceId'       => 3,
                'rendering'        => 'inverse-background',
                'title'            => 'Appointment #' . rand(1, 999),
                'start'            => '2016-06-01T12:30:00',
                'end'              => '2016-06-01T13:30:00',
                'startEditable'    => false,
                'durationEditable' => true,
            ]),
        ];
    }
}
