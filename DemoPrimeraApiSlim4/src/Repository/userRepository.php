<?php

declare(strict_types=1);

namespace App\Repository;

/* Estos no harian falta porque no estamos usando sus tablas
    use App\Entity\Plan;
    use App\Exception\PlanException;
    use App\roles\Roles;
    use Couchbase\Role;
*/

use App\Exception\UserException;
use function PHPUnit\Framework\assertGreaterThanOrEqual;
use function PHPUnit\Framework\throwException;

final class userRepository
{
    private \PDO $database;

    public function __construct(\PDO $database)
    {
        $this->database = $database;
    }

    public function getDb(): \PDO
    {
        return $this->database;
    }

    public function getOneUser(int $id) : object{

        $query = 'SELECT * FROM usuarios WHERE idUsuario = :id';
        
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id',$id );
        $statement->execute();
        $user = $statement->fetchObject();
        
            if (!$user){
                throw new UserException("NOT FOUND",404);
            }
            return $user;
    }

    public function getAllUsers() : array{

        $query = 'SELECT * FROM usuarios';
        
        $statement = $this->getDb()->prepare($query);
        $statement->execute();
        $user = $statement->fetchAll();
        
            if (!$user){
                throw new UserException("NOT FOUND",404);
            }
            return $user;
    }

    public function createUser(object $newUser): object{

        $query = "INSERT INTO usuarios (nombre, apellidos, correo, password) 
                    VALUES (:nombre,:apellidos,:correo,:password)";
        
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('nombre',$newUser->nombre);
        $statement->bindParam('apellidos',$newUser->apellidos);
        $statement->bindParam('correo',$newUser->correo);
        $statement->bindParam('password',$newUser->password);
        $statement->execute();

        return ($this->getOneUser((int) $this->getDb()->lastInsertId()));
    }
    
    // Verificamos el email que no exista
    public function validateEmail(string $email){
        $query = "SELECT * FROM usuarios WHERE correo = :email";

        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('email', $email);
        $statement->execute();

        return $statement->rowCount();
    }

    public function update(object $data, int $id): object{

        $query = "UPDATE usuarios SET 
                    nombre = :nombre,
                    apellidos = :apellidos,
                    correo = :correo,
                    password = :password
                WHERE idUsuario = :id";
        
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id',$id);
        $statement->bindParam('nombre',$data->nombre);
        $statement->bindParam('apellidos',$data->apellidos);
        $statement->bindParam('correo',$data->correo);
        $statement->bindParam('password',$data->password);
        $statement->execute();

        return ($this->getOneUser((int) $id));
    }
    
    public function delete(int $id): void{

        $query = "DELETE FROM usuarios WHERE idUsuario = :id";
        
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id',$id);
        $statement->execute();

    }
    

}