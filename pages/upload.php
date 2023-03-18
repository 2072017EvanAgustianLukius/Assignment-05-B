<?php
$isbn = filter_input(INPUT_GET, 'gisbn');
if (isset($_POST['bthUpload'])) {
    if (isset($_FILES["imageFile"]) && $_FILES["imageFile"]["error"] == 0) {
        $allowedTypes = array("image/jpeg", "image/png");
        $maxSize = 5 * 1200 * 1200; // 5 MB

        if (in_array($_FILES["imageFile"]["type"], $allowedTypes) &&
            $_FILES["imageFile"]["size"] <= $maxSize) {
            $filename = $isbn . '.' . pathinfo($_FILES["imageFile"]["name"], PATHINFO_EXTENSION);
            $uploadDir = "upload/";
            $uploadPath = $uploadDir . $filename;
            move_uploaded_file($_FILES["imageFile"]["tmp_name"], $uploadPath);

            $link = createMySQLConnection();
            $sql = "UPDATE book SET cover = ? WHERE isbn = ?";
            $stmt = $link->prepare($sql);
            $stmt->bindParam(1, $uploadPath); 
            $stmt->bindParam(2, $isbn);
            $stmt->execute();

            $stmt->execute();

            echo "File uploaded successfully.";
        } else {
            echo "Invalid file type or size.";
        }
    } else {
        echo "No file was uploaded.";
    }
}
$result3 = fetchBookFromDB();
?>

<form class="form-group container-fluid" method="post" enctype="multipart/form-data">
    <div class = form-group>
        <?php
        foreach ($result3 as $book) {
            echo '<img src="upload/' . $book['cover'] . '" width="100">';
        }
        ?>
        <br>
        <label>Current Cover</label>
    <input type="file" name="imageFile" accept="image/*" class="form-control"><br>
    <input type="submit" name="bthUpload" value="Upload Image" class="btn-primary">
    </div>
</form>
