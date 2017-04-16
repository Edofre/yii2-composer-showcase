<?php
namespace frontend\controllers;

use yii\web\Controller;

/**
 * Class MarkerClustererController
 * @package frontend\controllers
 */
class MarkerClustererController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
