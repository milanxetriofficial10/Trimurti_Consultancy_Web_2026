<?php
session_start();
include "../db/config.php";

/* ================= ADD DESCRIPTION ================= */
if (isset($_POST['add_about'])) {
    $desc = mysqli_real_escape_string($conn, $_POST['desc']);
    $conn->query("INSERT INTO about_consultancy (description) VALUES ('$desc')");
    header("Location: add_about_file.php");
    exit();
}

/* ================= DELETE ================= */
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM about_consultancy WHERE id=$id");
    header("Location: add_about_file.php");
    exit();
}

/* ================= FETCH EDIT DATA ================= */
$edit = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $edit = $conn->query("SELECT * FROM about_consultancy WHERE id=$id")->fetch_assoc();
}

/* ================= UPDATE ================= */
if (isset($_POST['update_about'])) {
    $id   = intval($_POST['id']);
    $desc = mysqli_real_escape_string($conn, $_POST['desc']);

    $conn->query("UPDATE about_consultancy SET description='$desc' WHERE id=$id");
    header("Location: add_about_file.php");
    exit();
}

/* ================= FETCH ALL ================= */
$about = $conn->query("SELECT * FROM about_consultancy ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
<title>About Consultancy Manager</title>
<style>
body{font-family:Arial;background:#f3f3f3;padding:20px}
.container{width:90%;margin:auto}
h2{text-align:center}
form,table{background:white;padding:20px;border-radius:10px;margin-bottom:20px}
textarea,button{width:100%;padding:10px;margin-top:10px;border-radius:5px;border:1px solid #aaa}
button{background:#1f2937;color:white;border:none;cursor:pointer}
table{width:100%;border-collapse:collapse}
th,td{padding:10px;text-align:center;border-bottom:1px solid #ddd}
th{background:#1f2937;color:white}
a.button{padding:6px 12px;background:#1f2937;color:white;border-radius:5px;text-decoration:none;margin:2px;display:inline-block}
a.delete{background:red}
a.cancel{background:#6b7280}
</style>
</head>

<body>

<?php include "navbar.php"; ?>

<div class="container">

<h2>🏫 About Consultancy Manager</h2>

<form method="POST">
<?php if ($edit): ?>
    <input type="hidden" name="id" value="<?php echo $edit['id']; ?>">

    <label>Edit Description:</label>
    <textarea name="desc" rows="6" required><?php echo $edit['description']; ?></textarea>

    <button name="update_about">Update</button>
    <a href="add_about_file.php" class="button cancel">Cancel</a>
<?php else: ?>
    <label>Write About Consultancy:</label>
    <textarea name="desc" rows="6" placeholder="Write about Trimurti Educational Consultancy" required></textarea>

    <button name="add_about">Save</button>
<?php endif; ?>
</form>

<a href="dashboard.php"><button>Back Home</button></a>

<h2>All About Content</h2>
<table>
<tr>
<th>ID</th>
<th>Description</th>
<th>Actions</th>
</tr>

<?php while ($row = $about->fetch_assoc()): ?>
<tr>
<td><?php echo $row['id']; ?></td>
<td style="text-align:left"><?php echo nl2br($row['description']); ?></td>
<td>
    <a class="button" href="?edit=<?php echo $row['id']; ?>">Edit</a>
    <a class="button delete" href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete this content?')">Delete</a>
</td>
</tr>
<?php endwhile; ?>
</table>

</div>
</body>
</html>
