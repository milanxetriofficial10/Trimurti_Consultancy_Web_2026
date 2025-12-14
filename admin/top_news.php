<?php
session_start();
include "../db/config.php";

// Add news
if(isset($_POST['add_news'])){
    $title = $_POST['title'];
    $link = $_POST['link'];
    $conn->query("INSERT INTO top_news (title, link) VALUES ('$title', '$link')");
}

// Delete news
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $conn->query("DELETE FROM top_news WHERE id=$id");
}

// Fetch all news
$news = $conn->query("SELECT * FROM top_news ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Top News</title>
<style>
body{font-family:Arial; background:#f3f3f3; padding:20px;}
.container{width:90%; margin:auto;}
h2{text-align:center; margin-bottom:20px;}
form, table{background:white; padding:20px; border-radius:10px; margin-bottom:20px;}
input, button{width:100%; padding:10px; margin-top:10px; border-radius:5px; border:1px solid #aaa;}
button{background:#1f2937; color:white; border:none;}
table{width:100%; border-collapse:collapse;}
th, td{padding:10px; text-align:center; border-bottom:1px solid #ddd;}
th{background:#1f2937; color:white;}
a.button{padding:6px 12px; background:#1f2937; color:white; border-radius:5px; text-decoration:none; margin:2px;}
a.button.delete{background:red;}
</style>
</head>
<body>

<div class="container">
<h2>Add Top News</h2>
<form method="POST">
    <label>News Title:</label>
    <input type="text" name="title" required>
    <label>Link (optional):</label>
    <input type="text" name="link">
    <button name="add_news">Add News</button>
</form>

<h2>All Top News</h2>
<table>
<tr><th>ID</th><th>Title</th><th>Link</th><th>Actions</th></tr>
<?php while($row=$news->fetch_assoc()): ?>
<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['title']; ?></td>
    <td><?php echo $row['link']; ?></td>
    <td>
        <a class="button delete" href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete?')">Delete</a>
    </td>
</tr>
<?php endwhile; ?>
</table>
</div>

</body>
</html>
