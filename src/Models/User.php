<?php

namespace App\Models;

use App\Models\BaseModel;
use \PDO;

class User extends BaseModel
{
    public function save($username, $email, $first_name, $last_name, $password) {
        $sql = "INSERT INTO users (username, email, first_name, last_name, password_hash) 
                VALUES (:username, :email, :first_name, :last_name, :password)";
        
        $statement = $this->db->prepare($sql);
        
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        // Bind parameters
        $statement->bindParam(':username', $username);
        $statement->bindParam(':email', $email);
        $statement->bindParam(':first_name', $first_name);
        $statement->bindParam(':last_name', $last_name);
        $statement->bindParam(':password', $hashed_password);
        
        // Execute the statement
        $statement->execute();

        return $statement->rowCount(); // Return the number of affected rows
    }
    public function getPassword($username) {
        $sql = "SELECT password_hash FROM users WHERE username = :username;";
        $statement = $this->db->prepare($sql);

        $statement->execute([
            'username' => $username
        ]);
        $result = $statement->fetchObject('\App\Models\User');
        return $result;
    }

    public function getData() {
        $sql = "SELECT * FROM users;";
        $statement = $this->db->prepare($sql);

        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_CLASS, '\App\Models\User');
        return $result;
    }
}