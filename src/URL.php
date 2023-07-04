<?php


namespace App;
use Exception;

class URL {


    public static function getInt(string $name, int $default = null) : ?int{
        if(!isset($_GET[$name])) return $default;
        if($_GET[$name] === '0') return 0;

        if(!filter_var($_GET[$name], FILTER_VALIDATE_INT)){
            throw new Exception("le paramètre $name n'est pas un entier dans l'URL");
        }

        return (int)$_GET[$name];
    } 

    public static function getPositiveInt(string $name, int $default = null) : ?int{

        $param = self::getInt($name, $default);
        
        if($param !== null && $param <= 0){
            return throw new Exception('Numéro de page invalide');
        } 

        return $param;
    } 
}