<?php
namespace frontend\controllers;

use common\models\LoginForm;
use frontend\models\ContactForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use Yii;
use yii\base\InvalidParamException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

/**
 * Omnikassa controller
 */
class OmnikassaController extends Controller
{
    /**
     * @param \yii\base\Action $action
     * @return bool
     */
    public function beforeAction($action)
    {
        if ($action->id == 'return') { // We need to disable the CSRF protection when we return from omnikassa
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     *
     */
    public function actionReturn()
    {
        $response = Yii::$app->omniKassa->processRequest();

        var_dump($response->attributes);
        var_dump('Pending', $response->isPending);
        var_dump('Successful', $response->isSuccessful);
        var_dump('Failure', $response->isFailure);
        exit;
    }
}
