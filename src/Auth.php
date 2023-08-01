<?php

    namespace App;

    use App\security\ForbiddenException;
    use App\Router;

    class Auth{

        public static function check()
        {
            if(session_status() <= 1){
                session_start();
            }
            if(!isset($_SESSION['auth'])){
                throw new ForbiddenException('vilain');
            }
        }
        
        public static function logged()
        {
            if(isset($_SESSION['auth'])){
                return 'connecté';
            }
        }



    }