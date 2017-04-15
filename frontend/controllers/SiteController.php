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
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow'   => true,
                        'roles'   => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error'   => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class'           => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     * @return mixed
     */
    public function actionIndex()
    {
        $packages = [
            [
                'name'     => 'yii2-fullcalendar',
                'link'     => '/fullcalendar',
                'github'   => 'https://github.com/Edofre/yii2-fullcalendar',
                'composer' => 'https://packagist.org/packages/edofre/yii2-fullcalendar',
                'version'  => 'V1.0.8',
            ],
            [
                'name'     => 'yii2-fullcalendar-scheduler',
                'link'     => '/fullcalendar-scheduler',
                'github'   => 'https://github.com/Edofre/yii2-fullcalendar-scheduler',
                'composer' => 'https://packagist.org/packages/edofre/yii2-fullcalendar-scheduler',
                'version'  => 'V1.1.9',
            ],
            [
                'name'     => 'yii2-omnikassa',
                'link'     => '/omnikassa',
                'github'   => 'https://github.com/Edofre/yii2-omnikassa',
                'composer' => 'https://packagist.org/packages/edofre/yii2-omnikassa',
                'version'  => 'V1.0.5',
            ],
            [
                'name'     => 'yii2-ckeditor',
                'link'     => '/ckeditor',
                'github'   => 'https://github.com/Edofre/yii2-ckeditor',
                'composer' => 'https://packagist.org/packages/edofre/yii2-ckeditor',
                'version'  => 'V1.0.1',
            ],
            [
                'name'     => 'yii2-float-thead',
                'link'     => '/float-thead',
                'github'   => 'https://github.com/Edofre/yii2-float-thead',
                'composer' => 'https://packagist.org/packages/edofre/yii2-float-thead',
                'version'  => 'V1.0.2',
            ],
            [
                'name'     => 'yii2-slider-pro',
                'link'     => '/slider-pro',
                'github'   => 'https://github.com/Edofre/yii2-slider-pro',
                'composer' => 'https://packagist.org/packages/edofre/yii2-slider-pro',
                'version'  => 'V1.1.6',
            ],
        ];

        return $this->render('index', ['packages' => $packages]);
    }

    /**
     * Logs in a user.
     * @return mixed
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
