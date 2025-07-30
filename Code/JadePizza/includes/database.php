<?php
/*------------------------------------------------------------------
/* File: database.php
/* Description: Establishes connection to the MySQL database
/*------------------------------------------------------------------
/* Author: Alyssa Cabana
/*------------------------------------------------------------------*/
$servername = "localhost";
$username = "root";
$password = ""; // Default for XAMPP (no password)
$dbname = "jade_pizza"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>