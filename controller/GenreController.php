<?php

namespace controller;

use dao\GenreDao;
use entity\Genre;

class GenreController
{
    private GenreDao $genreDao;

    public function __construct()
    {
        $this->genreDao = new GenreDao();
    }

    public function index() :void
    {
        $deleteCommand = filter_input(INPUT_GET, 'com');
        if(isset($deleteCommand) && $deleteCommand == 'del'){
            $genreId = filter_input(INPUT_GET, 'gid');
            $result = $this->genreDao->deleteGenrefromDB($genreId);
            if($result){
                echo '<div>Data successfully deleted</div>';
            }else{
                echo '<div>Failed to delete genre</div>';
            }
        }

        $saveButtonPressed = filter_input(INPUT_POST, "btnSave");
        if (isset($saveButtonPressed)){
            $name = filter_input(INPUT_POST, "txtName");
            if (trim($name) == ""){
                echo 'Please fill a valid genre name';
            } else {
                $genre = new \entity\Genre();
                $genre->setName($name);
                $result  = $this->genreDao->addGenreToDB($genre);
                if($result){
                    echo '<div>Data Successfully added </div>';
                }else{
                    echo '<div>Failed to add Genre </div>';
                }
            }
        }
        $genres = $this->genreDao->fetchGenreFromDB();
        include_once 'pages/genre.php';
    }

    public function edit(): void
    {
        $genreDao = new \dao\GenreDao();

        $genreid = filter_input(INPUT_GET, 'gid');
        if (isset($genreid)){
            $genre = $this->genreDao->fetchOneGenreFromDB($genreid);
        }
        $updatePressed = filter_input(INPUT_POST, 'btnUpdate');
        if (isset($updatePressed)){
            $name = filter_input(INPUT_POST, 'txtName');
            if (trim($name) == ''){
                echo 'Please fill a valid genre name';
            }else{
                $updatedGenre = new Genre();
                $updatedGenre->setId($genreid);
                $updatedGenre->setName($name);
                $result = $this->genreDao->updateGenretoDB($updatedGenre);
                if($result){
                    header('location:index.php?menu=genre');
                }else{
                    echo '<div>Failed to Update</div>';
                }
            }
        }
        include_once 'pages/genre_edit.php';
    }
}
