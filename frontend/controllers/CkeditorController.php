<?php

namespace frontend\controllers;

use yii\web\Controller;

/**
 * Class Ckeditor
 * @package frontend\controllers
 */
class CkeditorController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
