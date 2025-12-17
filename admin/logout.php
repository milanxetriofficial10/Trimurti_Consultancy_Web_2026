<?php
include "navbar.php";
include "config.php";
session_destroy();
header("Location: login.php");
exit;
?>
