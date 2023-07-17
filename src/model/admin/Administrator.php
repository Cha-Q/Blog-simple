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

    public function updatePost(int $id, string $name = null, string $text = null): void
    {
        $query = "UPDATE post SET name = $name, content = $text WHERE id = $id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
    }

   
}