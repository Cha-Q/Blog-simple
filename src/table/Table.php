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

        /**
         * verifie si une valeur existe dans la table
         * @param string $field Champs à rechercher
         * @param mixed $value valeur associée aux champs
         */

        public function exists(string $field, $value, int $except = null) : bool
        {
            $sql = "SELECT count(id) FROM {$this->table} WHERE $field = ?";
            $params = [$value];
            if($except !== null){
                $sql .= " AND id != ?";
                $params[] = $except;
            }
            $query = $this->pdo->prepare($sql);
            $query->execute($params);
            return (int)$query->fetch(PDO::FETCH_NUM)[0] > 0;
        }

        public function all () : array
        {
            $sql = "SELECT * FROM {$this->table}";
            return $this->pdo->query($sql, PDO::FETCH_CLASS, $this->class)->fetchAll();

        }

        public function delete(int $id): void
        {
            $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = :id");
            $ok = $stmt->execute(['id' => $id]);
            if($ok === false){
                throw new \Exception("Impossible de supprimer l'enregistrement $id dans la table {$this->table}");
            }
        }

        public function create(array $data):int
        {
            $sqlFields = [];
            foreach($data as $k => $v){
                $sqlFields[] = "$k = :$k";
            }
            $fields = implode(',', $sqlFields);
            $query = "INSERT INTO {$this->table} SET $fields";
            $stmt = $this->pdo->prepare($query);
            $ok = $stmt->execute($data);
        
            if($ok === false){
                throw new \Exception("Impossible de créer l'article dans la table {$this->table}");
            }
            return $this->pdo->lastInsertId();
        }

        
        public function update(array $data, int $id): void
        {
            $sqlFields = [];
            foreach($data as $k => $v){
                $sqlFields[] = "$k = :$k";
            }
            $fields = implode(',', $sqlFields);
            $query = "UPDATE {$this->table} 
                        SET $fields 
                        WHERE id = :id";
            $stmt = $this->pdo->prepare($query);
            $ok = $stmt->execute(array_merge($data, ['id' => $id]));

            if($ok === false){
                throw new \Exception("Impossible de modifier l'enregistrement dans la table {$this->table}");
            }

        }

        
    }