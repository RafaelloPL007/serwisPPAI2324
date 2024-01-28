<?php
require_once "auth.php";
adminAuth();
define('host', 'localhost');
define('user', 'root');
define('pass', '');
$conn = mysqli_connect(host, user, pass);
$baza = mysqli_select_db($conn, 'serwis_3ct_gr1');
//uruchamianie sesji użytkownika:
session_start();
if (($_SERVER['REQUEST_METHOD'] === 'POST')) {
    $id = $_POST['id'];
    $status = $_POST['status'];
    $kwerenda = mysqli_prepare($conn, "INSERT INTO status_naprawy VALUES (null, now(), ?, ?);");
    mysqli_stmt_bind_param($kwerenda, 'si', $status, $id);
    mysqli_stmt_execute($kwerenda);
    mysqli_stmt_close($kwerenda);
} else{
    echo "Błąd";
}
mysqli_close($conn);
