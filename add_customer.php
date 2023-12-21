<?php
    session_start();
    if(isset($_SESSION['uID']) && $_SERVER['REQUEST_METHOD'] === 'POST'){
        define('host', 'localhost');
        define('user', 'root');
        define('pass', '');
        $conn = mysqli_connect(host, user, pass);
        $baza = mysqli_select_db($conn, 'serwis_3ct_gr1');
        $kwerenda = mysqli_prepare($conn, "INSERT INTO klient VALUES (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $ik = $_POST['iKlienta'];
        $nk = $_POST['nKlienta'];
        $f = $_POST['firma'];
        $ul = $_POST['uKlienta'];
        $nrd = $_POST['nrDKlienta'];
        $nrl = $_POST['nrLKlienta'];
        $kod = $_POST['kod'];
        $m = $_POST['mKlienta'];
        $tel = $_POST['telefon'];
        $em = $_POST['email'];
        mysqli_stmt_bind_param($kwerenda, "sssssissss", $ik, $nk, $f, $ul, $nrd, $nrl, $kod, $m, $tel, $em);
        mysqli_stmt_execute($kwerenda);
        if(mysqli_stmt_affected_rows($kwerenda) == 1){
            header("Location: klienci.php");
        } else{
            echo "Błąd wykonywania kwerendy";
        }
    } else{
        echo "Brak uprawnień!";
    }
?>