<?php

use controller\GenreController;
use controller\UserController;
use controller\BookController;

session_start();
if(!isset($_SESSION['is_user_logged'])){
    $_SESSION['is_user_logged'] = false;
}
include_once 'db_utility/db_util.php';
//include_once 'db_utility/genre_util.php';
include_once 'db_utility/book_util.php';
//include_once 'db_utility/user_util.php';

include_once 'entity/Genre.php';
include_once 'entity/User.php';
include_once 'entity/Book.php';
include_once "dao/PDOUtil.php";
include_once 'dao/UserDao.php';
include_once 'dao/GenreDao.php';
include_once 'dao/BookDao.php';
include_once 'controller/UserController.php';
include_once 'controller/GenreController.php';
include_once 'controller/BookController.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href ="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.3/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<script src="js/genre.js"></script>
<script src="js/book.js"></script>
<body>

<?php
if($_SESSION['is_user_logged']){
    ?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a href="?menu=home" class="nav-link">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a href="?menu=genre" class="nav-link">Genre</a>
            </li>
            <li class="nav-item">
                <a href="?menu=book" class="nav-link">Book</a>
            </li>
            <li class="nav-item">
                <a href="?menu=logout" class="nav-link">Log Out</a>
            </li>
        </ul>
    </div>
</nav>

<main class="main">
    <?php
    $navigation = filter_input(INPUT_GET, 'menu');
    switch ($navigation){
        case 'home':
            include_once 'pages/home.php';
            break;
        case 'genre':
            $genreController = new GenreController();
            $genreController->index();
            break;
        case 'book':
            include_once 'pages/book.php';
            break;
        case 'genre_edit':
            $genreController = new GenreController();
            $genreController->edit();
            break;
        case 'book_edit':
            $bookController = new BookController();
            $bookController->edit();
            include_once 'pages/book_edit.php';
            break;
        case  'upload':
            include_once 'pages/upload.php';
            break;
        case 'logout':
            session_unset();
            session_destroy();
            header('location:index.php');
            break;
        default:
            include_once 'pages/home.php';
    }
    ?>
</main>
<?php
} else {
        $userController = new UserController();
        $userController->index();
}
?>
<script>
    $(document).ready(function ()){
        $('#myTable').DataTable();
    });
</script>

</body>
</html>