<?php
    session_start();
    if(isset($_SESSION['user_id'])){
        // get note id from url and delete
        if(isset($_GET['note'])){
            $noteID = $_GET['note'];
            // connect to database
            require_once 'connect.php';
            mysqli_select_db($connection, 'notes_app');
            // delete note from database
            $sql = "DELETE FROM notes WHERE id = '$noteID'";
            $result = mysqli_query($connection, $sql);
            if($result){
                // redirect to home page
                header('Location: home.php');
            }
            else{
                // redirect to home page with error
                header('Location: home.php?error=Database error');
            }
        }
        else{
            header('Location: home.php?error=Invalid note');
        }

    }
    else{
        header('Location: index.php');
    }
