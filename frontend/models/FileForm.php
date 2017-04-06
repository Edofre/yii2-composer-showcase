<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

class FileForm extends Model
{
	public $file;

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
//			[['file'], 'required'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'file' => 'Bestanden',
		];
	}

}
