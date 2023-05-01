<?php

namespace controller;

use dao\BookDao;
use entity\Book;
use dao\GenreDao;
use entity\Genre;

class BookController
{
    private BookDao $bookDao;
    private GenreDao $genreDao;

    public function __construct()
    {
        $this->bookDao = new BookDao();
        $this->genreDao = new GenreDao();
    }

    public function index() :void
    {
        $bookDao = new \dao\BookDao();
        $deleteCommand = filter_input(INPUT_GET, 'com');
        if(isset($deleteCommand) && $deleteCommand == 'del'){
            $bookId = filter_input(INPUT_GET, 'gisbn');
            $result = $bookDao->deleteBookFromDB($bookId);
            if($result){
                echo '<div>Data successfully deleted</div>';
            }else{
                echo '<div>Failed to delete genre</div>';
            }
        }

        $saveButtonPressed = filter_input(INPUT_POST, "btnSave");
        if (isset($saveButtonPressed)){
            $isbn = filter_input(INPUT_POST, "txtISBN");
            $title = filter_input(INPUT_POST, "txtTitle");
            $author = filter_input(INPUT_POST, "txtAuthor");
            $publisher = filter_input(INPUT_POST, "txtPublisher");
            $publisher_year = filter_input(INPUT_POST, "txtPublisherYear");
            $short_description = filter_input(INPUT_POST, "txtDescription");
            $genre = filter_input(INPUT_POST, "txtGenre");
            $targetFile = '';
            if(isset($_FILES['cover']['name'])){
                $targetDirectory = 'upload/';
                $fileExtension = pathinfo($_FILES['cover']['name'],PATHINFO_EXTENSION);
                $newFileName= $isbn . '.' . $fileExtension;
                $targetFile = $targetDirectory . $newFileName;
                if($_FILES['cover']['size'] > 5 * 1200 * 1200){
                    echo '<div class="bg-info">Upload error. File size exceed 2 MB</div>';
                }else{
                    move_uploaded_file($_FILES['cover']['tmp_name'],$targetFile);
                }
            }
            if (trim($isbn) == ""){
                echo 'Please fill a valid ISBN';
            } else {
                require_once 'entity/Book.php';
                $book = new \entity\Book();
                $book->setIsbn($isbn);
                $book->setTitle($title);
                $book->setAuthor($author);
                $book->setPublisher($publisher);
                $book->setYear($publisher_year);
                $book->setDescription($short_description);
                $book->setGenre($genre);
                $book->setCover($targetFile);
                $result = $bookDao->addBookToDB($book);
                if($result){
                    echo '<div>Data Successfully added </div>';
                } else {
                    echo '<div>Failed to add Book </div>';
                }
            }
        }
        $genres = $this->genreDao->fetchGenreFromDB();
        $books = $this->bookDao->fetchBookFromDB();
        include_once 'pages/book.php';
    }


    public function edit(): void
    {
        $bookDao = new \dao\BookDao();

        $bookId = filter_input(INPUT_GET, 'gid');
        if (isset($bookId)){
            $book = $bookDao->getBookById($bookId);
        }
        $updatePressed = filter_input(INPUT_POST, 'btnUpdate');
        if (isset($updatePressed)) {

            $isbn = $book['isbn'];
            $title = filter_input(INPUT_POST, "txtTitle");
            $author = filter_input(INPUT_POST, "txtAuthor");
            $publisher = filter_input(INPUT_POST, "txtPublisher");
            $publisher_year = filter_input(INPUT_POST, "txtPublisherYear");
            $short_description = filter_input(INPUT_POST, "txtDescription");
            $cover = filter_input(INPUT_POST, "cover");
            $genre = filter_input(INPUT_POST, "txtGenre");
            if (trim($title) == '') {
                echo 'Please fill a valid name';
            } else {
                if (isset($_FILES["imageFile"]) && $_FILES["imageFile"]["error"] == 0) {
                    $allowedTypes = array("image/jpeg", "image/png");
                    $maxSize = 5 * 1200 * 1200; // 5 MB

                    if (in_array($_FILES["imageFile"]["type"], $allowedTypes) &&
                        $_FILES["imageFile"]["size"] <= $maxSize) {
                        $filename = $isbn . '.' . pathinfo($_FILES["imageFile"]["name"], PATHINFO_EXTENSION);
                        $uploadDir = "upload/";
                        $uploadPath = $uploadDir . $filename;
                        move_uploaded_file($_FILES["imageFile"]["tmp_name"], $uploadPath);

                        $link = $bookDao->getConnection();
                        $sql = "UPDATE book SET cover = ? WHERE isbn = ?";
                        $stmt = $link->prepare($sql);
                        $stmt->bindParam(1, $uploadPath);
                        $stmt->bindParam(2, $isbn);
                        $stmt->execute();
                    }
                    $book['title'] = $title;
                    $book['author'] = $author;
                    $book['publisher'] = $publisher;
                    $book['publisher_year'] = $publisher_year;
                    $book['short_description'] = $short_description;
                    $book['cover'] = $cover;
                    $book['genre'] = $genre;
                    $result = $bookDao->updateBook($book);
                    if ($result) {
                        header('location:index.php?menu=book');
                    } else {
                        echo '<div>Failed to Update</div>';
                    }
                }
            }
        }
        $result2 = $bookDao->fetchGenreFromDB();
        $result3 = $bookDao->fetchBookFromDB();
        include_once 'pages/book_edit.php';
    }
}
