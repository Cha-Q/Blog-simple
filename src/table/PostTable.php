<?php

    namespace App\table;
    use App\table\Table;
    use App\PaginatedQuery;
    use App\model\{Post, Category};
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

     
    public function updatePost(Post $post): void
    {
        $query = "UPDATE {$this->table} 
                    SET name = :name, 
                    content = :content,
                    slug = :slug,
                    created_at = :created_at 
                    WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $ok = $stmt->execute(
            ['id' => $post->getId(),
            'name' => $post->getName(),
            'content' => $post->getContent(),
            'slug' => $post->getSlug(),
            'created_at' => $post->getCreatedAt()->format('Y-m-d H:i:s')]
        );

        if($ok === false){
            throw new \Exception("Impossible de modifier l'article n° {$post->getId()} dans la table {$this->table}");
        }

    }

    public function createPost(Post $post):void
    {
        
            $query = "INSERT INTO {$this->table} (name, slug, content, created_at)
            VALUES (:name,
            :slug,
            :content,
            :created_at)";
            $stmt = $this->pdo->prepare($query);
            $ok = $stmt->execute(
                [
                'name' => $post->getName(),
                'slug' => $post->getSlug(),
                'content' => $post->getContent(),
                'created_at' => $post->getCreatedAt()->format('Y-m-d')
                ]
            );
        
         if($ok === false){
            throw new \Exception("Impossible de créer l'article dans la table {$this->table}");
        }
        $post->setId($this->pdo->lastInsertId());
    }

        
}