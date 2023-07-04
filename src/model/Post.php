<?php

    namespace App\model;
    use App\helpers\Text;
    use DateTime;

    class Post{
        private $id;

        private $name;
        
        private $content;

        private $slug;

        private $created_at;

        private $categories = [];

        public function getId (): ?int
        {
            return $this->id;
        }
        public function getName (): ?string
        {
            return $this->name;
        }

        public function getExcerpt (): ?string
        {
            if($this->content === null){
                return null;
            }
            
            return nl2br(htmlentities(Text::excerpt(Text::excerpt($this->content, 60))));
        }

        public function getSlug(): ?string
        {
            return $this->slug;
        }
        public function getCreated_At(): DateTime
        {
            return new Datetime($this->created_at);
        }

    }