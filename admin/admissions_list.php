<?php
include "../db/config.php";

$result = $conn->query("SELECT * FROM admissions ORDER BY id DESC");
?>

<style>
.table-box{
    max-width:1200px;
    margin:30px auto;
    background:#fff;
    padding:20px;
    border-radius:10px;
}
table{
    width:100%;
    border-collapse:collapse;
}
th,td{
    padding:10px;
    border-bottom:1px solid #ddd;
    font-size:14px;
    text-align:left;
}
th{
    background:#243b55;
    color:#fff;
}
img{
    width:60px;
    border-radius:6px;
}
.add-btn{
    background:#243b55;
    color:#fff;
    padding:10px 16px;
    text-decoration:none;
    border-radius:6px;
    display:inline-block;
    margin-bottom:15px;
}
</style>

<div class="table-box">


<table>
<thead>
<tr>
    <th>Photo</th>
    <th>Name</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Course</th>
    <th>Qualification</th>
    <th>National ID</th>
</tr>
</thead>

<tbody>
<?php while($row = $result->fetch_assoc()): ?>
<tr>
 <td>
<?php if(!empty($row['profile_pic']) && file_exists("uploads/profile/".$row['profile_pic'])): ?>
    <img src="uploads/profile/<?php echo $row['profile_pic']; ?>" width="60">
<?php else: ?>
    No Image
<?php endif; ?>
</td>

    <td><?php echo $row['first_name']." ".$row['last_name']; ?></td>
    <td><?php echo $row['email']; ?></td>
    <td><?php echo $row['phone']; ?></td>
    <td><?php echo $row['course']; ?></td>
    <td><?php echo $row['qualification']; ?></td>
    <td>
        <a href="../uploads/documents/<?php echo $row['national_card']; ?>" target="_blank">
            View
        </a>
    </td>
</tr>
<?php endwhile; ?>
</tbody>
</table>

<a href="dashboard.php"><button>Back Home</button></a>
<style>
    a button{
        background-color: red;
        padding: 10px 10px;
    }
</style>
</div>
