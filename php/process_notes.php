<?php
// process notes if form is submitted
session_start();
if (isset($_SESSION['user_id'])) {
    $userID = $_SESSION['user_id'];

    // get form data and validate
    $title = '';
    $content = '';
    if (isset($_POST['title']))
        $title = $_POST['title'];
    if (isset($_POST['content']))
        $content = $_POST['content'];

    // validate form data
    $error = '';
    if (empty($title))
        $error = 'Title is required';
    if (empty($content))
        $error = 'Content is required';

    // process form data if no errors

    if (empty($error)) {
        // connect to database
        require_once 'connect.php';
        mysqli_select_db($connection, 'notes_app');

        //mysql datetime
        $datetime = date('Y-m-d H:i:s');
        // insert new note into database
        $sql = "INSERT INTO notes (user_id, note_title, note_content,note_date) VALUES ('$userID', '$title', '$content', '$datetime')";
        $result = mysqli_query($connection, $sql);
        if ($result) {
            // redirect to home page
            header('Location: home.php');
        } else {
            // redirect to sign up page with error
            header('Location: home.php?error=Database error&title=' . $title . '&content=' . $content);
        }
    } else {
        // redirect to sign up page with error
        header('Location: home.php?error=' . $error);
    }
} else {
    header('Location: index.php');
}
