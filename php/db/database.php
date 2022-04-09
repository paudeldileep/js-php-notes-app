<!-- create database -->
<?php
// get connect.php
require_once '../connect.php';
if ($connection) {
    // create database
    $sql = "CREATE DATABASE notes_app";
    if (mysqli_query($connection, $sql)) {
        echo "Database created successfully";
    } else {
        echo "Error creating database: " . mysqli_error($connection);
    }
}
?>