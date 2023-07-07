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

        public function set_post(Post $post)
        {
            return $this->post = $post;
        }
    }