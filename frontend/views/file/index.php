<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\FileForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\Url;

$this->title = 'Fileupload';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
	<h1><?= Html::encode($this->title) ?></h1>

	<div class="row">
		<div class="col-lg-5">
			<?php $form = ActiveForm::begin([
				'id'      => 'upload-form',
				'options' => [
					'enctype' => 'multipart/form-data'
				],
			]); ?>

			<?= $form->field($model, 'file[]')->widget(FileInput::classname(), [
				'options'       => [
					'accept'   => 'image/*',
					'multiple' => true,
				],
				'pluginOptions' => [
					'uploadUrl'    => Url::to(['/file/upload']),
					'maxFileCount' => 10
				]
			]);
			?>

			<?php ActiveForm::end(); ?>
		</div>
	</div>

</div>
