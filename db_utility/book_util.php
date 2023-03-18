<?php
function fetchBookFromDB(): bool|array
{
    $result = 0;
    $link = createMySQLConnection();
    $query = 'SELECT isbn, title, author, publisher, publisher_year, short_description, genre_id, name FROM book INNER JOIN genre ON book.genre_id = genre.id';
    $stmt = $link->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll();
    $link = null;
    return $result;
}


function addBookToDB($isbn,$title,$author,$publisher,$publisher_year,$short_description,$genre){
    $result = 0;
    $link = createMySQLConnection();
    $link->setAttribute(PDO::ATTR_AUTOCOMMIT, false);
    $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $link->beginTransaction();
    $query = "INSERT INTO book(isbn, title, author, publisher, publisher_year, short_description, genre_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $link->prepare($query);
    $stmt->bindParam(1, $isbn);
    $stmt->bindParam(2, $title);
    $stmt->bindParam(3, $author);
    $stmt->bindParam(4, $publisher);
    $stmt->bindParam(5, $publisher_year);
    $stmt->bindParam(6, $short_description);
    $stmt->bindParam(7, $genre);
    if($stmt->execute()){
        $link->commit();
        $result = 1;
    }else{
        $link->rollBack();
    }
    $link = null;
    return $result;
}

function uploadCover($isbn, $cover){
    $result = 0;
    $link = createMySQLConnection();
    $link->beginTransaction();
    $query = "UPDATE book SET cover = ? WHERE isbn = ?";
    $stmt = $link->prepare($query);
    $stmt->bindParam(1, $cover);
    $stmt->bindParam(2, $isbn);
    if($stmt->execute()){
        $link->commit();
        $result = 1;
    }else{
        $link->rollBack();
    }
    $link = null;
    return $result;
}

function fetchOneBookFromDB($isbn){
    $link = createMySQLConnection();
    $query = 'SELECT isbn, title, author, publisher, publisher_year, short_description, genre_id FROM book WHERE isbn = ? ';
    $stmt = $link->prepare($query);
    $stmt->bindParam(1, $isbn);
    $stmt->execute();
    $result = $stmt->fetch();
    $link = null;
    return $result;
}

function updateBooktoDB($title,$author,$publisher,$publisher_year,$short_description,$genre){
    $result = 0;
    $link = createMySQLConnection();
    $link->beginTransaction();
    $query = "UPDATE book SET title = ?, author = ?, publisher = ?, publisher_year = ?, short_description = ?, genre_id = ? WHERE isbn = ?";
    $stmt = $link->prepare($query);
    $stmt->bindParam(1, $title);
    $stmt->bindParam(2, $author);
    $stmt->bindParam(3, $publisher);
    $stmt->bindParam(4, $publisher_year);
    $stmt->bindParam(5, $short_description);
    $stmt->bindParam(6, $genre);
    $stmt->bindParam(7, $isbn);
    if($stmt->execute()){
        $link->commit();
        $result = 1;
    }else{
        $link->rollBack();
    }
    $link = null;
    return $result;
}

function deleteBookfromDB($isbn){
    $result = 0;
    $link = createMySQLConnection();
    $link->beginTransaction();
    $query = "DELETE FROM book WHERE isbn = ?";
    $stmt = $link->prepare($query);
    $stmt->bindParam(1, $isbn);
    if($stmt->execute()){
        $link->commit();
        $result = 1;
    }else{
        $link->rollBack();
    }
    $link = null;
    return $result;
}

