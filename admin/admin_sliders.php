<?php
session_start();
include "../db/config.php";

// Ensure uploads folder exists
$upload_dir = __DIR__ . "/uploads/";
if(!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

// Handle upload
if(isset($_POST['upload'])){
    $image = $_FILES['image']['name'];
    $target = $upload_dir . basename($image);
    if(move_uploaded_file($_FILES['image']['tmp_name'], $target)){
        $heading = $_POST['heading'];
        $paragraph = $_POST['paragraph'];
        $btn_text = $_POST['btn_text'];
        $btn_link = $_POST['btn_link'];

        $sql = "INSERT INTO slider_images (image, heading, paragraph, btn_text, btn_link)
                VALUES ('$image', '$heading', '$paragraph', '$btn_text', '$btn_link')";
        $conn->query($sql);
    } else {
        echo "Failed to upload image. Check folder permissions.";
    }
}

// Handle delete
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $res = $conn->query("SELECT image FROM slider_images WHERE id=$id")->fetch_assoc();
    if($res){
        $img_path = $upload_dir . $res['image'];
        if(file_exists($img_path)) unlink($img_path);
    }
    $conn->query("DELETE FROM slider_images WHERE id=$id");
}

// Fetch slides
$slides = $conn->query("SELECT * FROM slider_images ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>
<style>
body{font-family:Arial;background:#f3f3f3;padding:20px;}
.container{width:90%;margin:auto;}
h2{text-align:center;}
form, table{background:white;padding:20px;border-radius:10px;margin-bottom:20px;}
input, textarea, button{width:100%;padding:10px;margin-top:10px;border-radius:5px;border:1px solid #aaa;}
button{background:#1f2937;color:white;border:none;}
table{width:100%;border-collapse:collapse;}
th, td{padding:10px;text-align:center;border-bottom:1px solid #ddd;}
th{background:#1f2937;color:white;}
img{width:120px;height:60px;object-fit:cover;border-radius:5px;}
a.button{padding:6px 12px;background:#1f2937;color:white;border-radius:5px;text-decoration:none;margin:2px;}
a.button.delete{background:red;}
</style>
</head>
<body>

<div class="container">
<h2>Upload Slide</h2>
<form method="POST" enctype="multipart/form-data">
    <label>Image:</label>
    <input type="file" name="image" required>
    <label>Heading:</label>
    <input type="text" name="heading">
    <label>Paragraph:</label>
    <textarea name="paragraph"></textarea>
    <label>Button Text:</label>
    <input type="text" name="btn_text">
    <label>Button Link:</label>
    <input type="text" name="btn_link">
    <button name="upload">Upload Slide</button>
</form>

<h2>All Slides</h2>
<table>
<tr>
    <th>ID</th><th>Image</th><th>Heading</th><th>Paragraph</th><th>Button</th><th>Link</th><th>Actions</th>
</tr>
<?php while($row=$slides->fetch_assoc()): ?>
<tr>
    <td><?php echo $row['id']; ?></td>
    <td><img src="uploads/<?php echo $row['image']; ?>"></td>
    <td><?php echo $row['heading']; ?></td>
    <td><?php echo $row['paragraph']; ?></td>
    <td><?php echo $row['btn_text']; ?></td>
    <td><?php echo $row['btn_link']; ?></td>
    <td>
        <a class="button" href="edit_slide.php?id=<?php echo $row['id']; ?>">Edit</a>
        <a class="button delete" href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete?')">Delete</a>
    </td>
</tr>
<?php endwhile; ?>
</table>

</div>
</body>
</html>
