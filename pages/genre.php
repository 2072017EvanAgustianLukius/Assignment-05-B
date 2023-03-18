<?php
$deleteCommand = filter_input(INPUT_GET, 'com');
if(isset($deleteCommand) && $deleteCommand == 'del'){
    $genreId = filter_input(INPUT_GET, 'gid');
    $result = deleteGenrefromDB($genreId);
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
        $result  = addGenreToDB($name);
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

<?php
$link = createMySQLConnection();
$result = fetchGenreFromDB();
$link = null;
?>

<table id="myTable" class="table table-striped table-bordered" style="width:100%">
    <thead class="thead-dark">
    <th>ID</th>
    <th>Name</th>
    <th>Actions</th>
    </thead>
    <tbody>
    <?php
    foreach ($result as $genre){
        echo '<tr>';
        echo '<td>' . $genre['id'] . '</td>';
        echo '<td>' . $genre['name'] . '</td>';
        echo '<td>
            <button onclick="editGenre(' . $genre['id'] . ')"
            class="btn btn-warning">Edit Data</button>
            <button onclick="deleteGenre('. $genre['id'] . ')"
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
