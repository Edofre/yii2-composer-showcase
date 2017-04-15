<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;

/**
 * Class SliderProController
 * @package frontend\controllers
 */
class SliderProController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
