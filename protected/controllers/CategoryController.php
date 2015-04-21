<?php
class CategoryController extends BaseController{
	protected function beforeAction( $action){
		$this->mModel = Category::model();
		return parent::beforeAction($action);
	}
}
?>