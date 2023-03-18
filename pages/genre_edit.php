<?php
    $genreid = filter_input(INPUT_GET, 'gid');
    if (isset($genreid)){
        $genre = fetchOneGenreFromDB($genreid);
    }
    $updatePressed = filter_input(INPUT_POST, 'btnUpdate');
    if (isset($updatePressed)){
        $name = filter_input(INPUT_POST, 'txtName');
        if (trim($name) == ''){
            echo 'Please fill a valid genre name';
        }else{
            $result = updateGenretoDB($genreid, $name);
            if($result){
                header('location:index.php?menu=genre');
            }else{
                echo '<div>Failed to Update</div>';
            }
        }
    }
?>
<form class="form-group" method="post">
    <div class="form-group">
        <label for="txtID" class="col-form-label">Genre ID</label>
        <input type="text" class="form-control" readonly id="txtID" value="<?php echo $genre['id']?>">
    </div>
    <div class="form-group">
        <label for="txtName" class="col-form-label">Name</label>
        <input type="text" class="form-control" maxlength="45" id="txtName" name="txtName" required autofocus placeholder="New Genre Name" value="<?php echo $genre['name']?>">
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="btnUpdate" value="Update Genre">
    </div>
</form>