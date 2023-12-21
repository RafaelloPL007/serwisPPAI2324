<?php
    session_start();
    if(isset($_SESSION['uID']) && $_SERVER['REQUEST_METHOD'] === 'POST'){
        define('host', 'localhost');
        define('user', 'root');
        define('pass', '');
        $conn = mysqli_connect(host, user, pass);
        $baza = mysqli_select_db($conn, 'serwis_3ct_gr1');
        $kwerenda = mysqli_prepare($conn, "INSERT INTO pracownik VALUES (null, ?, ?, ?, ?, ?)");
        $imie = $_POST['imie_p'];
        $nazwisko = $_POST['nazwisko_p'];
        $telefon = $_POST['telefon'];
        $email = $_POST['email'];
        $id_o = $_POST['oddzial'];
        mysqli_stmt_bind_param($kwerenda, "ssssi", $imie, $nazwisko, $telefon, $email, $id_o);
        mysqli_stmt_execute($kwerenda);
        if(mysqli_stmt_affected_rows($kwerenda) == 1){
            header("Location: pracownicy.php");
        } else{
            echo "Błąd wykonywania kwerendy";
        }
    } else{
        echo "Brak uprawnień!";
    }
?>