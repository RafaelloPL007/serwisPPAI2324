<?php
    session_start();
    if(isset($_SESSION['uID']) && $_SERVER['REQUEST_METHOD'] === 'POST'){
        define('host', 'localhost');
        define('user', 'root');
        define('pass', '');
        $conn = mysqli_connect(host, user, pass);
        $baza = mysqli_select_db($conn, 'serwis_3ct_gr1');
        $kwerenda = mysqli_prepare($conn, "INSERT INTO oddzial VALUES (null, ?, ?, ?, ?, ?, ?, ?, ?)");
        $nazwa = $_POST['nazwaOddzialu'];
        $ulica = $_POST['ul'];
        $nr_domu = $_POST['nd'];
        $nr_lokalu = $_POST['nl'];
        $kod_pocztowy = $_POST['kp'];
        $miejscowosc = $_POST['m'];
        $telefon = $_POST['telefon'];
        $email = $_POST['email'];
        mysqli_stmt_bind_param($kwerenda, "sssissss", $nazwa, $ulica, $nr_domu, $nr_lokalu, $kod_pocztowy, $miejscowosc, $telefon, $email);
        mysqli_stmt_execute($kwerenda);
        if(mysqli_stmt_affected_rows($kwerenda) == 1){
            header("Location: ../oddzialy.php");
        } else{
            echo "Błąd wykonywania kwerendy";
        }
    } else{
        echo "Brak uprawnień!";
    }
?>