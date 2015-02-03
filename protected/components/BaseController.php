<?php
class BaseController extends Controller{
	
	protected $mModel;

	function respondJSONCode($pCode){
		$msg = "Unknown Error.";
		switch($pCode){
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
	 * @return Place the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id){
		$model = $this->mModel->findByPk($id);
		if($model===null)
			return null;
		return  Util::model2Array($model);
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex(){
		$this->respondJSON( $this->all() );
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
}
?>