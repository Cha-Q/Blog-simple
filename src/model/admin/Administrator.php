<?php

namespace App\model\admin;
use App\model\{Post, Category};
use PDO;

final class Administrator{

    private $pdo;


    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function updatePost(int $id, string $text)
    {
        $query = "UPDATE post SET content = $text WHERE id = $id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
    }

    public function deletePost(int $id)
    {
        $query = "DELETE post WHERE id = $id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
    }

    public function findPost(int $id, string $slug)
        {
            $query = "SELECT * FROM post WHERE id = :id";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['id' => $id]);
            $stmt->setFetchMode(PDO::FETCH_CLASS, Post::class);
        }
}