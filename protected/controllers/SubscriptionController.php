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
				'actions'=>array('create', 'reward'),
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
    
    public function actionReward($id) //earn reward
    {
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
}
