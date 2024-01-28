<?php
define('host', 'localhost');
define('user', 'root');
define('pass', '');
$conn = mysqli_connect(host, user, pass);
$baza = mysqli_select_db($conn, 'serwis_3ct_gr1');
//uruchamianie sesji użytkownika:
session_start();
if (($_SERVER['REQUEST_METHOD'] === 'POST') && hash_equals($_SESSION['log_token'], $_POST['loginToken'])) {
    //wstępne czyszczenie danych wejściowych:
    $userLogin = mysqli_real_escape_string($conn, trim($_POST['login']));
    $userPass = mysqli_real_escape_string($conn, trim($_POST['pass']));
    //sprawdzanie danych logowania w bazie:
    $kwerenda = mysqli_prepare($conn, "SELECT login, haslo, typ_konta, id_klienta FROM konto where login=?");
    mysqli_stmt_bind_param($kwerenda, 's', $userLogin);
    mysqli_stmt_execute($kwerenda);
    mysqli_stmt_bind_result($kwerenda, $vl, $vp, $tk, $ik);
    mysqli_stmt_fetch($kwerenda);
    if (password_verify($userPass, $vp)) {
        $_SESSION['uID'] = $vl;
        $_SESSION['uTK'] = $tk;
        $_SESSION['uIK'] = $ik;
        //usunięcie tokenu logowania z sesji
        unset($_SESSION['log_token']);
        if($tk == "A")
            header('location: ../dashboard.php');
        else if($tk == "K")
            header("location: ../klientSzczegolyMin.php?id=$ik");
    } else{
        header('location: ../loginForm.php');
    }
} else{
    echo "Błąd podatności CSRF - błędny token autoryzacyjny";
}
mysqli_close($conn);
