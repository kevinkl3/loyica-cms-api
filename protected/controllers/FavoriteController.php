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
				'actions'=>array('index','view','view2'),
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
            $this->respondJSON( array('error'=>'Bad request', 'expected'=>'SUBSCRIPTION_ID or PHONE, TYPE, ELEMENT_ID'), 400 );
            Yii::app()->end();
        }
        
        $m = new $this->mModel;
        $m->attributes = $put_vars;
        
        //lookup by phone
        if(isset($put_vars['PHONE']))
        {
          $s = Subscription::model()->find('PHONE = :phone', array(':phone'=>$put_vars['PHONE']));
          if($s instanceof Subscription)
          {
            $m->SUBSCRIPTION_ID = $s->SUBSCRIPTION_ID;
          }
        }
        
        //lookup by element, check if exist
        switch(strtoupper($m->TYPE)) {
            case 'PRODUCT':
                $p = Product::model()->findByPk($m->ELEMENT_ID);
                if(!($p instanceof Product)) {
                    $this->respondJSON( 'Product not found', 400 );	
                }
                break;
            case 'PLACE':
                $p = Place::model()->findByPk($m->ELEMENT_ID);
                if(!($p instanceof Place)) {
                    $this->respondJSON( 'Place not found', 400 );	
                }
                break;
        }
        
        if($m->save())
            $this->respondJSON( array('action'=>'create', 'status'=>'ok', 'attributes'=>$m->attributes) );
        else
            $this->respondJSON( array('action'=>'create', 'status'=>'error', 'attributes'=>$m->attributes, 'errors'=>$m->errors) );    
    }
    
	public function actionView($id){
		$m = $this->loadModel($id, false);
        $res = Util::model2Array($m, array('subscription'));
        
        //agregar los demas casos Establecimientos, mensaje?
        switch(strtoupper($m->TYPE)) {
            case 'PRODUCT':
                $p = Product::model()->findByPk($m->ELEMENT_ID);
                if($p instanceof Product) {
                    $res['product'] = $p->attributes;
                }
                else {
                    $res['product'] = 'not found';
                }
                break;
            
        }
		if($m == null){
			$this->respondJSONCode(404);
		}else{
			$this->respondJSON( $res );	
		}
	}
}
    