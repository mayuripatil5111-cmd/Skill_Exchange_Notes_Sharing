<?php
$conn = mysqli_connect("localhost", "root", "", "notes");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
