<?php
require_once "auth.php";
adminAuth();
if (isset($_SESSION['uID']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    define('host', 'localhost');
    define('user', 'root');
    define('pass', '');
    $conn = mysqli_connect(host, user, pass);
    $baza = mysqli_select_db($conn, 'serwis_3ct_gr1');

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
    $login = $_POST['login'];
    $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);

    $check_query = "SELECT * FROM konto WHERE login = ?";
    $stmt = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($stmt, "s", $login);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        echo "Nazwa użytkownika już istnieje. Wybierz inną nazwę. </p><p><a href='../klienci.php'>Powrót do listy klientów</a>";
    } else {
        mysqli_stmt_close($stmt);
        $kwerenda = mysqli_prepare($conn, "INSERT INTO klient VALUES (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        mysqli_stmt_bind_param($kwerenda, "sssssissss", $ik, $nk, $f, $ul, $nrd, $nrl, $kod, $m, $tel, $em);
        mysqli_stmt_execute($kwerenda);
        if (mysqli_stmt_affected_rows($kwerenda) == 1) {
            $user_id = mysqli_insert_id($conn);
            mysqli_stmt_close($kwerenda);
            $kwerenda = mysqli_prepare($conn, "INSERT INTO konto VALUES (?, ?, NOW(), 'A', 'K', ?)");
            mysqli_stmt_bind_param($kwerenda, 'ssi', $login, $pass, $user_id);
            mysqli_stmt_execute($kwerenda);
            if (mysqli_stmt_affected_rows($kwerenda) == 1) {
                header("Location: ../klienci.php");
            } else {
                echo "Błąd wykonywania kwerendy - wstawianie konta";
            }
        } else {
            echo "Błąd wykonywania kwerendy - wstawianie klienta";
        }
    }
} else {
    echo "Brak uprawnień!";
}
