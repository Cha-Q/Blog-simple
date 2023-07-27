<?php

    namespace App\table;
    use App\table\Table;
    use App\PaginatedQuery;
    use App\model\{Post};
    use PDO;

    final class PostTable extends Table {

    protected $table = 'post';

    protected $class = Post::class;
    
        public function findPaginated(): ?array
        {
            $paginatedQuery = new PaginatedQuery(
                "SELECT * FROM {$this->table} ORDER BY created_at DESC",
                "SELECT COUNT(id) FROM {$this->table}",
                $this->pdo
            );

            $items = $paginatedQuery->getItems($this->class);
        
            (new CategoryTable($this->pdo))->hydratePosts($items);
            return [$items, $paginatedQuery];
        }

        public function findPaginatedForCategory(int $categoryId)
        {
            $paginatedQuery = new PaginatedQuery(
                "SELECT p.id, p.slug, p.name, p.content, p.created_at
                FROM post_category pc
                JOIN post p ON pc.post_id = p.id
                WHERE pc.category_id = {$categoryId}
                ORDER BY p.created_at DESC",
                "SELECT COUNT(category_id) 
                FROM post_category 
                WHERE category_id = {$categoryId}"
            );
            
            /** @var Post[] */
            $posts = $paginatedQuery->getItems($this->class);
            (new CategoryTable($this->pdo))->hydratePosts($posts);
            return [$posts, $paginatedQuery];
            
        }
        public function findPost(int $id): ?Post
        {
            $query = "SELECT * FROM {$this->table} WHERE id = :id";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['id' => $id]);
            $stmt->setFetchMode(PDO::FETCH_CLASS, $this->class);
            $post = $stmt->fetch();
            return $post;
        }

        public function deletePost(int $id): void
        {
            $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = :id");
            $ok = $stmt->execute(['id' => $id]);
            if($ok === false){
                throw new \Exception("Impossible de supprimer l'enregistrement $id dans la table {$this->table}");
            }
        }

        
        public function updatePost(Post $post, ?array $categories = null): void
        {
            $this->pdo->beginTransaction();
            $this->update(
                ['id' => $post->getId(),
                'name' => $post->getName(),
                'content' => $post->getContent(),
                'slug' => $post->getSlug(),
                'created_at' => $post->getCreatedAt()->format('Y-m-d H:i:s')], $post->getId()
            );


            $this->pdo->exec('DELETE FROM post_category WHERE post_id = ' . $post->getId());
             
            $query = $this->pdo->prepare('INSERT INTO post_category SET post_id = :post_id, category_id = :category_id');
            if($categories != null){
                foreach($categories as $category){
                    $query->execute([
                        'post_id' => $post->getId(),
                        'category_id' => $category
                    ]);
                }
            }
            $this->pdo->commit();
        }

        public function createPost(Post $post, ?array $categories = null):void
        {
            $this->pdo->beginTransaction();
            $id = $this->create(
            [
            'name' => $post->getName(),
            'slug' => $post->getSlug(),
            'content' => $post->getContent(),
            'created_at' => $post->getCreatedAt()->format('Y-m-d')
            ]);
    
            $post->setId($id);

            if($categories != null){
                    $query = $this->pdo->prepare('INSERT INTO post_category SET post_id = :post_id, category_id = :category_id');
                    foreach($categories as $category){
                        $query->execute([
                            'post_id' => $post->getId(),
                            'category_id' => $category
                    ]);
                }
            }
            
            $this->pdo->commit();
        }

        
}