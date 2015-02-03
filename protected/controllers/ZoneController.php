<?php
class ZoneController extends BaseController{
	protected function beforeAction( $action){
		$this->mModel = Zone::model();
		return parent::beforeAction($action);
	}
}
?>