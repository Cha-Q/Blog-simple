<?php

    namespace App\table;
    use PDO;
    use App\table\Exception\NotFoundException;

    abstract class Table {

        protected $pdo;

        protected $table = null;

        protected $class = null;

        public function __construct(PDO $pdo){
            if($this->table === null){
                throw new \Exception("La classe " . get_class($this) . " n'a pas de propriété \$table");
            }
            if($this->class === null){
                throw new \Exception("La classe " . get_class($this) . " n'a pas de propriété \$class");
            }
            $this->pdo = $pdo;
        }


        public function find(int $id)
        {
            $query = "SELECT * FROM $this->table WHERE id = :id";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['id' => $id]);
            $stmt->setFetchMode(PDO::FETCH_CLASS, $this->class);
            
            $posts = $stmt->fetch();
            if($posts === false){
                throw new NotFoundException("{$this->table}", $id);
            }
            return $posts;
            
        }
    }