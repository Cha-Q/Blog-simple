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

        public function getContent(): ?string
        {
            return $this->content;
        }

        public function getFormatedContent (): ?string
        {
            return nl2br(e($this->content));
        }

        public function getExcerpt (): ?string
        {
            if($this->content === null){
                return null;
            }
            
            return nl2br(e(Text::excerpt(Text::excerpt($this->content, 60))));
        }

        public function getSlug(): ?string
        {
            return $this->slug;
        }
        public function getCreatedAt(): DateTime
        {
            return new Datetime($this->created_at);
        }

        public function setName(string $name): self
        {
            $this->name = $name;
            return $this;
        }
         public function setContent(string $content): self
        {
            $this->content = $content;
            return $this;
        }

        public function  setSlug(string $slug): self 
        {
            $this->slug = $slug;

            return $this;
        }

        public function setCreatedAt($createdAt): DateTime
        {
            $this->created_at = $createdAt;
            return new Datetime($this->created_at);
        }

        /**
         * @return Category[]
         * 
         */
        public function getCategories():array
        {
            return $this->categories;
        }

        public function addCategory(Category $category): void
        {
            $this->categories[] = $category;
            $category->set_post($this);
        }

    }