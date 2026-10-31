<?php

$conn = new mysqli("localhost", "root", "", "fruityandveggies");

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

?>