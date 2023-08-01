<?php

    namespace App\model;

    class Category {

        private $id;

        private $name;

        private $slug;

        private $post_id;

        private $post;

        public function getId () : ?int
        {
            return $this->id;
        }

        public function getName () : ?string
        {
            return $this->name;
        }

        public function getSlug () : ?string
        {
            return $this->slug;
        }

        public function getPost_Id () : ?int
        {
            return $this->post_id;
        }

        public function setId (int $id) : self
        {
            $this->id = $id;
            return $this;
        }

        public function setName (string $name) : self
        {
            $this->name = $name;
            return $this;
        }

        public function setSlug (string $slug) :  self
        {
            $this->slug = $slug;
            return $this;
        }

        public function set_post(Post $post)
        {
            return $this->post = $post;
        }
    }