<?php
class ProductController extends BaseController{
	protected function beforeAction( $action){
		$this->mModel = Product::model();
		return parent::beforeAction($action);
	}
}
?>