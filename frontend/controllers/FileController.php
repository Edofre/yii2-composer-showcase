<?php
namespace frontend\controllers;

use frontend\models\FileForm;
use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;

class FileController extends Controller
{

	/**
	 * Displays homepage.
	 *
	 * @return mixed
	 */
	public function actionIndex()
	{
		$model = new FileForm();

		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			echo __FUNCTION__;
			$files = UploadedFile::getInstances($model, 'file');
			var_dump($files);
			exit;
		}

		return $this->render('index', [
			'model' => $model,
		]);
	}

	public function actionUpload()
	{
		$model = new FileForm();
		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
//			echo __FUNCTION__;
			$files = UploadedFile::getInstances($model, 'file');
//			var_dump($files);
//			exit;
		}

		return true;
	}

}
