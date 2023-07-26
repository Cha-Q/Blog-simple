<?php

    namespace App\table;
    use App\table\Table;
    use App\model\{Post, Category};
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

        public function deleteCategory(int $id): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = :id");
        $ok = $stmt->execute(['id' => $id]);
        if($ok === false){
            throw new \Exception("Impossible de supprimer l'enregistrement $id dans la table {$this->table}");
        }
    }

     
    public function updateCategory(Category $category): void
    {
        $query = "UPDATE {$this->table} 
                    SET name = :name,  
                    slug = :slug
                    WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $ok = $stmt->execute(
            ['id' => $category->getId(),
            'name' => $category->getName(),
            'slug' => $category->getSlug()
            ]
        );

        if($ok === false){
            throw new \Exception("Impossible de modifier la catégorie n° {$category->getId()} dans la table {$this->table}");
        }

    }

    public function createCategory(Category $category):void
    {
        
            $query = "INSERT INTO {$this->table} (name, slug)
            VALUES ( :name , :slug)";
            $stmt = $this->pdo->prepare($query);
            $ok = $stmt->execute(
                [
                'name' => $category->getName(),
                'slug' => $category->getSlug()
                ]
            );
        
         if($ok === false){
            throw new \Exception("Impossible de créer la catégorie dans la table {$this->table}");
        }
        $category->setId($this->pdo->lastInsertId());
    }

    }