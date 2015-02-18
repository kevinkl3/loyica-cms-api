<?php
class BaseController extends Controller{
	
	protected $mModel;
	protected $filternames = array('per','page','pluck');
	protected $filterdefaults = array('per'=>10,'page'=>1);

	function respondJSONCode($pCode){
		$msg = "Unknown Error.";
		switch($pCode){
			case 400: $msg = "Bad request";break;
			case 404: $msg = "The requested element was not found.";break;
			case 200: $msg = "Ok.";break;
		}
		$this->respondJSON($msg,$pCode);
	}

	function respondJSON($responseValue="ok",$code=200){
        header('Content-type: application/json');
        header("Access-Control-Allow-Origin: *");
        echo json_encode( array('code'=>$code,'value'=>$responseValue) );
    }

    function all(){
    	return Util::model2Array( $this->mModel->findAll() );
    }

    /**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
     * Kevin: discutir si hace falta siempre convertirlo a array, para cuando son GET esta bien, pero cuando necesito manipularlo para update o delete no tanto?
	 */
	public function loadModel($id, $toArray=true){
		$model = $this->mModel->findByPk($id);
        if($toArray) 
        {
            if($model===null)
                return null;
            return  Util::model2Array($model);
        }
        else
            return $model;
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex(){
		$this->respondJSON( $this->filter() );
	}

	/**
	*View a single element
	*/
	public function actionView($id){
		$m = $this->loadModel($id);
        
		if($m == null){
			$this->respondJSONCode(404);
		}else{
			$this->respondJSON( $m );	
		}
	}
    
    /**
    *Delete element by id
    */
    public function actionDelete($id){
        $m = $this->loadModel($id, false);
        if($m == null){
			$this->respondJSONCode(404);
		}else{
            if($m->delete())
			    $this->respondJSON( );
            else
                $this->respondJSON( array('action'=>'delete', 'status'=>'error', 'errors'=>$m->errors) );	
		}
    }
    
    /**
    *Create element by raw json
    *TODO: determinar si hace falta retornar los atributos, al menos el ID de la insersion ese si
    */
    public function actionCreate(){
        $json = file_get_contents('php://input');
        $put_vars = CJSON::decode($json,true);  //true means use associative array
        
        if(empty($put_vars))
        {
            $this->respondJSON( array('error'=>'Bad request', 'expected'=>json_encode($this->mModel->attributeNames())), 400 );
            Yii::app()->end();
        }
        
        $m = new $this->mModel;
        $m->attributes = $put_vars;
        
        if($m->save())
            $this->respondJSON( array('action'=>'create', 'status'=>'ok', 'attributes'=>$m->attributes) );
        else
            $this->respondJSON( array('action'=>'create', 'status'=>'error', 'attributes'=>$m->attributes, 'errors'=>$m->errors) );    
    }
    
    /**
    *Update element by raw json
    *TODO: determinar si hace falta retornar los atributos, al menos el ID de la insersion ese si
    */
    public function actionUpdate($id){
        $json = file_get_contents('php://input');
        $put_vars = CJSON::decode($json,true);  //true means use associative array
        
        if(empty($put_vars))
        {
            $this->respondJSONCode( 400 );
            Yii::app()->end();
        }
        
        $m = $this->loadModel($id, false);
        if($m == null) {
            $this->respondJSONCode( 404 );
            Yii::app()->end();
        }
        
        $m->attributes = $put_vars;
        if($m->save())
            $this->respondJSON( array('action'=>'update', 'status'=>'ok', 'attributes'=>$m->attributes) );
        else
            $this->respondJSON( array('action'=>'update', 'status'=>'error', 'attributes'=>$m->attributes, 'errors'=>$m->errors) );    
    }
    
    /**
    * Get model Labels
    */
    public function actionLabels()
    {
        $this->respondJSON($this->mModel->attributeLabels());
    }
    
    

	public function applyFilter($pDBCriteria,$pFilter){
		switch($pFilter['f']){
			case 'per':{
				if(intval($pFilter['v']) > 0){
					$pDBCriteria->limit = $pFilter['v'];
				}
				break;
			}
			case 'page':{
				if(intval($pFilter['v']) > 0){
					if($pDBCriteria->limit < 0){
						$pDBCriteria->limit = $this->filterdefaults['per'];
					}
					$pDBCriteria->offset = $pDBCriteria->limit * (intval($pFilter['v'])-1);
				}
				break;
			}
		}
	}


	public function filter(){
		$fs = $this->getFilters();
		$criteria = new CDbCriteria();
		$criteria->limit = -1;
		
		//Apply Filters like pagination
		foreach($fs as $f){
			$this->applyFilter($criteria,$f);
		}

		//Conditions based on the Model Attributes
		$attrs = $this->getConditions();
		$params = array();
		$pfx = ":p";
		$pc = 0;
		foreach ($attrs as $key => $value) {
			$pid = $pfx . $pc;
			$criteria->addCondition( $key . " = " . $pid );
			$params[$pid] = $value;
		}
		$criteria->params = $params;

		return  Util::model2Array( $this->mModel->findAll($criteria) );
	}

	/**
	* 	Get conditions based on the request values and the Model attributes
	*/
	public function getConditions(){
		$attrs = array();
		if(count($_GET) == 0)return $attrs;

		$cc = 0;//condition counter
		foreach ($this->mModel->attributes as $key => $value) {
			$k = strtolower($key);
			if(isset($_GET[$k])){
				$cc++;
				$attrs[$key] = $_GET[$k];
			}
			if($cc >= count($_GET))
				break;
		}
		return $attrs;
	}

	/**
	*	Get Request Filters
	*/
	public function getFilters(){
		$fltrs = array();
		if(count($_GET) == 0)return $fltrs;
		
		foreach ($this->filternames as $f) {
			if(isset($_GET[$f]) ){
				array_push($fltrs,array('f'=>$f,'v'=>$_GET[$f]));
			}
		}
		return $fltrs;
	}
}
?>