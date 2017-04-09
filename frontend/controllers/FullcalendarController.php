<?php

namespace frontend\controllers;

use edofre\fullcalendar\models\Event;
use yii\web\Controller;

/**
 * Class FullcalendarController
 * @package frontend\controllers
 */
class FullcalendarController extends Controller
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
     * @param $start
     * @param $end
     * @return array
     */
    public function actionEvents($id, $start, $end)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return [
            // minimum
            new Event([
                'title' => 'Appointment #' . rand(1, 999),
                'start' => '2016-03-18T14:00:00',
            ]),
            // Everything editable
            new Event([
                'id'               => uniqid(),
                'title'            => 'Appointment #' . rand(1, 999),
                'start'            => '2016-03-17T12:30:00',
                'end'              => '2016-03-17T13:30:00',
                'editable'         => true,
                'startEditable'    => true,
                'durationEditable' => true,
            ]),
            // No overlap
            new Event([
                'id'               => uniqid(),
                'title'            => 'Appointment #' . rand(1, 999),
                'start'            => '2016-03-17T15:30:00',
                'end'              => '2016-03-17T19:30:00',
                'overlap'          => false, // Overlap is default true
                'editable'         => true,
                'startEditable'    => true,
                'durationEditable' => true,
            ]),
            // Only duration editable
            new Event([
                'id'               => uniqid(),
                'title'            => 'Appointment #' . rand(1, 999),
                'start'            => '2016-03-16T11:00:00',
                'end'              => '2016-03-16T11:30:00',
                'startEditable'    => false,
                'durationEditable' => true,
            ]),
            // Only start editable
            new Event([
                'id'               => uniqid(),
                'title'            => 'Appointment #' . rand(1, 999),
                'start'            => '2016-03-15T14:00:00',
                'end'              => '2016-03-15T15:30:00',
                'startEditable'    => true,
                'durationEditable' => false,
            ]),
        ];
    }
}
