<?php
class Utils {
    public static function slug($z){
        $z = strtolower($z);
        $z = preg_replace('/[^a-z0-9 -]+/', '', $z);
        $z = str_replace(' ', '-', $z);
        return trim($z, '-');
    }
    
    public static function object_to_array($object, $response)
    {
		//if(is_object($object) || is_array($object))
        foreach( $object as $key => $value )
        {
            if( is_object($value) )
            {
                $arr = self::getPropertiesArray($value);
                
                $response[$key] = $arr;
            }
			else if(is_array($value))
			{
				$response[$key] = self::object_to_array($value, $response);
			}
            else
            {
                $response[$key] = $value;
            }
        }
        return $response;
    }
    
    public static function getPropertiesArray($object)
    {
        $class_name = get_class($object);
		$class = new ReflectionClass( $class_name );
		$parentclass = $class->getParentClass()->getName();
		
		if($class_name == 'Illuminate\Database\Eloquent\Collection' || $parentclass == 'Model')
		{
			return $object->toArray();
		}
		
        $arr = array();
		
		$properties = get_object_vars ($object);        
        foreach ($properties as $key => $property)
		{
            if( is_object($object->$key) )
            {
                $arr[$key] = self::getPropertiesArray($object->$key);
            }
            else
                $arr[$key] = $object->$key;
		}

        return $arr;
    }
}