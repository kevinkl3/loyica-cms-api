<?php

class FavoriteController extends BaseController
{
    
    protected function beforeAction( $action){
		$this->mModel = Favorite::model();
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
    
    public function actionCreate() //override
    {
        $json = file_get_contents('php://input');
        $put_vars = CJSON::decode($json,true);  //true means use associative array
        
        if(empty($put_vars))
        {
            $this->respondJSON( array('error'=>'Bad request', 'expected'=>'SUSCRIPTION_ID or PHONE, TYPE, ELEMENT_ID'), 400 );
            Yii::app()->end();
        }
        
        //TODO: lookup by phone here
        
        $m = new $this->mModel;
        $m->attributes = $put_vars;
        if($m->save())
            $this->respondJSON( array('action'=>'create', 'status'=>'ok', 'attributes'=>$m->attributes) );
        else
            $this->respondJSON( array('action'=>'create', 'status'=>'error', 'attributes'=>$m->attributes, 'errors'=>$m->errors) );    
    }
}
    