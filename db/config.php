<?php
$host = "localhost";
$user = "root";
$pass = "Milan@1234";
$db   = "project_1_chabahil";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
