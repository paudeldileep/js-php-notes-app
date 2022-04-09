<!-- php file for processing signup action -->

<?php
// check for existing session
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: home.php');
} else {
    // check for signup action
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // connect to database
        require_once 'connect.php';
        // get form data
        $user_name = $_POST['user_name'];
        $user_roll = $_POST['user_roll'];
        $user_email = $_POST['user_email'];
        $user_password = $_POST['user_password'];
        // check for empty fields
        if (empty($user_name) || empty($user_roll) || empty($user_email) || empty($user_password)) {
            header('Location: index.php?error=empty-fields&user_name=' . $user_name . '&user_roll=' . $user_roll . '&user_email=' . $user_email);
            exit();
        } else {
            if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
                header('Location: index.php?error=invalid-email&user_name=' . $user_name . '&user_roll=' . $user_roll);
                exit();
            }
            if (!preg_match("/^[0-9]{5,10}$/", $user_roll)) {
                header('Location: index.php?error=invalid-roll&user_name=' . $user_name . '&user_email=' . $user_email);
                exit();
            }
            if (!preg_match("/^[a-zA-Z0-9]*$/", $user_password)) {
                header('Location: index.php?error=invalid-password&user_name=' . $user_name . '&user_roll=' . $user_roll . '&user_email=' . $user_email);
                exit();
            }

            // check for existing user
            require_once 'connect.php';
            // select db
            mysqli_select_db($connection, 'notes_app');

            $sql = "SELECT id FROM users WHERE (user_email='$user_email' OR user_roll='$user_roll')";
            $result = mysqli_query($connection, $sql);
            if ($result) {
                $resultCheck = mysqli_num_rows($result);
                if ($resultCheck > 0) {
                    header('Location: index.php?error=user-already-exists&user_name=' . $user_name . '&user_roll=' . $user_roll . '&user_email=' . $user_email);
                    exit();
                } else {
                    // current date time
                    // $date = date('Y-m-d H:i:s');
                    $secure_password = md5($user_password);
                    // insert user data into database
                    $sql = "INSERT INTO users (user_name, user_roll, user_email, user_password) VALUES ('$user_name', '$user_roll', '$user_email', '$secure_password')";
                    $result = mysqli_query($connection, $sql);
                    if ($result) {
                        // create session with user id
                        $_SESSION['user_id'] = mysqli_insert_id($connection);
                        header('Location: home.php');
                        exit();
                    } else {
                        header('Location: index.php?error=db-error');
                        exit();
                    }
                }
            } else {
                echo 'Error: ' . mysqli_error($connection);
            }
        }
    } else {
        header('Location: index.php');
        exit();
    }
}
?>