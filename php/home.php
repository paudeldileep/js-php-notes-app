<!-- notes app home page after sign up or sign in -->

<?php
session_start();
// check for existing session
if (isset($_SESSION['user_id'])) {
    $userID = $_SESSION['user_id'];
    // fetch user name from database
    require_once 'connect.php';
    mysqli_select_db($connection, 'notes_app');
    $sql = "SELECT user_name FROM users WHERE id='$userID'";
    $result = mysqli_query($connection, $sql);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $userName = $row['user_name'];
    }

    // fetch user notes from database
    $sql = "SELECT * FROM notes WHERE user_id='$userID'";
    $result = mysqli_query($connection, $sql);
    if ($result) {
        $notes = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
?>
    <html>

    <head>
        <title>Notes App</title>
        <link rel="stylesheet" type="text/css" href="../css/index.css" />
    </head>

    <body>
        <!-- header:navigation bar -->
        <div class="header">
            <div class="header_left">
                <h3>Notes App</h3>
            </div>
            <div class="header_right">
                <span><?php echo $userName ?></span>
                <a id="sign_out" href="./signout.php">(Sign Out)</a>
            </div>
        </div>
        <!-- main content -->
        <div class="main">
            <div class="main_left">
                <div class="left_content">
                    <h2>Add new note</h2>
                    <form class="note_form" id="note_form" action="process_notes.php" method="post">
                        <input class="input" type="text" name="title" id="title" placeholder="Title" />
                        <textarea class="input" name="content" id="content" placeholder="Note's Content"></textarea>
                        <?php
                        // get any server returned error
                        if (isset($_GET['error'])) {
                            $error = $_GET['error'];
                            echo "<p class='error'>*$error</p>";
                        }
                        ?>
                        <input class="input" type="submit" name="submit" value="Add Note" />
                    </form>
                    <!-- <div class="signup_area">
                        <p>
                            To save and manage all your notes
                            <a href="../php/index.php">SIGN UP</a>
                        </p>
                    </div> -->
                </div>
            </div>
            <div class="main_right">
                <div class="right_content">
                    <h2>Your Notes</h2>
                    <div class="notes_container" id="notes_container">
                        <!-- notes will be loaded here -->
                        <!-- display fetched notes here -->
                        <?php

                        if (isset($notes)) {
                            if (count($notes) > 0) {
                                foreach ($notes as $note) {
                                    echo '<div class="note">';
                                    echo '<h3>' . $note['note_title'] . '</h3>';
                                    echo '<p>' . $note['note_content'] . '</p>';
                                    echo '<button class="delete"><a class="delete_link" href="delete.php?note=' . $note['id'] . '">Delete</a></button>';
                                    echo '</div>';
                                }
                            } else {
                                echo "<p class='text_white'>No previous notes found!</p>";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- footer -->
        <div class="footer">
            <div>
                <p class="footer_copy">&copy; 2020 Notes App</p>
            </div>
        </div>

        <!-- js file -->
        <!-- <script src="../js/index.js"></script> -->
    </body>

    </html>
<?php

} else {
    // redirect to login page/sign up page
    header('Location: index.php');
}

?>