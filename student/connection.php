<?php

$servername = 'localhost';  
$user = 'root';
$password = '';
$db = 'student_database';

// create database connection

$conn = mysqli_connect($servername, $user, $password, $db);

if (mysqli_connect_error()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error(); 
    exit();  
}

?>
