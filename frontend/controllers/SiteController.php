<?php
namespace frontend\controllers;

use common\models\LoginForm;
use edofre\fullcalendar\models\Event;
use frontend\models\ContactForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use Yii;
use yii\base\InvalidParamException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public function beforeAction($action)
    {
        if ($action->id == 'return') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

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
        return $this->render('index');
    }

    public function actionSlider()
    {
        return $this->render('slider');
    }

    public function actionClusterer()
    {
        return $this->render('clusterer');
    }

    public function actionAmigo()
    {
        return $this->render('amigo');
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

    /**
     * @return string
     */
    public function actionCkeditor()
    {
        return $this->render('ckeditor');
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

    public function actionFloatThead()
    {
        return $this->render('float-thead');
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

    public function actionJson()
    {
        ini_set('memory_limit', '-1');
        $file = '/Applications/MAMP/htdocs/composer_testing/frontend/web/giel.json';
        $decode = Json::decode(file_get_contents($file));
        var_dump($decode);
        exit;
    }

    public function actionSima()
    {
        $file = '/Applications/MAMP/htdocs/testing/frontend/web/testing.csv';

        $reader = PHPExcel_IOFactory::createReader('CSV');
        $reader->setDelimiter(';');
        $php_excel = $reader->load($file);

        // Use the worksheet to get the count of items
        $worksheet = $php_excel->getSheet(0);
        $highestRow = $worksheet->getHighestRow();
        $highestColumn = $worksheet->getHighestColumn();

        // Prepare the map with the required attributes
        $map = [
            //			'company' => 0,
            '2004' => 3,
            '2005' => 4,
            '2006' => 5,
            '2007' => 6,
            '2008' => 7,
            '2009' => 8,
            '2010' => 9,
            '2011' => 10,
            '2012' => 11,
        ];

        $create_map = [
            'NET PROFIT(INCOME)'         => 'C',
            'PRICE INDEX'                => 'D',
            'TOT RETURN IND'             => 'E',
            'TOTAL ASSETS'               => 'F',
            'Net Employment Creation'    => 'G',
            'Salaries'                   => 'H',
            'Salaries Distribution'      => 'I',
            'Salary Gap'                 => 'J',
            'Trade Union Representation' => 'K',
        ];

        // Create CSV
        $objPHPExcel = new PhpExcel();
        $new_worksheet = $objPHPExcel->getSheet();

        // Title
        $new_worksheet->setCellValue('A1', 'Company');
        foreach ($create_map as $key => $test) {
            $new_worksheet->setCellValue($test . '1', $key);
        }

        $companies = [];
        $company_row = 2;

        for ($row = 3; $row <= $highestRow; $row++) { // $row = 2 because we ignore the first row

            //  Read a row of data into an array
            $csv_row = $worksheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, null, true, false);
            $csv_row = reset($csv_row);

            $company_name = $this->getCompany($csv_row[0]);
            $variable = $this->getVariable($csv_row[0]);

            if (!in_array($company_name, $companies)) {
                $range['start'] = $company_row;
                // Add the company_name and years
                foreach ($map as $key => $map_row) {
                    $new_worksheet->setCellValue('A' . $company_row, $company_name);
                    $new_worksheet->setCellValue('B' . $company_row, $key);
                    $company_row++;
                }
                $companies[] = $company_name;
                $range['end'] = $company_row - 1;
            }

            $year_range = 3;
            foreach (range($range['start'], $range['end']) as $ranging) {
                $new_worksheet->setCellValue($create_map[$variable] . $ranging, $csv_row[$year_range]);
                $year_range++;
            }
            //			var_dump($csv_row);
            //			var_dump($variable);


            //			if ($row == 11) {
            //				exit;
            //				break;
            //			}
        }

        // Send to browser as a download
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="sima.xls"');
        $objWriter->save('php://output');
    }

    /**
     *
     */
    private function getCompany($string)
    {
        $arr = explode("-", $string, 2);
        return trim($arr[0]);
    }

    /**
     *
     */
    private function getVariable($string)
    {
        return trim(substr($string, strrpos($string, '-') + 1));
    }

    public function actionCalendar()
    {
        return $this->render('calendar');
    }

    public function actionSchedulerGit()
    {
        return $this->render('scheduler-git');
    }

    public function actionScheduler()
    {
        return $this->render('scheduler');
    }

    public function actionSchedulerTest()
    {
        return $this->render('scheduler-test');
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

    public function actionCalendarTest()
    {
        $events = [
            // minimum
            new Event([
                'id'    => uniqid(),
                'title' => 'Appointment #' . rand(1, 999),
                'start' => '2017-04-03 14:00:00',
            ]),
            // Everything editable
            new Event([
                'id'    => uniqid(),
                'title' => 'Appointment #' . rand(1, 999),
                'start' => '2017-04-03 14:30:00',
                'end'   => '2017-04-03 15:00:00',
            ]),
            // No overlap
            new Event([
                'id'    => uniqid(),
                'title' => 'Appointment #' . rand(1, 999),
                'start' => '2017-04-03 15:30:00',
                'end'   => '2017-04-03 19:30:00',
            ]),
            // Only duration editable
            new Event([
                'id'    => uniqid(),
                'title' => 'Appointment #' . rand(1, 999),
                'start' => '2017-04-04 11:00:00',
                'end'   => '2017-04-04 11:30:00',
            ]),
            // Only start editable
            new Event([
                'id'    => uniqid(),
                'title' => 'Appointment #' . rand(1, 999),
                'start' => '2017-04-05 14:00:00',
                'end'   => '2017-04-05 15:30:00',
            ]),
        ];

        $tasks = [];
        $draggable = "fc-draggable fc-resizable";
        foreach ($events as $eve) {
            $event = new \edofre\fullcalendar\models\Event();
            $event->id = $eve->id;
            $event->start = $eve->start;
            $event->end = $eve->end;
            $event->title = $eve->title;
            //$event->description = $house;
            $event->className = $draggable;
            $event->editable = true;
            $event->startEditable = true;
            $event->durationEditable = true;
            $event->backgroundColor = $eve->backgroundColor;
            $tasks[] = $event;
        }

        return $this->render('calendartest', [
            'events' => $tasks,
        ]);
    }

}
