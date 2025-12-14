<?php
session_start();
include "../db/config.php"; // DB connection

// Add new slide
if(isset($_POST['add_slide'])){
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    
    if(isset($_FILES['image']) && $_FILES['image']['name'] != ""){
        $filename = time() . "_" . $_FILES['image']['name'];
        $target = "uploads/" . $filename;
        if(move_uploaded_file($_FILES['image']['tmp_name'], $target)){
            mysqli_query($conn, "INSERT INTO contact_slides (title, image) VALUES ('$title', '$filename')");
            $msg = "Slide added successfully!";
        } else {
            $error = "Image upload failed!";
        }
    } else {
        $error = "Please select an image!";
    }
}

// Delete slide
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);
    $slide = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM contact_slides WHERE id=$id"));
    if($slide){
        if(file_exists("uploads/".$slide['image'])) unlink("uploads/".$slide['image']);
        mysqli_query($conn, "DELETE FROM contact_slides WHERE id=$id");
        header("Location: contact_slides.php");
        exit();
    }
}

// Fetch slides
$slides = mysqli_query($conn, "SELECT * FROM contact_slides ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - Contact Slides</title>
<style>
body { font-family: Arial; background:#f4f4f4; margin:0; padding:0; }
.container { max-width:1000px; margin:50px auto; padding:0 20px; }
h2 { color:#333; margin-bottom:20px; }
form { background:#fff; padding:20px; border-radius:10px; margin-bottom:30px; box-shadow:0 4px 10px rgba(0,0,0,0.1); }
form input[type=text], form input[type=file] { width:100%; padding:10px; margin-bottom:10px; border:1px solid #ccc; border-radius:5px; }
form button { padding:10px 20px; background:#007bff; color:#fff; border:none; border-radius:5px; cursor:pointer; }
form button:hover { background:#0056b3; }
table { width:100%; border-collapse:collapse; background:#fff; border-radius:10px; overflow:hidden; }
th, td { padding:12px; border-bottom:1px solid #ddd; text-align:left; }
th { background:#007bff; color:#fff; }
tr:hover { background:#f1f1f1; }
a.delete { color:red; text-decoration:none; }
img { max-width:120px; border-radius:5px; }
.message { margin-bottom:15px; padding:10px; border-radius:5px; }
.success { background:#d4edda; color:#155724; }
.error { background:#f8d7da; color:#721c24; }
</style>
</head>
<body>

<div class="container">
    <h2>Manage Contact Page Slides</h2>

    <?php if(isset($msg)) echo "<div class='message success'>$msg</div>"; ?>
    <?php if(isset($error)) echo "<div class='message error'>$error</div>"; ?>

    <!-- Add Slide Form -->
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Slide Title" required>
        <input type="file" name="image" accept="image/*" required>
        <button type="submit" name="add_slide">Add Slide</button>
    </form>

    <!-- Slide Table -->
    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Image</th>
            <th>Action</th>
        </tr>
        <?php while($slide = mysqli_fetch_assoc($slides)) { ?>
            <tr>
                <td><?php echo $slide['id']; ?></td>
                <td><?php echo htmlspecialchars($slide['title']); ?></td>
                <td><img src="uploads/<?php echo $slide['image']; ?>" alt="Slide"></td>
                <td>
                    <a href="?delete=<?php echo $slide['id']; ?>" class="delete" onclick="return confirm('Are you sure?');">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>
