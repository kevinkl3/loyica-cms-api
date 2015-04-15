<?php
class ServicesController extends BaseController{
	protected function beforeAction( $action){
		$this->mModel = Service::model();
		return parent::beforeAction($action);
	}
}
?>