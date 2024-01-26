<?php
define('host', 'localhost');
define('user', 'root');
define('pass', '');
$conn = mysqli_connect(host, user, pass);
$baza = mysqli_select_db($conn, 'serwis_3ct_gr1');
//uruchamianie sesji użytkownika:
session_start();
if (($_SERVER['REQUEST_METHOD'] === 'POST')) {
    $id = $_POST['id'];
    $end = $_POST['endZgl'];
    if($end == "true"){
        $kwerenda = mysqli_prepare($conn, "UPDATE zgloszenie SET data_odbioru = NOW() WHERE id_zgloszenia = ?");
        echo date("Y-m-d");
    }
    else{
        $kwerenda = mysqli_prepare($conn, "UPDATE zgloszenie SET data_odbioru = NULL WHERE id_zgloszenia = ?");
        echo "Nieodebrane";
    }
    mysqli_stmt_bind_param($kwerenda, 'i', $id);
    mysqli_stmt_execute($kwerenda);
    mysqli_stmt_close($kwerenda);
} else{
    echo "Błąd";
}
mysqli_close($conn);
