<?php

namespace dao;

use entity\User;
use PDO;

class UserDao
{
    public function login($email, $password):bool|User
    {
        $link = PDOUtil::createMySQLConnection();
        $query = "SELECT id, name, email FROM user WHERE email = ? AND password = MD5(?)";
        $stmt = $link->prepare($query);
        $stmt->bindParam(1, $email);
        $stmt->bindParam(2, $password);
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        $stmt->execute();
        $user = $stmt->fetchObject(User::class);
        $link = null;
        return $user;
    }
}