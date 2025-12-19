<?php

include "navbar.php";
include "../db/config.php";

$error = $success = "";
$editing_id = 0;
$editing_data = null;

if (isset($_POST['update'])) {
    $id = intval($_POST['slide_id']);
    $header = $_POST['header_text'];
    $paragraph = $_POST['paragraph_text'];

    if (!empty($_FILES['slide_image']['name'])) {
        $file = $_FILES['slide_image'];
        $filename = time() . '_' . basename($file['name']);
        $target_file = "uploads/" . $filename;
        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            $old = mysqli_fetch_assoc(mysqli_query($conn, "SELECT image FROM login_slide_images WHERE id=$id"));
            if ($old && file_exists("uploads/".$old['image'])) unlink("uploads/".$old['image']);
        } else {
            $error = "Image upload failed!";
        }
    } else {
        $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT image FROM login_slide_images WHERE id=$id"));
        $filename = $row['image'];
    }

    $stmt = mysqli_prepare($conn, "UPDATE login_slide_images SET image=?, header_text=?, paragraph_text=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "sssi", $filename, $header, $paragraph, $id);
    if (mysqli_stmt_execute($stmt)) $success = "Slide updated successfully!";
    else $error = "Database error!";
}

// Handle New Upload
if (isset($_POST['upload'])) {
    $file = $_FILES['slide_image'];
    $header = $_POST['header_text'];
    $paragraph = $_POST['paragraph_text'];
    $filename = time() . '_' . basename($file['name']);
    $target_file = "uploads/" . $filename;

    if (move_uploaded_file($file['tmp_name'], $target_file)) {
        $stmt = mysqli_prepare($conn, "INSERT INTO login_slide_images (image, header_text, paragraph_text) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sss", $filename, $header, $paragraph);
        if (mysqli_stmt_execute($stmt)) $success = "Slide uploaded successfully!";
        else $error = "Database error!";
    } else {
        $error = "Upload failed!";
    }
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT image FROM login_slide_images WHERE id=$id"));
    if ($row && file_exists("uploads/".$row['image'])) {
        unlink("uploads/".$row['image']);
        mysqli_query($conn, "DELETE FROM login_slide_images WHERE id=$id");
        $success = "Slide deleted successfully!";
    }
}

// Handle Edit Click
if (isset($_GET['edit'])) {
    $editing_id = intval($_GET['edit']);
    $editing_data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM login_slide_images WHERE id=$editing_id"));
}

// Fetch all slides
$slides = mysqli_query($conn, "SELECT * FROM login_slide_images ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login Slider</title>
    <style>
        body{font-family:Arial; padding:20px; background:#f4f4f4;}
        h2,h3{color:#1c037e;}
        .slide-img{width:150px; margin:5px; display:block; border-radius:4px;}
        .form-container{margin-bottom:20px; padding:15px; border:1px solid #ccc; width:400px; background:#fff; border-radius:5px;}
        .form-container input[type=text], .form-container textarea, .form-container input[type=file]{width:100%; padding:8px; margin:5px 0; border-radius:4px; border:1px solid #ccc;}
        .form-container textarea{height:70px;}
        .form-container button{padding:8px 12px; background:#ff6600; color:#fff; border:none; border-radius:4px; cursor:pointer;}
        .form-container button:hover{background:#e04300;}
        .message{color:green;}
        .error{color:red;}
        table{width:100%; border-collapse: collapse; background:#fff; border-radius:5px; overflow:hidden;}
        th, td{padding:10px; border:1px solid #ccc; text-align:center;}
        a.button{padding:5px 10px; background:#ff6600; color:#fff; text-decoration:none; border-radius:4px;}
        a.button.delete{background:#e04300;}
        a.button.cancel{background:#555;}
    </style>
</head>
<body>
<h2>Login Slider Management</h2>

<?php if($error) echo "<p class='error'>$error</p>"; ?>
<?php if($success) echo "<p class='message'>$success</p>"; ?>

<div class="form-container">
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="slide_image" <?php echo $editing_data ? "" : "required"; ?>><br>
        <input type="text" name="header_text" placeholder="Header Text" value="<?php echo $editing_data ? htmlspecialchars($editing_data['header_text']) : ""; ?>"><br>
        <textarea name="paragraph_text" placeholder="Paragraph Text"><?php echo $editing_data ? htmlspecialchars($editing_data['paragraph_text']) : ""; ?></textarea><br>
        <?php if($editing_data): ?>
            <input type="hidden" name="slide_id" value="<?php echo $editing_id; ?>">
            <button type="submit" name="update">Update Slide</button>
            <a href="admin_login_slide.php" class="button cancel">Cancel</a>
        <?php else: ?>
            <button type="submit" name="upload">Upload Slide</button>
        <?php endif; ?>
    </form>
    <br>
    <br>
    <a href="dashboard.php"><button>Back Home</button></a>
</div>

<h3>Uploaded Slides</h3>
<table>
    <tr>
        <th>Image</th>
        <th>Header</th>
        <th>Paragraph</th>
        <th>Actions</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($slides)): ?>
    <tr>
        <td><img src="uploads/<?php echo $row['image']; ?>" class="slide-img"></td>
        <td><?php echo htmlspecialchars($row['header_text']); ?></td>
        <td><?php echo htmlspecialchars($row['paragraph_text']); ?></td>
        <td>
            <!-- Edit & Delete buttons -->
            <a href="?edit=<?php echo $row['id']; ?>" class="button">Edit</a>
            <a href="?delete=<?php echo $row['id']; ?>" class="button delete" onclick="return confirm('Are you sure you want to delete this slide?')">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>

</table>
</body>
</html>
