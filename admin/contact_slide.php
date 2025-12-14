<?php
session_start();
include "../db/config.php";

$msg = "";
$error = "";

/* ===================== ADD SLIDE ===================== */
if (isset($_POST['add_slide'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);

    if (!empty($_FILES['image']['name'])) {
        $filename = time() . "_" . $_FILES['image']['name'];
        $target = "uploads/" . $filename;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            mysqli_query($conn, "INSERT INTO contact_slides (title, image) VALUES ('$title','$filename')");
            $msg = "Slide added successfully 🌱";
        } else {
            $error = "Image upload failed!";
        }
    } else {
        $error = "Please select an image!";
    }
}

/* ===================== DELETE SLIDE ===================== */
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $slide = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM contact_slides WHERE id=$id"));

    if ($slide) {
        if (file_exists("uploads/" . $slide['image'])) {
            unlink("uploads/" . $slide['image']);
        }
        mysqli_query($conn, "DELETE FROM contact_slides WHERE id=$id");
        header("Location: contact_slide.php");
        exit();
    }
}

/* ===================== FETCH EDIT DATA ===================== */
$editData = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $editData = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM contact_slides WHERE id=$id"));
}

/* ===================== UPDATE SLIDE ===================== */
if (isset($_POST['update_slide'])) {
    $id = intval($_POST['id']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);

    if (!empty($_FILES['image']['name'])) {
        $old = mysqli_fetch_assoc(mysqli_query($conn, "SELECT image FROM contact_slides WHERE id=$id"));
        if ($old && file_exists("uploads/" . $old['image'])) {
            unlink("uploads/" . $old['image']);
        }

        $filename = time() . "_" . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $filename);

        mysqli_query($conn, "UPDATE contact_slides SET title='$title', image='$filename' WHERE id=$id");
    } else {
        mysqli_query($conn, "UPDATE contact_slides SET title='$title' WHERE id=$id");
    }

    header("Location: contact_slide.php");
    exit();
}

/* ===================== FETCH SLIDES ===================== */
$slides = mysqli_query($conn, "SELECT * FROM contact_slides ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Contact Slides</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body{font-family:Arial;background:#f4f4f4;margin:0}
.container{max-width:1000px;margin:40px auto;padding:20px}
h2{margin-bottom:20px}
form{background:#fff;padding:20px;border-radius:10px;margin-bottom:30px;box-shadow:0 5px 15px rgba(0,0,0,.1)}
input[type=text],input[type=file]{width:100%;padding:10px;margin-bottom:10px;border:1px solid #ccc;border-radius:5px}
button{padding:10px 20px;border:none;border-radius:5px;cursor:pointer}
.add{background:#007bff;color:#fff}
.update{background:#28a745;color:#fff}
.cancel{background:#6c757d;color:#fff;text-decoration:none;padding:10px 20px;border-radius:5px}
table{width:100%;border-collapse:collapse;background:#fff;border-radius:10px;overflow:hidden}
th,td{padding:12px;border-bottom:1px solid #ddd}
th{background:#007bff;color:#fff}
tr:hover{background:#f1f1f1}
img{max-width:120px;border-radius:5px}
.action a{margin-right:10px;text-decoration:none}
.edit{color:#28a745}
.delete{color:red}
.message{padding:10px;margin-bottom:15px;border-radius:5px}
.success{background:#d4edda;color:#155724}
.error{background:#f8d7da;color:#721c24}
</style>
</head>

<body>
<div class="container">

<h2>🌄 Contact Page Slides</h2>

<?php if($msg) echo "<div class='message success'>$msg</div>"; ?>
<?php if($error) echo "<div class='message error'>$error</div>"; ?>

<!-- ===================== ADD / EDIT FORM ===================== -->
<form method="POST" enctype="multipart/form-data">
<?php if ($editData) { ?>
    <input type="hidden" name="id" value="<?php echo $editData['id']; ?>">
    <input type="text" name="title" value="<?php echo htmlspecialchars($editData['title']); ?>" required>
    <input type="file" name="image">
    <button type="submit" name="update_slide" class="update">Update Slide</button>
    <a href="contact_slide.php" class="cancel">Cancel</a>
<?php } else { ?>
    <input type="text" name="title" placeholder="Slide Title" required>
    <input type="file" name="image" required>
    <button type="submit" name="add_slide" class="add">Add Slide</button>
<?php } ?>
</form>

<!-- ===================== SLIDE TABLE ===================== -->
<table>
<tr>
    <th>ID</th>
    <th>Title</th>
    <th>Image</th>
    <th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($slides)) { ?>
<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo htmlspecialchars($row['title']); ?></td>
    <td><img src="uploads/<?php echo $row['image']; ?>"></td>
    <td class="action">
        <a href="?edit=<?php echo $row['id']; ?>" class="edit">Edit</a>
        <a href="?delete=<?php echo $row['id']; ?>" class="delete" onclick="return confirm('Delete this slide?');">Delete</a>
    </td>
</tr>
<?php } ?>

</table>


</div>
<a href="dashboard.php"><button >Back To Home</button></a>
<style>
    a button{
        background-color: red;
    }
</style>
</body>
</html>
