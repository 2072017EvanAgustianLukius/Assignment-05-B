<?php
function fetchGenreFromDB(): bool|array
{
    $link = createMySQLConnection();
    $query = 'SELECT id, name FROM genre';
    $stmt = $link->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll();
    $link = null;
    return $result;
}


function addGenreToDB($newName){
    $result = 0;
    $link = createMySQLConnection();
    $link->beginTransaction();
    $query = "INSERT INTO genre(name) VALUES (?)";
    $stmt = $link->prepare($query);
    $stmt->bindParam(1, $newName);
    if($stmt->execute()){
        $link->commit();
        $result = 1;
    }else{
        $link->rollBack();
    }
    $link = null;
    return $result;
}

function fetchOneGenreFromDB($id){
    $link = createMySQLConnection();
    $query = 'SELECT id, name FROM genre WHERE id = ? ';
    $stmt = $link->prepare($query);
    $stmt->bindParam(1, $id);
    $stmt->execute();
    $result = $stmt->fetch();
    $link = null;
    return $result;
}

function updateGenretoDB($id, $name){
    $result = 0;
    $link = createMySQLConnection();
    $link->beginTransaction();
    $query = "UPDATE genre SET name = ? WHERE id = ?";
    $stmt = $link->prepare($query);
    $stmt->bindParam(1, $name);
    $stmt->bindParam(2, $id);
    if($stmt->execute()){
        $link->commit();
        $result = 1;
    }else{
        $link->rollBack();
    }
    $link = null;
    return $result;
}

function deleteGenrefromDB($id){
    $result = 0;
    $link = createMySQLConnection();
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