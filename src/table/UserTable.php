<?php


    namespace App\table;
    use PDO;
    use App\table\Exception\NotFoundException;
    use App\model\User;

    class UserTable extends Table {

    protected $table = 'user';

    protected $class = User::class;
    
        public function findByUsername(string $username)
        {
            $query = "SELECT * FROM $this->table WHERE username = :username";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['username' => $username]);
            $stmt->setFetchMode(PDO::FETCH_CLASS, $this->class);
            
            $result = $stmt->fetch();
            if($result === false){
                throw new NotFoundException("{$this->table}", $username);
            }
            return $result;
        }

        
        

        
}