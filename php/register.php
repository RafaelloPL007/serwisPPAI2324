<?php
    define('host', 'localhost');
    define('user', 'root');
    define('pass', '');
    $conn=mysqli_connect(host, user, pass);
    $baza=mysqli_select_db($conn, 'serwis_3ct_gr1');
    //wstępne czyszczenie danych wejściowych:
    $userLogin=mysqli_real_escape_string($conn, trim($_POST['login']));
    $userPass=mysqli_real_escape_string($conn, trim($_POST['pass']));
    //generowanie bezpiecznego hasła:
    $userPass=password_hash($userPass, PASSWORD_DEFAULT);

    //sprawdzenie, czy login już istnieje:
    $check_query = "SELECT * FROM konto WHERE login = ?";
    $stmt = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($stmt, "s", $userLogin);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        echo "Nazwa użytkownika już istnieje. Wybierz inną nazwę. </p><p><a href='../registerForm.php'>Powrót do rejestracji</a>";
    } else {
        //rejestracja w bazie:
        $kwerenda=mysqli_prepare($conn, "INSERT INTO konto VALUES(?,?,NOW(),'A', 'A', null)");
        mysqli_stmt_bind_param($kwerenda,'ss',$userLogin,$userPass);
        mysqli_stmt_execute($kwerenda);
        //sprawdzenie:
        if(mysqli_stmt_affected_rows($kwerenda)==1){
            echo "<br>"."Zarejestrowano dane użytkownika!";
        }else{
            echo "Nie powiodło się!";
        }
        mysqli_close($conn);
    }
?>