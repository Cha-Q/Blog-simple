<?php

    namespace App\table;
    use App\table\Table;
    use App\model\{Category};
    use PDO;

    final class CategoryTable extends Table {
 
        protected $table = 'category';

        protected $class = Category::class;

    
        public function hydratePosts(array $posts): void
        {
            $postsByIds = [];
            foreach($posts as $post){
                $postsByIds[$post->getId()] = $post;
            }
            
           
            $categories = $this->pdo
                ->query('SELECT c.* ,pc.post_id
                        FROM post_category pc
                        JOIN category c ON c.id = pc.category_id
                        WHERE pc.post_id IN ('. implode(',', array_keys($postsByIds)) .')')
                ->fetchAll(PDO::FETCH_CLASS, $this->class);
        
                foreach($categories as $category){
                    $postsByIds[$category->getPost_Id()]->addCategory($category);
                }
        }

        
    }