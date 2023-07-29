<?php


    namespace App\model;

    class User {

        /**
         * Nom de l'utilisateur
         * 
         */
        private $username;

        /**
         * Mot de passe de l'utilisateur
         * 
         */
        private $password;

        /**
         * Get nom de l'utilisateur

         */ 
        public function getUsername(): ?string
        {
                return $this->username;
        }

        /**
         * Set nom de l'utilisateur
      
         */ 
        public function setUsername(string $username): self
        {
                $this->username = $username;

                return $this;
        }

        /**
         * Get mot de passe de l'utilisateur
         *
         */ 
        public function getPassword(): ?string
        {
                return $this->password;
        }

        /**
         * Set mot de passe de l'utilisateur
         *
         */ 
        public function setPassword(string $password): self
        {
                $this->password = $password;

                return $this;
        }
    }