<form class="form-group" method="post">
    <div class="form-group">
        <label for="txtID" class="col-form-label">Genre ID</label>
        <input type="text" class="form-control" readonly id="txtID" value="<?php echo $genre->getId()?>">
    </div>
    <div class="form-group">
        <label for="txtName" class="col-form-label">Name</label>
        <input type="text" class="form-control" maxlength="45" id="txtName" name="txtName" required autofocus placeholder="New Genre Name" value="<?php echo $genre->getName()?>">
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="btnUpdate" value="Update Genre">
    </div>
</form>