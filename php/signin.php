<?php
// user sign in
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: home.php');
} else {

    // check server request method
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // get form data
        $email = $_POST['user_email'];
        $user_password = $_POST['user_password'];

        // validate form data
        $error = '';
        if (empty($email)) {
            $error = 'Email is required';
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Email is invalid';
        }
        if (empty($user_password)) {
            $error = 'Password is required';
        }

        // process form data if no errors
        if (empty($error)) {
            // connect to database
            require_once 'connect.php';
            mysqli_select_db($connection, 'notes_app');

            // get user data from database
            $sql = "SELECT * FROM users WHERE user_email = '$email'";
            $result = mysqli_query($connection, $sql);
            if ($result) {
                $user = mysqli_fetch_assoc($result);
                if ($user) {
                    // check password
                    $secure_password = md5($user_password);

                    if ($secure_password == $user['user_password']) {
                        // set session
                        $_SESSION['user_id'] = $user['id'];
                        // redirect to home page
                        header('Location: home.php');
                    } else {
                        // redirect to sign in page with error
                        //echo $secure_password;
                        //echo $user['user_password'];
                        header('Location: index.php?signin_error=Invalid password');
                    }
                } else {
                    // redirect to sign in page with signin_error
                    header('Location: index.php?signin_error=User not found');
                }
            } else {
                // redirect to sign in page with signin_error
                header('Location: index.php?signin_error=Database signin_error');
            }
        } else {
            // redirect to sign in page with signin_error
            header('Location: index.php?signin_error=' . $error);
        }
    } else {
        header('Location: index.php');
    }
}
