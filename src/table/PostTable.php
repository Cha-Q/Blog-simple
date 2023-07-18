<?php

    namespace App\table;
    use App\table\Table;
    use App\PaginatedQuery;
    use App\model\{Post, Category};
    use App\table\Exception\NotFoundException;
    use PDO;

    final class PostTable extends Table {

    protected $table = 'post';

    protected $class = Post::class;

    public function findPaginated(): ?array
    {
        $paginatedQuery = new PaginatedQuery(
            "SELECT * FROM post ORDER BY created_at DESC",
            "SELECT COUNT(id) FROM post",
            $this->pdo
        );

        $posts = $paginatedQuery->getItems($this->class);
    
        (new CategoryTable($this->pdo))->hydratePosts($posts);
        return [$posts, $paginatedQuery];
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

    public function deletePost(int $id): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = :id");
        $ok = $stmt->execute(['id' => $id]);
        if($ok === false){
            throw new \Exception("Impossible de supprimer l'enregistrement $id dans la table {$this->table}");
        }
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
    public function updatePost(Post $post): void
    {
        $query = "UPDATE {$this->table} 
                    SET name = :name, 
                    content = :content,
                    slug = :slug 
                    WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $ok = $stmt->execute(
            ['id' => $post->getId(),
            'name' => $post->getName(),
            'content' => $post->getContent(),
            'slug' => $post->getSlug()]
        );

        if($ok === false){
            throw new \Exception("Impossible de modifier l'article n° {$post->getId()} dans la table {$this->table}");
        }

    }

        
}