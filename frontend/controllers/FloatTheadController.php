<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;

/**
 * Class FloatTheadController
 * @package frontend\controllers
 */
class FloatTheadController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
