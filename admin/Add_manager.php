<?php
session_start();
include "navbar.php";
include "../db/config.php";

/* ================= ADD MANAGER ================= */
if(isset($_POST['add_manager'])){
    $consultancy = mysqli_real_escape_string($conn, $_POST['consultancy']);
    $name        = mysqli_real_escape_string($conn, $_POST['name']);
    $years       = intval($_POST['years']);
    $students    = intval($_POST['students']);
    $msg         = mysqli_real_escape_string($conn, $_POST['msg']);

    $image = time() . "_" . $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], "uploads/".$image);

    $conn->query("
        INSERT INTO about_manager
        (consultancy_name, manager_name, manager_image, manager_message, years_active, students_count)
        VALUES
        ('$consultancy','$name','$image','$msg','$years','$students')
    ");

    header("Location: Add_manager.php");
    exit();
}

/* ================= DELETE MANAGER ================= */
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);

    $old = $conn->query("SELECT manager_image FROM about_manager WHERE id=$id")->fetch_assoc();
    if($old && file_exists("uploads/".$old['manager_image'])){
        unlink("uploads/".$old['manager_image']);
    }

    $conn->query("DELETE FROM about_manager WHERE id=$id");
    header("Location: Add_manager.php");
    exit();
}

/* ================= FETCH EDIT DATA ================= */
$edit = null;
if(isset($_GET['edit'])){
    $id = intval($_GET['edit']);
    $edit = $conn->query("SELECT * FROM about_manager WHERE id=$id")->fetch_assoc();
}

/* ================= UPDATE MANAGER ================= */
if(isset($_POST['update_manager'])){
    $id          = intval($_POST['id']);
    $consultancy = mysqli_real_escape_string($conn, $_POST['consultancy']);
    $name        = mysqli_real_escape_string($conn, $_POST['name']);
    $years       = intval($_POST['years']);
    $students    = intval($_POST['students']);
    $msg         = mysqli_real_escape_string($conn, $_POST['msg']);

    if(!empty($_FILES['image']['name'])){
        $old = $conn->query("SELECT manager_image FROM about_manager WHERE id=$id")->fetch_assoc();
        if($old && file_exists("uploads/".$old['manager_image'])){
            unlink("uploads/".$old['manager_image']);
        }

        $image = time() . "_" . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/".$image);

        $conn->query("
            UPDATE about_manager SET
            consultancy_name='$consultancy',
            manager_name='$name',
            manager_image='$image',
            manager_message='$msg',
            years_active='$years',
            students_count='$students'
            WHERE id=$id
        ");
    } else {
        $conn->query("
            UPDATE about_manager SET
            consultancy_name='$consultancy',
            manager_name='$name',
            manager_message='$msg',
            years_active='$years',
            students_count='$students'
            WHERE id=$id
        ");
    }

    header("Location: Add_manager.php");
    exit();
}

/* ================= FETCH ALL ================= */
$managers = $conn->query("SELECT * FROM about_manager ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>About Manager Manager</title>
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
img{width:120px;height:120px;object-fit:cover;border-radius:50%}
a.button{padding:6px 12px;background:#1f2937;color:white;border-radius:5px;text-decoration:none;margin:2px;display:inline-block}
a.delete{background:red}
a.cancel{background:#6b7280}
</style>
</head>

<body>
<div class="container">

<h2>👔 About Manager Section</h2>

<!-- ================= ADD / EDIT FORM ================= -->
<form method="POST" enctype="multipart/form-data">
<?php if($edit): ?>
    <input type="hidden" name="id" value="<?php echo $edit['id']; ?>">

    <input type="text" name="consultancy" value="<?php echo $edit['consultancy_name']; ?>" placeholder="Consultancy Name" required>

    <input type="text" name="name" value="<?php echo $edit['manager_name']; ?>" placeholder="Manager Name" required>

    <input type="number" name="years" value="<?php echo $edit['years_active']; ?>" placeholder="Years of Experience" required>

    <input type="number" name="students" value="<?php echo $edit['students_count']; ?>" placeholder="Students Served" required>

    <input type="file" name="image">
    <small>Leave empty to keep old image</small>

    <textarea name="msg" rows="4" required><?php echo $edit['manager_message']; ?></textarea>

    <button name="update_manager">Update Manager</button>
    <a href="Add_manager.php" class="button cancel">Cancel</a>

<?php else: ?>
    <input type="text" name="consultancy" placeholder="Consultancy Name" required>

    <input type="text" name="name" placeholder="Manager Name" required>

    <input type="number" name="years" placeholder="Years of Experience" required>

    <input type="number" name="students" placeholder="Students Served" required>

    <input type="file" name="image" required>

    <textarea name="msg" placeholder="Manager Message" required></textarea>

    <button name="add_manager">Add Manager</button>
<?php endif; ?>
</form>

<a href="dashboard.php"><button>Back Home</button></a>

<!-- ================= TABLE ================= -->
<h2>All Managers</h2>
<table>
<tr>
<th>ID</th>
<th>Image</th>
<th>Name</th>
<th>Consultancy</th>
<th>Years</th>
<th>Students</th>
<th>Actions</th>
</tr>

<?php while($row=$managers->fetch_assoc()): ?>
<tr>
<td><?php echo $row['id']; ?></td>
<td><img src="uploads/<?php echo $row['manager_image']; ?>"></td>
<td><?php echo $row['manager_name']; ?></td>
<td><?php echo $row['consultancy_name']; ?></td>
<td><?php echo $row['years_active']; ?></td>
<td><?php echo $row['students_count']; ?></td>
<td>
    <a class="button" href="?edit=<?php echo $row['id']; ?>">Edit</a>
    <a class="button delete" href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete this manager?')">Delete</a>
</td>
</tr>
<?php endwhile; ?>
</table>

</div>
</body>
</html>
