<?php

namespace dao;

use entity\Genre;
use PDO;

class GenreDao
{
    public function fetchGenreFromDB(): bool|array
    {
        $link = PDOUtil::createMySQLConnection();
        $query = 'SELECT id, name FROM genre';
        $stmt = $link->prepare($query);
        $stmt ->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE,Genre::class);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $link = null;
        return $result;
    }


    public function addGenreToDB(Genre $genre):int
    {
        $result = 0;
        $link = PDOUtil::createMySQLConnection();
        $link->beginTransaction();
        $query = "INSERT INTO genre(name) VALUES (?)";
        $stmt = $link->prepare($query);
        $stmt->bindValue(1, $genre->getName());
        if($stmt->execute()){
            $link->commit();
            $result = 1;
        }else{
            $link->rollBack();
        }
        $link = null;
        return $result;
    }

    public function fetchOneGenreFromDB($id){
        $link = PDOUtil::createMySQLConnection();
        $query = 'SELECT id, name FROM genre WHERE id = ? ';
        $stmt = $link->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        $stmt->execute();
        $result = $stmt->fetchObject(Genre::class);
        $link = null;
        return $result;
    }

    public function updateGenretoDB(Genre $genre){
        $result = 0;
        $link = PDOUtil::createMySQLConnection();
        $link->beginTransaction();
        $query = "UPDATE genre SET name = ? WHERE id = ?";
        $stmt = $link->prepare($query);
        $stmt->bindValue(1, $genre->getName());
        $stmt->bindValue(2, $genre->getId());
        if($stmt->execute()){
            $link->commit();
            $result = 1;
        }else{
            $link->rollBack();
        }
        $link = null;
        return $result;
    }

    public function deleteGenrefromDB($id){
        $result = 0;
        $link = PDOUtil::createMySQLConnection();
        $link->beginTransaction();
        $query = "DELETE FROM genre WHERE id = ?";
        $stmt = $link->prepare($query);
        $stmt->bindParam(1, $id);
        if($stmt->execute()){
            $link->commit();
            $result = 1;
        }else{
            $link->rollBack();
        }
        $link = null;
        return $result;
    }
}