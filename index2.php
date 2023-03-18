<?php
$uploadRequest = filter_input(INPUT_POST,'btnUpload');
if (isset($uploadRequest)){
    $fileName = filter_input(INPUT_POST, 'txtName');
    $targetDirectory ='upload/';
    $fileExtension = pathinfo($_FILES['imageFile']['name'], PATHINFO_EXTENSION);
    $pathToUpload = $targetDirectory . $fileName . '.' . $fileExtension;
    if ($_FILES['imageFile']['size'] > 1024 * 2048){
        echo '<div>File size exceed 2MB. Please choose another file.</div>';
    } else {
        move_uploaded_file($_FILES['imageFile']['tmp_name'], $pathToUpload);
    }
}
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
</head>
<body>
<div class="container">
    <form method="post" enctype="multipart/form-data">
        <input type="text" name="txtName" placeholder="File Name" class="form-control">
        <input type="file" name="imageFile" accept="image/*" class="form-control">
        <div>
        <input type="submit" name="bthUpload" value="Upload Image" class="btn-primary">
        </div>
    </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>