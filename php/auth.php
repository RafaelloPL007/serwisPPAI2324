<?php
session_start();

function adminAuth()
{
    if (!isset($_SESSION['uID']) || !isset($_SESSION['uTK'])) {
        header("Location: loginForm.php");
        exit();
    }
    if ($_SESSION['uTK'] != "A") {
        if($_SESSION['uTK'] == "K"){
            header("Location: klientSzczegolyMin.php?id=" . $_SESSION['uIK']);
        }
        header("Location: loginForm.php");
        exit();
    }
}

function clientAuth($clientId)
{
    if (!isset($_SESSION['uID']) || !isset($_SESSION['uTK']) || !isset($_SESSION['uIK'])) {
        header("Location: loginForm.php");
        exit();
    }
    if ($_SESSION['uTK'] != "K") {
        header("Location: loginForm.php");
        exit();
    }
    if ($_SESSION['uIK'] != $clientId) {
        header("Location: klientSzczegolyMin.php?id=" . $_SESSION['uIK']);
        exit();
    }
}

?>