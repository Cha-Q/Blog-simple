<?php


    namespace App\security;
    use Exception;

    class ForbiddenException extends Exception{
        // possibilité de récupérer l'url pour rediriger plus tard l'utilisateur lors de sa connection

    }