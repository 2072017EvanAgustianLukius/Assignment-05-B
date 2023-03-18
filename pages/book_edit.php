<?php
$bookId = filter_input(INPUT_GET, 'gid');
if (isset($bookId)){
    $book = fetchOneBookFromDB($bookId);
}
$updatePressed = filter_input(INPUT_POST, 'btnUpdate');
if (isset($updatePressed)){
    $title = filter_input(INPUT_POST, "txtTitle");
    $author = filter_input(INPUT_POST, "txtAuthor");
    $publisher = filter_input(INPUT_POST, "txtPublisher");
    $publisher_year = filter_input(INPUT_POST, "txtPublisherYear");
    $short_description = filter_input(INPUT_POST, "txtDescription");
    $genre = filter_input(INPUT_POST, "txtGenre");
    if (trim($title) == ''){
        echo 'Please fill a valid name';
    }else{
        $result = updateBooktoDB($title,$author,$publisher,$publisher_year,$short_description,$genre);
        if($result){
            header('location:index.php?menu=book');
        }else{
            echo '<div>Failed to Update</div>';
        }
    }
}

$result2 = fetchGenreFromDB();
?>

<form class="form-group container" method="post">
    <div class="form-group">
        <label for="txtISBN">ISBN</label>
        <input class="form-control" type="text" maxlength="13" id="txtISBN" name="txtISBN" required autofocus placeholder="ISBN" value="<?php echo $book['isbn']?>">
    </div>
    <div class="form-group">
        <label for="txtTitle">Title</label>
        <input class="form-control" type="text" maxlength="100" id="txtTitle" name="txtTitle" required autofocus placeholder="Title" value="<?php echo $book['title']?>">
    </div>
    <div class="form-group">
        <label for="txtAuthor">Author</label>
        <input class="form-control" type="text" maxlength="100" id="txtAuthor" name="txtAuthor" required autofocus placeholder="Author" value="<?php echo $book['author']?>">
    </div>
    <div class="form-group">
        <label for="txtPublisher">Publisher</label>
        <input class="form-control" type="text" maxlength="45" id="txtPublisher" name="txtPublisher" required autofocus placeholder="Pubisher" value="<?php echo $book['publisher']?>">
    </div>
    <div class="form-group">
        <label for="txtPublisherYear">Publisher Year</label>
        <input class="form-control" type="text" maxlength="4" id="txtPublisherYear" name="txtPublisherYear" required autofocus placeholder="Pubisher Year" value="<?php echo $book['publisher_year']?>">
    </div>
    <div class="form-group">
        <label for="txtDescription">Description</label>
        <textarea class="form-control" type="text" maxlength="305" id="txtDescription" name="txtDescription" required autofocus placeholder="Description"><?php echo $book['short_description']?></textarea>
    </div>
    <div class="form-group">
        <label for="txtGenre">Genre Name</label>
        <select class="form-control" name="txtGenre">
            <?php
            echo '<option value="'. $book['genre_id'] . '"> '. $book['genre_id'] .'</option>';
            foreach ($result2 as $book1){
                echo '<option value="'. $book1['id'] . '">' . $book1['name'] . '</option>';
            }
            ?>
        </select>
    </div>
    <br>
    <div class="form-group">
        <input class="btn btn-info form-control" type="submit" name="btnUpdate" value="Update Book">
    </div>
</form>
