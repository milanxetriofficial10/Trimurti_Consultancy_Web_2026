<?php
session_start();
include "../db/config.php";

/* ================= ADD NEWS ================= */
if (isset($_POST['add_news'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $conn->query("INSERT INTO top_news (title) VALUES ('$title')");
    header("Location: top_news.php");
    exit();
}

/* ================= DELETE NEWS ================= */
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM top_news WHERE id=$id");
    header("Location: top_news.php");
    exit();
}

/* ================= FETCH EDIT DATA ================= */
$edit = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $edit = $conn->query("SELECT * FROM top_news WHERE id=$id")->fetch_assoc();
}

/* ================= UPDATE NEWS ================= */
if (isset($_POST['update_news'])) {
    $id    = intval($_POST['id']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);

    $conn->query("UPDATE top_news SET title='$title' WHERE id=$id");
    header("Location: top_news.php");
    exit();
}

/* ================= FETCH ALL NEWS ================= */
$news = $conn->query("SELECT * FROM top_news ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
<title>Manage Top News</title>
<style>
body{font-family:Arial;background:#f3f3f3;padding:20px}
.container{width:90%;margin:auto}
h2{text-align:center;margin-bottom:20px}
form,table{background:white;padding:20px;border-radius:10px;margin-bottom:20px}
input,button{width:100%;padding:10px;margin-top:10px;border-radius:5px;border:1px solid #aaa}
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

<h2>📰 Top News Manager</h2>

<form method="POST">
<?php if ($edit): ?>
    <input type="hidden" name="id" value="<?php echo $edit['id']; ?>">

    <label>News Title:</label>
    <input type="text" name="title" value="<?php echo $edit['title']; ?>" required>

    <button name="update_news">Update News</button>
    <a href="top_news.php" class="button cancel">Cancel</a>
<?php else: ?>
    <label>News Title:</label>
    <input type="text" name="title" required>

    <button name="add_news">Add News</button>
<?php endif; ?>
</form>

<h2>All Top News</h2>
<table>
<tr>
    <th>ID</th>
    <th>Title</th>
    <th>Actions</th>
</tr>

<?php while ($row = $news->fetch_assoc()): ?>
<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['title']; ?></td>
    <td>
        <a class="button" href="?edit=<?php echo $row['id']; ?>">Edit</a>
        <a class="button delete" href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete this news?')">Delete</a>
    </td>
</tr>
<?php endwhile; ?>
</table>

<a href="dashboard.php"><button>Back Home</button></a>

</div>
</body>
</html>
