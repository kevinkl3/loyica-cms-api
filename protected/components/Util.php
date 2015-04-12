<?php
class Util{	
	public static function model2JSON($models){
		return json_encode(Util::model2Array($models));
	}

    
	public static function model2Array($models, array $with=null) {
        if (is_array($models))
            $arrayMode = TRUE;
        else {
            $models = array($models);
            $arrayMode = FALSE;
        }

        $result = array();
        foreach ($models as $model) {
            $attributes = $model->getAttributes();
            $relations = array();
            foreach ($model->relations() as $key => $related) {
                if ($model->hasRelated($key)) {
                    $relations[$key] = Util::model2Array($model->$key);
                }
            }
            $all = array_merge($attributes, $relations);

            if ($arrayMode)
                array_push($result, $all);
            else
                $result = $all;
        }
        return $result;
    }
    
    public static function now() {
        return date("Y-m-d H:i:s", time());
    }

}
?>