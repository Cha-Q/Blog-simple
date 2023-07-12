<?php

    namespace App\table\Exception;

    class NotFoundException extends \Exception{
        public function __construct(string $table, string $id)
        {
            $this->message = "Aucun enregistrement ne correspond à l'id #$id dans la table '$table' .";
        }
    }