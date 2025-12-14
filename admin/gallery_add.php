<?php
include "../db/config.php";

if (isset($_POST['upload'])) {
    $title = $_POST['title'];

    $imgName = time() . "_" . $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];

    move_uploaded_file($tmp, "uploads/" . $imgName);

    $sql = "INSERT INTO gallery (title, image) VALUES ('$title','$imgName')";
    mysqli_query($conn, $sql);

    header("Location: gallery_add.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Gallery</title>
</head>
<body>
<form method="post" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Image Title" required><br><br>
    <input type="file" name="image" required><br><br>
    <button name="upload">Upload</button>
</form>
</body>
</html>
