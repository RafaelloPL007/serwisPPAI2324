<?php
    session_start();
    if(isset($_SESSION['uID'])){
        session_unset();
        session_destroy();
        header("Location: loginForm.php");
    }
?>