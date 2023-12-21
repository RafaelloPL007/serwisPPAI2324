<?php
    if(!isset($_GET['cname']) || !isset($_GET['ctel']) || !isset($_GET['cmail'])){
        echo "Brak wymaganych parametrów";
        exit();
    }
    $clientName = "%" . $_GET['cname'] . "%";
    $clientTel = "%" . $_GET['ctel'] . "%";
    $clientEmail = "%" . $_GET['cmail'] . "%";
    define('host', 'localhost');
    define('user', 'root');
    define('pass', '');
    $conn = mysqli_connect(host, user, pass);
    $baza = mysqli_select_db($conn, 'serwis_3ct_gr1');
    $kwerenda = mysqli_prepare($conn, "SELECT CONCAT(imie_k, ' ', nazwisko_k) as in_k, firma_k, ulica_k, nr_domu_k, nr_lokalu_k, kod_p_k, miejscowosc_k, telefon_k, email_k FROM klient WHERE (CONCAT(imie_k, ' ', nazwisko_k) LIKE ? OR firma_k LIKE ?) AND telefon_k LIKE ? AND email_k LIKE ?");
    mysqli_stmt_bind_param($kwerenda, 'ssss', $clientName, $clientName, $clientTel, $clientEmail);
    mysqli_stmt_execute($kwerenda);
    mysqli_stmt_bind_result($kwerenda, $ink, $fk, $uk, $nd, $nl, $kp, $mk, $tk, $ek);
    $data = array();
    while (mysqli_stmt_fetch($kwerenda)) {
        $data[] = [
            "imieNazwisko" => $ink,
            "firma" => $fk,
            "ulica" => $uk,
            "nr_domu" => $nd,
            "nr_lokalu" => $nl,
            "kod_pocztowy" => $kp,
            "miejscowosc" => $mk,
            "telefon" => $tk,
            "email" => $ek
        ];
    }
    mysqli_close($conn);
    $json = json_encode($data);
    echo $json;
?>