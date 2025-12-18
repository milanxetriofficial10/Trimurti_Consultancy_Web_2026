<?php
session_start();
include "../db/config.php";

/* ===================== ADD COURSE ===================== */
if (isset($_POST['add_course'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $button_text = mysqli_real_escape_string($conn, $_POST['button_text']);
    $button_link = mysqli_real_escape_string($conn, $_POST['button_link']);
    $discount = intval($_POST['discount']);

    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];
    move_uploaded_file($tmp, "uploads/" . $image);

    $conn->query("INSERT INTO courses 
        (title, description, image, button_text, button_link, discount)
        VALUES 
        ('$title','$description','$image','$button_text','$button_link',$discount)");
}

/* ===================== DELETE COURSE ===================== */
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    $res = $conn->query("SELECT image FROM courses WHERE id=$id")->fetch_assoc();
    if ($res && file_exists("uploads/" . $res['image'])) {
        unlink("uploads/" . $res['image']);
    }

    $conn->query("DELETE FROM courses WHERE id=$id");
    header("Location: admin_course.php");
    exit();
}

/* ===================== FETCH EDIT DATA ===================== */
$edit = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $edit = $conn->query("SELECT * FROM courses WHERE id=$id")->fetch_assoc();
}

/* ===================== UPDATE COURSE ===================== */
if (isset($_POST['update_course'])) {
    $id = intval($_POST['id']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $button_text = mysqli_real_escape_string($conn, $_POST['button_text']);
    $button_link = mysqli_real_escape_string($conn, $_POST['button_link']);
    $discount = intval($_POST['discount']);

    if (!empty($_FILES['image']['name'])) {
        $old = $conn->query("SELECT image FROM courses WHERE id=$id")->fetch_assoc();
        if ($old && file_exists("uploads/" . $old['image'])) {
            unlink("uploads/" . $old['image']);
        }

        $image = time() . "_" . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $image);

        $conn->query("UPDATE courses SET
            title='$title',
            description='$description',
            image='$image',
            button_text='$button_text',
            button_link='$button_link',
            discount=$discount
            WHERE id=$id");
    } else {
        $conn->query("UPDATE courses SET
            title='$title',
            description='$description',
            button_text='$button_text',
            button_link='$button_link',
            discount=$discount
            WHERE id=$id");
    }

    header("Location: admin_course.php");
    exit();
}

/* ===================== FETCH ALL COURSES ===================== */
$courses = $conn->query("SELECT * FROM courses ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Courses</title>
<style>
body{font-family:Arial;background:#f3f3f3;padding:20px}
.container{width:90%;margin:auto}
h2{text-align:center}
form,table{background:white;padding:20px;border-radius:10px;margin-bottom:20px}
input,textarea,button{width:100%;padding:10px;margin-top:10px;border-radius:5px;border:1px solid #aaa}
button{background:#1f2937;color:white;border:none;cursor:pointer}
table{width:100%;border-collapse:collapse}
th,td{padding:10px;text-align:center;border-bottom:1px solid #ddd}
th{background:#1f2937;color:white}
img{width:120px;height:80px;object-fit:cover;border-radius:5px}
a.button{padding:6px 12px;background:#1f2937;color:white;border-radius:5px;text-decoration:none}
a.delete{background:red}
a.cancel{background:#6b7280}
.badge{background:#dc2626;color:white;padding:4px 8px;border-radius:20px;font-size:12px}
</style>
</head>

<body>

<?php include "navbar.php"; ?>

<div class="container">
<h2>📘 Course Manager</h2>

<form method="POST" enctype="multipart/form-data">
<?php if ($edit): ?>
    <input type="hidden" name="id" value="<?php echo $edit['id']; ?>">

    <label>Course Image (optional):</label>
    <input type="file" name="image">

    <label>Title:</label>
    <input type="text" name="title" value="<?php echo $edit['title']; ?>" required>

    <label>Description:</label>
    <textarea name="description" rows="4"><?php echo $edit['description']; ?></textarea>

    <label>Discount (% OFF):</label>
    <input type="number" name="discount" min="0" max="100" value="<?php echo $edit['discount']; ?>">

    <label>Button Text:</label>
    <input type="text" name="button_text" value="<?php echo $edit['button_text']; ?>">

    <label>Button Link:</label>
    <input type="text" name="button_link" value="<?php echo $edit['button_link']; ?>">

    <button name="update_course">Update Course</button>
    <a href="admin_course.php" class="button cancel">Cancel</a>
<?php else: ?>
    <label>Course Image:</label>
    <input type="file" name="image" required>

    <label>Title:</label>
    <input type="text" name="title" required>

    <label>Description:</label>
    <textarea name="description" rows="4"></textarea>

    <label>Discount (% OFF):</label>
    <input type="number" name="discount" min="0" max="100" value="0">

    <label>Button Text:</label>
    <input type="text" name="button_text">

    <label>Button Link:</label>
    <input type="text" name="button_link">

    <button name="add_course">Add Course</button>
<?php endif; ?>
</form>

<h2>All Courses</h2>
<table>
<tr>
<th>ID</th><th>Image</th><th>Title</th><th>Description</th><th>Discount</th><th>Button</th><th>Link</th><th>Actions</th>
</tr>

<?php while($row = $courses->fetch_assoc()): ?>
<tr>
<td><?php echo $row['id']; ?></td>
<td><img src="uploads/<?php echo $row['image']; ?>"></td>
<td><?php echo $row['title']; ?></td>
<td><?php echo $row['description']; ?></td>
<td>
<?php if($row['discount'] > 0): ?>
<span class="badge"><?php echo $row['discount']; ?>% OFF</span>
<?php else: ?>—<?php endif; ?>
</td>
<td><?php echo $row['button_text']; ?></td>
<td><?php echo $row['button_link']; ?></td>
<td>
<a class="button" href="?edit=<?php echo $row['id']; ?>">Edit</a>
<a class="button delete" href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete course?')">Delete</a>
</td>
</tr>
<?php endwhile; ?>
</table>

<a href="dashboard.php"><button>Back Home</button></a>
</div>

</body>
</html>
