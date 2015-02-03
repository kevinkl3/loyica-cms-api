<?php
class NotificationController extends BaseController{
	protected function beforeAction( $action){
		$this->mModel = Notification::model();
		return parent::beforeAction($action);
	}
}
?>