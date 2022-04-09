<?php
    session_start();
    if(isset($_SESSION['user_id'])){
        // delete session and sign out user
        session_destroy();
        header('Location: index.php');
    }
    else{
        header('Location: index.php');
    }
