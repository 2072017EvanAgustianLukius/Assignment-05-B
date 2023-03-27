<?php
namespace dao;

use entity\Book;
use PDO;

class BookDao{
    public function fetchBookFromDB(): array
    {
        $link =  PDOUtil::createMySQLConnection();
        $query = 'SELECT isbn, title, author, publisher, publisher_year, short_description, cover , genre_id, name FROM book INNER JOIN genre ON book.genre_id = genre.id';
        $stmt = $link->prepare($query);
        $stmt ->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Book::class);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $link = null;
        return $result;
    }


    public function addBookToDB(Book $book): int {
        $result = 0;
        $link =  PDOUtil::createMySQLConnection();
        $link->setAttribute(PDO::ATTR_AUTOCOMMIT, false);
        $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $link->beginTransaction();
        $query = "INSERT INTO book(isbn, title, author, publisher, publisher_year, short_description, cover, genre_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $link->prepare($query);
        $isbn = $book->getIsbn();
        $title = $book->getTitle();
        $author = $book->getAuthor();
        $publisher = $book->getPublisher();
        $publisher_year = $book->getPublisherYear();
        $short_description = $book->getShortDescription();
        $cover = $book->getCover();
        $genre = $book->getGenreId();
        $stmt->bindParam(1, $isbn);
        $stmt->bindParam(2, $title);
        $stmt->bindParam(3, $author);
        $stmt->bindParam(4, $publisher);
        $stmt->bindParam(5, $publisher_year);
        $stmt->bindParam(6, $short_description);
        $stmt->bindParam(7, $cover);
        $stmt->bindParam(8, $genre);
        if($stmt->execute()){
            $link->commit();
            $result = 1;
        }else{
            $link->rollBack();
        }
        $link = null;
        return $result;
    }


    public function uploadCover($isbn, $cover){
        $result = 0;
        $link = PDOUtil::createMySQLConnection();
        $link->beginTransaction();
        $query = "UPDATE book SET cover = ? WHERE isbn = ?";
        $stmt = $link->prepare($query);
        $stmt->bindParam(1, $cover);
        $stmt->bindParam(2, $isbn);
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        if($stmt->execute()){
            $link->commit();
            $result = 1;
        }else{
            $link->rollBack();
        }
        $link = null;
        return $result;
    }


    public function fetchOneBookFromDB($isbn){
        $link = PDOUtil::createMySQLConnection();
        $query = 'SELECT isbn, title, author, publisher, publisher_year, short_description, genre_id FROM book WHERE isbn = ? ';
        $stmt = $link->prepare($query);
        $stmt->bindParam(1, $isbn);
        $stmt->execute();
        $result = $stmt->fetch();
        $link = null;
        return $result;
    }

    public function updateBooktoDB(Book $book){
        $result = 0;
        $link = PDOUtil::createMySQLConnection();
        $link->beginTransaction();
        $query = "UPDATE book SET title = ?, author = ?, publisher = ?, publisher_year = ?, short_description = ?, cover = ?, genre_id = ? WHERE isbn = ?";
        $stmt = $link->prepare($query);
        $title = $book->getTitle();
        $author = $book->getAuthor();
        $publisher = $book->getPublisher();
        $publisher_year = $book->getPublisherYear();
        $short_description = $book->getShortDescription();
        $cover = $book->getCover();
        $genre = $book->getGenre();
        $isbn = $book->getIsbn();
        $stmt->bindParam(1, $title);
        $stmt->bindParam(2, $author);
        $stmt->bindParam(3, $publisher);
        $stmt->bindParam(4, $publisher_year);
        $stmt->bindParam(5, $short_description);
        $stmt->bindParam(6, $cover);
        $stmt->bindParam(7, $genre);
        $stmt->bindParam(8, $isbn);
        if($stmt->execute()){
            $link->commit();
            $result = 1;
        }else{
            $link->rollBack();
        }
        $link = null;
        return $result;
    }


    public function deleteBookfromDB($isbn){
        $result = 0;
        $link = PDOUtil::createMySQLConnection();
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

}
