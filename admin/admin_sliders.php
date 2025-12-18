<?php
session_start();
include "../db/config.php";

/* ===================== UPLOADS FOLDER ===================== */
$upload_dir = __DIR__ . "/uploads/";
if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

/* ===================== ADD SLIDE ===================== */
if (isset($_POST['upload'])) {
    $image = time() . "_" . $_FILES['image']['name'];
    $target = $upload_dir . $image;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $heading   = mysqli_real_escape_string($conn, $_POST['heading']);
        $paragraph = mysqli_real_escape_string($conn, $_POST['paragraph']);
        $btn_text  = mysqli_real_escape_string($conn, $_POST['btn_text']);
        $btn_link  = mysqli_real_escape_string($conn, $_POST['btn_link']);

        $conn->query("INSERT INTO slider_images 
            (image, heading, paragraph, btn_text, btn_link)
            VALUES ('$image','$heading','$paragraph','$btn_text','$btn_link')");
    }

    header("Location: admin_sliders.php");
    exit();
}

/* ===================== DELETE SLIDE ===================== */
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $res = $conn->query("SELECT image FROM slider_images WHERE id=$id")->fetch_assoc();

    if ($res && file_exists($upload_dir . $res['image'])) {
        unlink($upload_dir . $res['image']);
    }

    $conn->query("DELETE FROM slider_images WHERE id=$id");
    header("Location: admin_sliders.php");
    exit();
}

/* ===================== FETCH EDIT DATA ===================== */
$edit = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $edit = $conn->query("SELECT * FROM slider_images WHERE id=$id")->fetch_assoc();
}

/* ===================== UPDATE SLIDE ===================== */
if (isset($_POST['update'])) {
    $id        = intval($_POST['id']);
    $heading   = mysqli_real_escape_string($conn, $_POST['heading']);
    $paragraph = mysqli_real_escape_string($conn, $_POST['paragraph']);
    $btn_text  = mysqli_real_escape_string($conn, $_POST['btn_text']);
    $btn_link  = mysqli_real_escape_string($conn, $_POST['btn_link']);

    if (!empty($_FILES['image']['name'])) {
        $old = $conn->query("SELECT image FROM slider_images WHERE id=$id")->fetch_assoc();
        if ($old && file_exists($upload_dir . $old['image'])) {
            unlink($upload_dir . $old['image']);
        }

        $image = time() . "_" . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $image);

        $conn->query("UPDATE slider_images SET
            image='$image',
            heading='$heading',
            paragraph='$paragraph',
            btn_text='$btn_text',
            btn_link='$btn_link'
            WHERE id=$id");
    } else {
        $conn->query("UPDATE slider_images SET
            heading='$heading',
            paragraph='$paragraph',
            btn_text='$btn_text',
            btn_link='$btn_link'
            WHERE id=$id");
    }

    header("Location: admin_sliders.php");
    exit();
}

/* ===================== FETCH ALL SLIDES ===================== */
$slides = $conn->query("SELECT * FROM slider_images ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
<title>Slider Admin</title>
<style>
body{font-family:Arial;background:#f3f3f3;padding:20px}
.container{width:90%;margin:auto}
h2{text-align:center}
form,table{background:#fff;padding:20px;border-radius:10px;margin-bottom:25px}
input,textarea,button{width:100%;padding:10px;margin-top:10px;border-radius:5px;border:1px solid #aaa}
button{background:#1f2937;color:#fff;border:none}
table{width:100%;border-collapse:collapse}
th,td{padding:10px;text-align:center;border-bottom:1px solid #ddd}
th{background:#1f2937;color:#fff}
img{width:120px;height:60px;object-fit:cover;border-radius:5px}
a.button{padding:6px 12px;background:#1f2937;color:#fff;border-radius:5px;text-decoration:none}
a.delete{background:red}
a.cancel{background:#6b7280}
</style>
</head>

<body>

<?php include "navbar.php"; ?>

<div class="container">

<h2>🎞 Slider Manager</h2>

<form method="POST" enctype="multipart/form-data">
<?php if ($edit): ?>
    <input type="hidden" name="id" value="<?php echo $edit['id']; ?>">
    <input type="file" name="image">
    <input type="text" name="heading" value="<?php echo $edit['heading']; ?>">
    <textarea name="paragraph"><?php echo $edit['paragraph']; ?></textarea>
    <input type="text" name="btn_text" value="<?php echo $edit['btn_text']; ?>">
    <input type="text" name="btn_link" value="<?php echo $edit['btn_link']; ?>">
    <button name="update">Update Slide</button>
    <a href="admin_sliders.php" class="button cancel">Cancel</a>
<?php else: ?>
    <input type="file" name="image" required>
    <input type="text" name="heading">
    <textarea name="paragraph"></textarea>
    <input type="text" name="btn_text">
    <input type="text" name="btn_link">
    <button name="upload">Upload Slide</button>
<?php endif; ?>
</form>

<table>
<tr>
<th>ID</th><th>Image</th><th>Heading</th><th>Paragraph</th><th>Button</th><th>Link</th><th>Action</th>
</tr>

<?php while ($row = $slides->fetch_assoc()): ?>
<tr>
<td><?php echo $row['id']; ?></td>
<td><img src="uploads/<?php echo $row['image']; ?>"></td>
<td><?php echo $row['heading']; ?></td>
<td><?php echo $row['paragraph']; ?></td>
<td><?php echo $row['btn_text']; ?></td>
<td><?php echo $row['btn_link']; ?></td>
<td>
    <a class="button" href="?edit=<?php echo $row['id']; ?>">Edit</a>
    <a class="button delete" href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete slide?')">Delete</a>
</td>
</tr>
<?php endwhile; ?>
</table>

<a href="dashboard.php"><button>Back Home</button></a>

</div>
</body>
</html>
