<?php
    define('host', 'localhost');
    define('user', 'root');
    define('pass', '');
    $conn=mysqli_connect(host, user, pass);
    $baza=mysqli_select_db($conn, 'accounts');
    //wstępne czyszczenie danych wejściowych:
    $userLogin=mysqli_real_escape_string($conn, trim($_POST['login']));
    $userPass=mysqli_real_escape_string($conn, trim($_POST['pass']));
    //generowanie bezpiecznego hasła:
    $userPass=password_hash($userPass, PASSWORD_DEFAULT);
    echo $userPass;
    //rejestracja w bazie:
    $kwerenda=mysqli_prepare($conn, "INSERT INTO users VALUES(null,?,?,CURRENT_DATE(),'D')");
    mysqli_stmt_bind_param($kwerenda,'ss',$userLogin,$userPass);
    mysqli_stmt_execute($kwerenda);
    //sprawdzenie:
    if(mysqli_stmt_affected_rows($kwerenda)==1){
        echo "<br>"."Zarejestrowano dane użydkownika!";
    }else{
        echo "Nie powiodło się!";
    }
    mysqli_close($conn);
?>