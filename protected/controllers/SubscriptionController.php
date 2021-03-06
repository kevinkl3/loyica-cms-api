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
				'actions'=>array('index','view','favorites'),
				'users'=>array('*'),
                'verbs'=>array('GET')
			),
            array('allow',  // allow all users to perform 'delete' actions
				'actions'=>array('delete'),
				'users'=>array('*'),
                'verbs'=>array('DELETE')
			),
            array('allow',  // allow all users to perform 'delete' actions
				'actions'=>array('create', 'reward', 'redeem'),
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
    
    /**
    * Earn reward points
    */
    public function actionReward($id) {
        $json = file_get_contents('php://input');
        $put_vars = CJSON::decode($json,true);  //true means use associative array
        
        //todo: add check type of $_POST[POINTS]....
        if(empty($put_vars) || !isset($put_vars['POINTS']))
        {
            $this->respondJSON( "expected [POINTS, DESCRIPTION]", 400 );
        }
        
        $m = $this->loadModel($id, false);
        if($m == null) {
            $this->respondJSONCode( 404 );
        }
        
        $desc = "";
        if(isset($put_vars['DESCRIPTION']))
            $desc = $put_vars['DESCRIPTION'];
        
        $m->REWARD_POINTS = $m->REWARD_POINTS + $put_vars['POINTS'];
        $log = new RewardLog();
        $log->SUBSCRIPTION_ID = $m->SUBSCRIPTION_ID;
        $log->DESCRIPTION = $desc;
        $log->POINTS = $put_vars['POINTS'];
        $log->REWARD_DATE = Util::now();
        
        
        if($log->save() && $m->save()) {
            $this->respondJSON( array('action'=>'addreward', 'status'=>'ok', 'attributes'=>$m->attributes) );
        }
        else {
            $this->respondJSON( array('action'=>'addreward', 'status'=>'error', 'attributes'=>$m->attributes, 'subscription_errors'=>$m->errors, 'rewars_log_errors'=>$log->errors) );
        }
    }
    
    
    
    public function actionRedeem($id) {
        $json = file_get_contents('php://input');
        $put_vars = CJSON::decode($json,true);  //true means use associative array
        
        //todo: add check type of $_POST[POINTS]....
        if(empty($put_vars) || !isset($put_vars['POINTS']))
        {
            $this->respondJSON( "expected [POINTS, DESCRIPTION]", 400 );
        }
        
        $m = $this->loadModel($id, false);
        if($m == null) {
            $this->respondJSONCode( 404 );
        }
        
        if($put_vars['POINTS'] > $m->REWARD_POINTS) {
            $this->respondJSON( "Cannot redeem the number of points required, there is " . $m->REWARD_POINTS . " points available", 406 );
        }
        
        $desc = "";
        if(isset($put_vars['DESCRIPTION']))
            $desc = $put_vars['DESCRIPTION'];
        
        $m->REWARD_POINTS = $m->REWARD_POINTS - $put_vars['POINTS'];
        $log = new RewardLog();
        $log->SUBSCRIPTION_ID = $m->SUBSCRIPTION_ID;
        $log->DESCRIPTION = $desc;
        $log->POINTS = -1 * ($put_vars['POINTS']);
        $log->REWARD_DATE = Util::now();
        
        
        if($log->save() && $m->save()) {
            $this->respondJSON( array('action'=>'redeem', 'status'=>'ok', 'attributes'=>$m->attributes) );
        }
        else {
            $this->respondJSON( array('action'=>'redeem', 'status'=>'error', 'attributes'=>$m->attributes, 'subscription_errors'=>$m->errors, 'rewars_log_errors'=>$log->errors) );
        }
    }
    
    
    /*
    * Override view id
    */
    public function actionWithFavorites($id){

        $s = $this->mModel->with('favorites')->find('t.SUBSCRIPTION_ID = :sid', array(':sid'=>$id));
        
        $result = Util::model2Array( $s );
        
        foreach($result['favorites'] as &$f)
        {
            $res = array();
            switch(strtoupper($f['TYPE'])) {
                case 'PRODUCT':
                    $p = Product::model()->findByPk($f['ELEMENT_ID']);
                    if($p instanceof Product) {
                        $f['product'] = $p->attributes;
                    }
                    else {
                        $f['product'] = 'not found';
                    }
                    break;
                case 'PLACE':
                    $p = Place::model()->findByPk($f['ELEMENT_ID']);
                    if($p instanceof Product) {
                        $f['place'] = $p->attributes;
                    }
                    else {
                        $f['place'] = 'not found';
                    }
                    break;

            }
        }
        
		if($s == null){
			$this->respondJSONCode(404);
		}else{
			$this->respondJSON( $result );	
		}
	}
    
}
