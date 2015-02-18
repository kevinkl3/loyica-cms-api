<?php

class SubscriptionController extends BaseController
{
    
    protected function beforeAction( $action){
		$this->mModel = Subscription::model();
		return parent::beforeAction($action);
	}
    
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
                'verbs'=>array('GET')
			),
            array('allow',  // allow all users to perform 'delete' actions
				'actions'=>array('delete'),
				'users'=>array('*'),
                'verbs'=>array('DELETE')
			),
            array('allow',  // allow all users to perform 'delete' actions
				'actions'=>array('create'),
				'users'=>array('*'),
                'verbs'=>array('POST')
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('update'),
				'users'=>array('*'),
                'verbs'=>array('PUT')
			),
		);
	}
}
