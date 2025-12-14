<?php
session_start();
include "../db/config.php";

// Handle upload
if(isset($_POST['add_course'])){
    $title = $_POST['title'];
    $description = $_POST['description'];
    $button_text = $_POST['button_text'];
    $button_link = $_POST['button_link'];

    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];
    move_uploaded_file($tmp, "uploads/".$image);

    $conn->query("INSERT INTO courses (title, description, image, button_text, button_link)
                  VALUES ('$title', '$description', '$image', '$button_text', '$button_link')");
}

// Handle delete
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $res = $conn->query("SELECT image FROM courses WHERE id=$id")->fetch_assoc();
    if($res && file_exists('/uploads/'.$res['image'])) unlink('/uploads/'.$res['image']);
    $conn->query("DELETE FROM courses WHERE id=$id");
}

// Fetch all courses
$courses = $conn->query("SELECT * FROM courses ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Courses</title>
<style>
body{font-family:Arial; background:#f3f3f3; padding:20px;}
.container{width:90%; margin:auto;}
form, table{background:white; padding:20px; border-radius:10px; margin-bottom:20px;}
input, textarea, button{width:100%; padding:10px; margin-top:10px; border-radius:5px; border:1px solid #aaa;}
button{background:#1f2937; color:white; border:none; cursor:pointer;}
table{width:100%; border-collapse:collapse;}
th, td{padding:10px; text-align:center; border-bottom:1px solid #ddd;}
th{background:#1f2937; color:white;}
img{width:120px; height:80px; object-fit:cover; border-radius:5px;}
a.button{padding:6px 12px; background:#1f2937; color:white; border-radius:5px; text-decoration:none; margin:2px;}
a.button.delete{background:red;}
</style>
</head>
<body>

<div class="container">
<h2>Add New Course</h2>
<form method="POST" enctype="multipart/form-data">
    <label>Course Image:</label>
    <input type="file" name="image" required>
    
    <label>Title:</label>
    <input type="text" name="title" required>
    
    <label>Description:</label>
    <textarea name="description" rows="4"></textarea>
    
    <label>Button Text:</label>
    <input type="text" name="button_text">
    
    <label>Button Link:</label>
    <input type="text" name="button_link">
    
    <button name="add_course">Add Course</button>
</form>

<h2>All Courses</h2>
<table>
<tr>
    <th>ID</th><th>Image</th><th>Title</th><th>Description</th><th>Button</th><th>Link</th><th>Actions</th>
</tr>
<?php while($row=$courses->fetch_assoc()): ?>
<tr>
    <td><?php echo $row['id']; ?></td>
    <td><img src="uploads/<?php echo $row['image']; ?>"></td>
    <td><?php echo $row['title']; ?></td>
    <td><?php echo $row['description']; ?></td>
    <td><?php echo $row['button_text']; ?></td>
    <td><?php echo $row['button_link']; ?></td>
    <td>
        <a class="button" href="edit_course.php?id=<?php echo $row['id']; ?>">Edit</a>
        <a class="button delete" href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete?')">Delete</a>
    </td>
</tr>
<?php endwhile; ?>
</table>
</div>
</body>
</html>
