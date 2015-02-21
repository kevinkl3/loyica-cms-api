<?php
class RewardLogController extends BaseController{
	protected function beforeAction( $action){
		$this->mModel = RewardLog::model();
		return parent::beforeAction($action);
	}
}
?>