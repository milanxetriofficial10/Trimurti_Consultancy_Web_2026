<?php
session_start();
include "../db/config.php";

/* ================= ADD SLIDER ================= */
if(isset($_POST['add_slider'])){
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $btn   = mysqli_real_escape_string($conn, $_POST['btn']);
    $link  = mysqli_real_escape_string($conn, $_POST['link']);

    $image = time() . "_" . $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], "uploads/".$image);

    $conn->query("INSERT INTO about_slider (title,image,button_text,button_link)
                  VALUES ('$title','$image','$btn','$link')");
    header("Location: about_slider.php");
    exit();
}

/* ================= DELETE SLIDER ================= */
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);

    $old = $conn->query("SELECT image FROM about_slider WHERE id=$id")->fetch_assoc();
    if($old && file_exists("uploads/".$old['image'])){
        unlink("uploads/".$old['image']);
    }

    $conn->query("DELETE FROM about_slider WHERE id=$id");
    header("Location: about_slider.php");
    exit();
}

/* ================= FETCH EDIT DATA ================= */
$edit = null;
if(isset($_GET['edit'])){
    $id = intval($_GET['edit']);
    $edit = $conn->query("SELECT * FROM about_slider WHERE id=$id")->fetch_assoc();
}

/* ================= UPDATE SLIDER ================= */
if(isset($_POST['update_slider'])){
    $id    = intval($_POST['id']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $btn   = mysqli_real_escape_string($conn, $_POST['btn']);
    $link  = mysqli_real_escape_string($conn, $_POST['link']);

    if(!empty($_FILES['image']['name'])){
        $old = $conn->query("SELECT image FROM about_slider WHERE id=$id")->fetch_assoc();
        if($old && file_exists("uploads/".$old['image'])){
            unlink("uploads/".$old['image']);
        }

        $image = time() . "_" . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/".$image);

        $conn->query("UPDATE about_slider SET
            title='$title',
            image='$image',
            button_text='$btn',
            button_link='$link'
            WHERE id=$id");
    } else {
        $conn->query("UPDATE about_slider SET
            title='$title',
            button_text='$btn',
            button_link='$link'
            WHERE id=$id");
    }

    header("Location: about_slider.php");
    exit();
}

/* ================= FETCH ALL ================= */
$sliders = $conn->query("SELECT * FROM about_slider ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>About Slider Manager</title>
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
img{width:120px;height:70px;object-fit:cover;border-radius:5px}
a.button{padding:6px 12px;background:#1f2937;color:white;border-radius:5px;text-decoration:none;margin:2px;display:inline-block}
a.delete{background:red}
a.cancel{background:#6b7280}
</style>
</head>

<body>
<div class="container">

<h2>🧩 About Slider Manager</h2>

<!-- ================= ADD / EDIT FORM ================= -->
<form method="POST" enctype="multipart/form-data">
<?php if($edit): ?>
    <input type="hidden" name="id" value="<?php echo $edit['id']; ?>">

    <label>Slider Title:</label>
    <input type="text" name="title" value="<?php echo $edit['title']; ?>" required>

    <label>Change Image (optional):</label>
    <input type="file" name="image">

    <label>Button Text:</label>
    <input type="text" name="btn" value="<?php echo $edit['button_text']; ?>">

    <label>Button Link:</label>
    <input type="text" name="link" value="<?php echo $edit['button_link']; ?>">

    <button name="update_slider">Update Slider</button>
    <a href="about_slider.php" class="button cancel">Cancel</a>

<?php else: ?>
    <label>Slider Title:</label>
    <input type="text" name="title">

    <label>Image:</label>
    <input type="file" name="image" required>

    <label>Button Text:</label>
    <input type="text" name="btn">

    <label>Button Link:</label>
    <input type="text" name="link">

    <button name="add_slider">Add Slider</button>
<?php endif; ?>
</form>
<a href="dashboard.php"><button>Back Home</button></a>

<!-- ================= TABLE ================= -->
<h2>All About Sliders</h2>
<table>
<tr>
<th>ID</th>
<th>Image</th>
<th>Title</th>
<th>Button</th>
<th>Link</th>
<th>Actions</th>
</tr>

<?php while($row = $sliders->fetch_assoc()): ?>
<tr>
<td><?php echo $row['id']; ?></td>
<td><img src="uploads/<?php echo $row['image']; ?>"></td>
<td><?php echo $row['title']; ?></td>
<td><?php echo $row['button_text']; ?></td>
<td><?php echo $row['button_link']; ?></td>
<td>
    <a class="button" href="?edit=<?php echo $row['id']; ?>">Edit</a>
    <a class="button delete" href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete this slider?')">Delete</a>
</td>
</tr>
<?php endwhile; ?>
</table>

</div>
</body>
</html>
