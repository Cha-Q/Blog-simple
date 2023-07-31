<?php


    namespace App\model;

    class User {

        /**
         * id de l'utilisateur
         * 
         */

        private $id;

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

        /**
         * Get the value of id
         */ 
        public function getId(): ?int
        {
                return $this->id;
        }

        /**
         * Set the value of id
         *
         * @return  self
         */ 
        public function setId($id)
        {
                $this->id = $id;

                return $this;
        }
    }

