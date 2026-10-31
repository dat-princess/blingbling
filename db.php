<?php
$conn = mysqli_connect("localhost", "root", "", "formdb");

if (!$conn) {
    die("May mali: " . mysqli_connect_error());
}
?>