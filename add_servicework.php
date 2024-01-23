<?php
    session_start();
    if(isset($_SESSION['uID']) && $_SERVER['REQUEST_METHOD'] === 'POST'){
        define('host', 'localhost');
        define('user', 'root');
        define('pass', '');
        $conn = mysqli_connect(host, user, pass);
        $baza = mysqli_select_db($conn, 'serwis_3ct_gr1');
        $kwerenda = mysqli_prepare($conn, "INSERT INTO czynnosci_serwisowe VALUES (null, ?, ?, ?)");
        $opis = $_POST['opis'];
        $cena = $_POST['cena'];
        $id_zgl = $_POST['id_zgloszenia'];
        mysqli_stmt_bind_param($kwerenda, "sdi", $opis, $cena, $id_zgl);
        mysqli_stmt_execute($kwerenda);
        if(mysqli_stmt_affected_rows($kwerenda) == 1){
            header("Location: czynnosciSerwisowe.php?zgl=$id_zgl");
        } else{
            echo "Błąd wykonywania kwerendy";
        }
    } else{
        echo "Brak uprawnień!";
    }
?>