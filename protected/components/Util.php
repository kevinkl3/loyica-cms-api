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
            
            
            if(!empty($with)) {
                foreach ($with as $key) {
                    if (isset($model->$key)) {
                        $attributes[$key] = $model->$key->attributes;
                    }
                }
            }
            
            /* discutir con Kevin, la posible recursividad que resultaria de esto, esta fallando "hasRelated"?
            $relations = array();
            foreach ($model->relations() as $key => $related) {
                if ($model->hasRelated($key)) {
                    $relations[$key] = convertModelToArray($model->$key);
                }
            }
            $all = array_merge($attributes, $relations);
            
            if ($arrayMode)
                array_push($result, $all);
            else
                $result = $all;
            */
            
            if ($arrayMode)
                array_push($result, $attributes);
            else
                $result = $attributes;
        }
        return $result;
    }
}
?>