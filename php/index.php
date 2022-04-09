<?php
// sign up and signin page
session_start();
//$_SESSION['user_id'] = 123;
//$_SESSION['user_name'] = 'test';

if (isset($_SESSION['user_id'])) {
    header('Location: home.php');
} else {
    // get returned errors and field value
    $error = '';
    $user_name = '';
    $user_roll = '';
    $user_email = '';
    if (isset($_GET['error']))
        $error = $_GET['error'];

    if (isset($_GET['user_name']))
        $user_name = $_GET['user_name'];

    if (isset($_GET['user_roll']))
        $user_roll = $_GET['user_roll'];

    if (isset($_GET['user_email']))
        $user_email = $_GET['user_email'];

?>
    <html>

    <head>
        <title>Sign Up</title>
        <link type="text/css" rel="stylesheet" href="../css/index_php_v1.css">
    </head>

    <body>
        <!-- header:navigation bar -->
        <div class="header">
            <div class="header_left">
                <h3>Notes App</h3>
            </div>
            <div class="header_right">
                <!-- sign in area -->
                <form class="signin_form" action="signin.php" method="post">
                    <input type="email" name="user_email" placeholder="Email">
                    <input type="password" name="user_password" placeholder="Password">
                    <?php
                    // get signin_error
                    if (isset($_GET['signin_error'])) {
                        $signin_error = $_GET['signin_error'];
                        echo "<p class='error'>*$signin_error</p>";
                    }

                    ?>
                    <input type="submit" value="Sign In">
                </form>
            </div>
        </div>
        <div class="main">
            <!-- left description area -->
            <div class="main_left">
                <div class="left_content">
                    <h3>Notes App</h3>
                    <p>
                        Make an organized collection of yiur notes and access from localhost 😃.
                    </p>
                </div>
            </div>
            <!-- right sign up form -->
            <div class="main_right">
                <div class="signup_area">
                    <h3>SIGN UP</h3>
                    <form id="signup_form" action="signup.php" method="post">
                        <input type="text" name="user_name" placeholder="Name" value="<?php if ($user_name) echo $user_name ?>">
                        <input type="text" name="user_roll" placeholder="Roll number" value="<?php if ($user_roll) echo $user_roll ?>">
                        <input type="email" name="user_email" placeholder="Email" value="<?php if ($user_email) echo $user_email ?>">
                        <input type="password" name="user_password" placeholder="Password">
                        <?php
                        // display error if any
                        if ($error) {
                            echo "<p class='error'>$error</p>";
                        }

                        ?>
                        <input type="submit" value="Sign Up">
                    </form>
                </div>
            </div>
        </div>
        <div class="footer">
            <p>&copy; 2020 Notes App</p>
        </div>
    </body>

    </html>



<?php
}

?>