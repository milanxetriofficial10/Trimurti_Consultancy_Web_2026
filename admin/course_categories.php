<?php
session_start();
include "../db/config.php";

// Handle add
if(isset($_POST['add_category'])){
    $name = $_POST['name'];
    $description = $_POST['description'];
    
    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];
    $upload_dir = "uploads/";

    if(move_uploaded_file($tmp, $upload_dir.$image)){
        $conn->query("INSERT INTO course_categories (name, description, image) VALUES ('$name','$description','$image')");
    } else {
        echo "Image upload failed!";
    }
}

// Handle delete
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $res = $conn->query("SELECT image FROM course_categories WHERE id=$id")->fetch_assoc();
    if($res && file_exists('uploads/'.$res['image'])) unlink('uploads/'.$res['image']);
    $conn->query("DELETE FROM course_categories WHERE id=$id");
}

// Fetch all categories
$categories = $conn->query("SELECT * FROM course_categories ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Course Categories</title>
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
<h2>Add Course Category</h2>
<form method="POST" enctype="multipart/form-data">
    <label>Category Image:</label>
    <input type="file" name="image" required>
    
    <label>Category Name:</label>
    <input type="text" name="name" required>
    
    <label>Description:</label>
    <textarea name="description" rows="3"></textarea>
    
    <button name="add_category">Add Category</button>
</form>

<h2>All Categories</h2>
<table>
<tr>
    <th>ID</th><th>Image</th><th>Name</th><th>Description</th><th>Actions</th>
</tr>
<?php while($row=$categories->fetch_assoc()): ?>
<tr>
    <td><?php echo $row['id']; ?></td>
    <td><img src="uploads/<?php echo $row['image']; ?>"></td>
    <td><?php echo $row['name']; ?></td>
    <td><?php echo $row['description']; ?></td>
    <td>
        <a class="button" href="edit_category.php?id=<?php echo $row['id']; ?>">Edit</a>
        <a class="button delete" href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete?')">Delete</a>
    </td>
</tr>
<?php endwhile; ?>
</table>
</div>
</body>
</html>
