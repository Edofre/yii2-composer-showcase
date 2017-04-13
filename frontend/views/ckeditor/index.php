<?php

/* @var $this yii\web\View */

$this->title = 'CKEditor';

$model = new \frontend\models\ContactForm()
?>
<div class="site-ckeditor">
    <div class="body-content">
        <?php $form = \yii\widgets\ActiveForm::begin(); ?>
        <?= $form->field($model, 'body')->widget(\edofre\ckeditor\CKEditor::className(), [
            'editorOptions' => [
                'language' => 'nl',
            ],
        ]) ?>
        <?= \yii\helpers\Html::submitButton('Submit'); ?>
        <?php \yii\widgets\ActiveForm::end(); ?>

        <br/>

        <?= \edofre\ckeditor\CKEditor::widget([
            'name'          => 'content',
            'editorOptions' => [
                'height' => '400px',
            ],
        ]) ?>
    </div>
</div>
