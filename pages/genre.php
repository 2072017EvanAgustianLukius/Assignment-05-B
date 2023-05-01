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
