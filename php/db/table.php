<!-- create table for userdata -->

<?php
require_once('../connect.php');
// select db
mysqli_select_db($connection, 'notes_app');

// table for users
// $query = "CREATE TABLE IF NOT EXISTS users (
//         id INT(6) AUTO_INCREMENT PRIMARY KEY,
//         user_name VARCHAR(30) NOT NULL,
//         user_roll INT(10) UNIQUE NOT NULL,
//         user_email VARCHAR(50) NOT NULL,
//         user_password VARCHAR(50) NOT NULL
//     )";

//table for storing users notes
$query = "CREATE TABLE IF NOT EXISTS notes (
        id INT(6) AUTO_INCREMENT PRIMARY KEY,
        user_id INT(6) NOT NULL,
        note_title VARCHAR(30) NOT NULL,
        note_content TEXT NOT NULL,
        note_date DATETIME NOT NULL,
        FOREIGN KEY (user_id) REFERENCES users(id)
    )";

if (mysqli_query($connection, $query)) {
    echo "Table users created successfully";
} else {
    echo "Error creating table: " . mysqli_error($connection);
}

?>