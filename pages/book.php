<?php
$genreDao = new \dao\GenreDao();
$bookDao = new \dao\BookDao();

$deleteCommand = filter_input(INPUT_GET, 'com');
if(isset($deleteCommand) && $deleteCommand == 'del'){
    $bookId = filter_input(INPUT_GET, 'gisbn');
    $result = $bookDao->deleteBookfromDB($bookId);
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
        echo 'Please fill a valid Book name';
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
?>

<?php
$link = \dao\PDOUtil::createMySQLConnection();
?>


<form class="form-group container" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="txtISBN">ISBN</label>
        <input class="form-control" type="text" maxlength="13" id="txtISBN" name="txtISBN" required autofocus placeholder="ISBN">
    </div>
    <div class="form-group">
        <label for="txtTitle">Title</label>
        <input class="form-control" type="text" maxlength="100" id="txtTitle" name="txtTitle" required autofocus placeholder="Title">
    </div>
    <div class="form-group">
        <label for="txtAuthor">Author</label>
        <input class="form-control" type="text" maxlength="100" id="txtAuthor" name="txtAuthor" required autofocus placeholder="Author">
    </div>
    <div class="form-group">
        <label for="txtPublisher">Publisher</label>
        <input class="form-control" type="text" maxlength="45" id="txtPublisher" name="txtPublisher" required autofocus placeholder="Publisher">
    </div>
    <div class="form-group">
        <label for="txtPublisherYear">Publisher Year</label>
        <input class="form-control" type="text" maxlength="4" id="txtPublisherYear" name="txtPublisherYear" required autofocus placeholder="Publisher Year">
    </div>
    <div class="form-group">
        <label for="txtDescription">Description</label>
        <textarea class="form-control" maxlength="305" id="txtDescription" name="txtDescription" required autofocus placeholder="Description"></textarea>
    </div>
    <div class="form-group">
        <label for="txtGenre">Genre</label>
        <select class="form-control" name="txtGenre">
            <?php
            $genres = $genreDao->fetchGenreFromDB();
            foreach ($genres as $book) {
                echo '<option value="' . $book->getId() . '">' . $book->getName() . '</option>';
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label>Cover File</label>
        <input type="file" name="cover" class="form-control" accept="image/png, image/jpeg">
    </div>
    <input class="btn btn-info form-control" type="submit" name="btnSave" value="Save Book">
</form>

<?php


echo '<table id="myTable" class="table table-striped table-bordered" style="width:100%">';
echo '<thead>';
echo '<tr>';
echo '<th>Cover</th>';
echo '<th>ISBN</th>';
echo '<th>Title</th>';
echo '<th>Author</th>';
echo '<th>Publisher</th>';
echo '<th>Publisher Year</th>';
echo '<th>Short Description</th>';
echo '<th>Category</th>';
echo '<th>Action</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';
$books = $bookDao->fetchBookFromDB();
foreach ($books as $book) {
    echo '<tr>';
    echo '<td>';
    if($book->getCover() == null || $book->getCover() == ""){
        echo '<img src="upload/default_book.jpg" width="100">';
    }else{
        echo '<img src="upload/' . $book->getCover() . '" width="100">';
    }
    echo '</td>';
    echo '<td>' . $book->getIsbn() . '</td>';
    echo '<td>' . $book->getTitle() . '</td>';
    echo '<td>' . $book->getAuthor() . '</td>';
    echo '<td>' . $book->getPublisher() . '</td>';
    echo '<td>' . $book->getYear() . '</td>';
    echo '<td>' . $book->getDescription() . '</td>';
    echo '<td>' . $book->getGenre()->getName() . '</td>';
    echo '<td>
            <button onclick="UploadCover(' . $book->getIsbn() . ')" class="btn btn-primary">Change Cover</button>
            <button onclick="editBook(' . $book->getIsbn() . ')" class="btn btn-warning">Edit Data</button>
            <button onclick="deleteBook('. $book->getIsbn() . ')" class="btn btn-danger">Delete Data</button>
         </td>';
    echo '</tr>';
}

echo '</tbody>';
echo '</table>';



?>

<script>
    $(document).ready(function () {
        $('#myTable').DataTable();
    });
</script>

