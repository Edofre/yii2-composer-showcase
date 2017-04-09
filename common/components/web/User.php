<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace common\components\web;

use Yii;

class User extends \yii\web\User
{
	/**
	 * This method is called after the user is successfully logged in.
	 * The default implementation will trigger the [[EVENT_AFTER_LOGIN]] event.
	 * If you override this method, make sure you call the parent implementation
	 * so that the event is triggered.
	 * @param \yii\web\IdentityInterface $identity the user identity information
	 * @param boolean $cookieBased whether the login is cookie-based
	 * @param integer $duration number of seconds that the user can remain in logged-in status.
	 * If 0, it means login till the user closes the browser or the session is manually destroyed.
	 */
	protected function afterLogin($identity, $cookieBased, $duration)
	{
		parent::afterLogin($identity, $cookieBased, $duration);

		$this->identity->last_login = time();
		$this->identity->save();
	}

	/**
	 * @return null|\yii\rbac\Assignment
	 */
	public function isAdmin()
	{
		return !is_null(Yii::$app->authManager->getAssignment('admin', $this->id));
	}

	/**
	 * @return int|string
	 */
	public function getId()
	{
		if (php_sapi_name() == "cli") {
			// In cli-mode so the user is the Admin
			return 1;
		}
		return parent::getId();
	}
}
