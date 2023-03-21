<?php
$genreDao = new \dao\GenreDao();

$deleteCommand = filter_input(INPUT_GET, 'com');
if(isset($deleteCommand) && $deleteCommand == 'del'){
    $genreId = filter_input(INPUT_GET, 'gid');
    $result = $genreDao->deleteGenrefromDB($genreId);
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
        $result  = $genreDao->addGenreToDB($name);
        if($result){
            echo '<div>Data Successfully added </div>';
        }else{
            echo '<div>Failed to add Genre </div>';
        }
    }
}
?>

<form class="form-group" method="post">
    <div class="form-group">
        <label for="txtName">Name</label>
        <input class="form-control" type="text" maxlength="45" id="txtName" name="txtName" required autofocus placeholder="New Genre Name">
    </div>
    <input class="btn btn-info" class="form-control" type="submit" name="btnSave" value="Save Genre">
</form>



<table id="myTable" class="table table-striped table-bordered" style="width:100%">
    <thead class="thead-dark">
    <th>ID</th>
    <th>Name</th>
    <th>Actions</th>
    </thead>
    <tbody>
    <?php
    $genres = $genreDao->fetchGenreFromDB();
    /** @var \entity\Genre $genre */
    foreach ($genres as $genre){
        echo '<tr>';
        echo '<td>' . $genre->getId(). '</td>';
        echo '<td>' . $genre->getName() . '</td>';
        echo '<td>
            <button onclick="editGenre(' . $genre->getId() . ')"
            class="btn btn-warning">Edit Data</button>
            <button onclick="deleteGenre('. $genre->getId() . ')"
            class="btn btn-danger">Delete Data</button>';
        '</td>';
         echo '</tr>';
    }
    ?>
    </tbody>
</table>

<script>
    $(document).ready(function () {
        $('#myTable').DataTable();
    });
</script>
