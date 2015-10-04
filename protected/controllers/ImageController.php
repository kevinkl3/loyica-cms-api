<?php

class ImageController extends Controller{



	public function actionView($name){
		error_reporting(-1);
		ini_set('display_errors', 'On');

		$BASE_PATH = Yii::getpathOfAlias('webroot') . '/media/img/';

		$width = isset($_GET['w']) ? $_GET['w'] : 128;
		$height = isset($_GET['h']) ? $_GET['w'] : 128;
		
		//echo "<img src=\"" . $BASE_PATH . $name . "\" />";

		try{
			$file = Yii::app()->easyImage->thumbSrcOf( $BASE_PATH . $name,
			  array('resize' => array('width' => $width, 'height' => $height),)
			);
			header('Location: ' . $file);
			die();
			return;
		}catch(Exception $e){
			header('Content-Type:text/html');
			print_r($e);
		}
	}
}