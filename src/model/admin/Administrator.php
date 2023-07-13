<?php

namespace App\model\admin;
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
}