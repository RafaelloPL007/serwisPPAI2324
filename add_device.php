<?php
    session_start();
    if(isset($_SESSION['uID']) && $_SERVER['REQUEST_METHOD'] === 'POST'){
        define('host', 'localhost');
        define('user', 'root');
        define('pass', '');
        $conn = mysqli_connect(host, user, pass);
        $baza = mysqli_select_db($conn, 'serwis_3ct_gr1');
        $kwerenda = mysqli_prepare($conn, "INSERT INTO sprzet VALUES (null, ?, ?, ?, ?)");
        $nrSeryjny = $_POST['nrSeryjny'];
        $producent = $_POST['producent'];
        $model = $_POST['model'];
        $kategoria = $_POST['kategoria'];
        mysqli_stmt_bind_param($kwerenda, "ssss", $nrSeryjny, $producent, $model, $kategoria);
        mysqli_stmt_execute($kwerenda);
        if(mysqli_stmt_affected_rows($kwerenda) == 1){
            header("Location: sprzet.php");
        } else{
            echo "Błąd wykonywania kwerendy";
        }
    } else{
        echo "Brak uprawnień!";
    }
?>