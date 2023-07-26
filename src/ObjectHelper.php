<?php


    namespace App;
    use App\model\Post;


    class ObjectHelper{

        static function hydrate($object, array $params, ?string $slug =null)
        {

            foreach($params as $param){
                self::setValue($param, $object);
            }
            return $object;
        }

        static function setValue(string $key, $object)
        {
            if($key === 'slug'){
                $method = "set". str_replace(' ', '',ucwords(str_replace('_', ' ', $key)));
                $slug = strtolower(str_replace(" ", "-",$_POST['name']));
                return $object->$method($slug);
                
            }
            
            $method = "set". str_replace(' ', '',ucwords(str_replace('_', ' ', $key)));
            return $object->$method($_POST[$key]);
            
        }

        
    }