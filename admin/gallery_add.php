<?php
session_start();
include "../db/config.php";

/* ================= ADD IMAGE ================= */
if (isset($_POST['add_gallery'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);

    $image = time() . "_" . $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $image);

    $conn->query("INSERT INTO gallery (title, image) VALUES ('$title','$image')");
    header("Location: gallery_add.php");
    exit();
}

/* ================= DELETE IMAGE ================= */
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    $old = $conn->query("SELECT image FROM gallery WHERE id=$id")->fetch_assoc();
    if ($old && file_exists("uploads/" . $old['image'])) {
        unlink("uploads/" . $old['image']);
    }

    $conn->query("DELETE FROM gallery WHERE id=$id");
    header("Location: gallery_add.php");
    exit();
}

/* ================= FETCH EDIT DATA ================= */
$edit = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $edit = $conn->query("SELECT * FROM gallery WHERE id=$id")->fetch_assoc();
}

/* ================= UPDATE IMAGE ================= */
if (isset($_POST['update_gallery'])) {
    $id    = intval($_POST['id']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);

    if (!empty($_FILES['image']['name'])) {
        $old = $conn->query("SELECT image FROM gallery WHERE id=$id")->fetch_assoc();
        if ($old && file_exists("uploads/" . $old['image'])) {
            unlink("uploads/" . $old['image']);
        }

        $image = time() . "_" . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $image);

        $conn->query("UPDATE gallery SET title='$title', image='$image' WHERE id=$id");
    } else {
        $conn->query("UPDATE gallery SET title='$title' WHERE id=$id");
    }

    header("Location: gallery_add.php");
    exit();
}

/* ================= FETCH ALL ================= */
$gallery = $conn->query("SELECT * FROM gallery ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
<title>Gallery Manager</title>
<style>
body{font-family:Arial;background:#f3f3f3;padding:20px}
.container{width:90%;margin:auto}
h2{text-align:center}
form,table{background:white;padding:20px;border-radius:10px;margin-bottom:20px}
input,button{width:100%;padding:10px;margin-top:10px;border-radius:5px;border:1px solid #aaa}
button{background:#1f2937;color:white;border:none;cursor:pointer}
table{width:100%;border-collapse:collapse}
th,td{padding:10px;text-align:center;border-bottom:1px solid #ddd}
th{background:#1f2937;color:white}
img{width:120px;height:80px;object-fit:cover;border-radius:5px}
a.button{padding:6px 12px;background:#1f2937;color:white;border-radius:5px;text-decoration:none;margin:2px;display:inline-block}
a.delete{background:red}
a.cancel{background:#6b7280}
</style>
</head>

<body>

<?php include "navbar.php"; ?>

<div class="container">

<h2>🖼 Gallery Manager</h2>

<form method="POST" enctype="multipart/form-data">
<?php if ($edit): ?>
    <input type="hidden" name="id" value="<?php echo $edit['id']; ?>">

    <label>Image Title:</label>
    <input type="text" name="title" value="<?php echo $edit['title']; ?>" required>

    <label>Change Image (optional):</label>
    <input type="file" name="image">

    <button name="update_gallery">Update Image</button>
    <a href="gallery_add.php" class="button cancel">Cancel</a>
<?php else: ?>
    <label>Image Title:</label>
    <input type="text" name="title" required>

    <label>Image:</label>
    <input type="file" name="image" required>

    <button name="add_gallery">Upload Image</button>
<?php endif; ?>
</form>

<a href="dashboard.php"><button>Back Home</button></a>

<h2>All Gallery Images</h2>
<table>
<tr>
<th>ID</th>
<th>Image</th>
<th>Title</th>
<th>Actions</th>
</tr>

<?php while ($row = $gallery->fetch_assoc()): ?>
<tr>
<td><?php echo $row['id']; ?></td>
<td><img src="uploads/<?php echo $row['image']; ?>"></td>
<td><?php echo $row['title']; ?></td>
<td>
    <a class="button" href="?edit=<?php echo $row['id']; ?>">Edit</a>
    <a class="button delete" href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete this image?')">Delete</a>
</td>
</tr>
<?php endwhile; ?>
</table>

</div>
</body>
</html>
