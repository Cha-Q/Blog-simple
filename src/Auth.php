<?php

    namespace App;

    use App\security\ForbiddenException;

    class Auth{

        public static function check()
        {
            if(session_status() <= 1){
                session_start();
            }
            if(!isset($_SESSION['auth'])){
                throw new ForbiddenException('vilain');
            }
            // TODO : écrire la funcion
        }
        


    }