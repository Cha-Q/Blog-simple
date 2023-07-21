<?php


    namespace App;
    use App\model\Post;


    class Rdm{

    


        static function hydrate(Post $post, array $params, ?string $slug =null)
        {

            foreach($params as $param){
                self::setValue($param, $post);
            }
            return $post;
        }

        static function setValue(string $key, $post)
        {
            if($key === 'slug'){
                $method = "set". str_replace(' ', '',ucwords(str_replace('_', ' ', $key)));
                $slug = strtolower(str_replace(" ", "-",$_POST['name']));
                return $post->$method($slug);
                
            }
            
            $method = "set". str_replace(' ', '',ucwords(str_replace('_', ' ', $key)));
            return $post->$method($_POST[$key]);
            
        }

        
    }