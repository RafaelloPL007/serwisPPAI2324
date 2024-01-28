<?php
require_once "auth.php";
adminAuth();
if (!isset($_POST['cname']) || !isset($_POST['ctel']) || !isset($_POST['cmail'])) {
    echo "Brak wymaganych parametrów";
    exit();
}
$clientName = "%" . $_POST['cname'] . "%";
$clientTel = "%" . $_POST['ctel'] . "%";
$clientEmail = "%" . $_POST['cmail'] . "%";

define('host', 'localhost');
define('user', 'root');
define('pass', '');
$conn = mysqli_connect(host, user, pass);
$baza = mysqli_select_db($conn, 'serwis_3ct_gr1');
$kwerenda = mysqli_prepare($conn, "SELECT id_klienta, CONCAT(imie_k, ' ', nazwisko_k) as in_k, firma_k, ulica_k, nr_domu_k, nr_lokalu_k, kod_p_k, miejscowosc_k, telefon_k, email_k, 
        COUNT(zgloszenie.id_zgloszenia) AS total_zgloszenia,
        SUM(CASE WHEN zgloszenie.data_odbioru IS NULL AND zgloszenie.id_zgloszenia IS NOT NULL THEN 1 ELSE 0 END) AS pending_zgloszenia FROM klient
        LEFT JOIN zgloszenie USING (id_klienta) 
        WHERE (CONCAT(imie_k, ' ', nazwisko_k) LIKE ? OR firma_k LIKE ?) AND telefon_k LIKE ? AND email_k LIKE ?
        GROUP BY id_klienta");
mysqli_stmt_bind_param($kwerenda, 'ssss', $clientName, $clientName, $clientTel, $clientEmail);
mysqli_stmt_execute($kwerenda);
mysqli_stmt_bind_result($kwerenda, $idk, $ink, $fk, $uk, $nd, $nl, $kp, $mk, $tk, $ek, $lz, $az);
$data = array();
while (mysqli_stmt_fetch($kwerenda)) {
    $data[] = [
        "id" => $idk,
        "imieNazwisko" => $ink,
        "firma" => $fk,
        "ulica" => $uk,
        "nr_domu" => $nd,
        "nr_lokalu" => $nl,
        "kod_pocztowy" => $kp,
        "miejscowosc" => $mk,
        "telefon" => $tk,
        "email" => $ek,
        "liczbaZgloszen" => $lz,
        "aktywneZgloszenia" => $az
    ];
}
mysqli_close($conn);
$json = json_encode($data);
echo $json;
