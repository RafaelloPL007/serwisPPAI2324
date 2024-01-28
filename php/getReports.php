<?php
require_once "auth.php";
adminAuth();
if (!isset($_POST['id-pr-s']) || !isset($_POST['id-kl-s']) || !isset($_POST['id-urz-s'])) {
    echo "Brak wymaganych parametrów";
    exit();
}
$id_urz = $_POST['id-urz-s'];
$id_kl = $_POST['id-kl-s'];
$id_pr = $_POST['id-pr-s'];

define('host', 'localhost');
define('user', 'root');
define('pass', '');
$conn = mysqli_connect(host, user, pass);
$baza = mysqli_select_db($conn, 'serwis_3ct_gr1');
$kwerenda = mysqli_prepare($conn, "SELECT
                    zgloszenie.id_zgloszenia,
                    zgloszenie.opis_zgloszenia,
                    zgloszenie.data_zgloszenia,
                    zgloszenie.id_pracownika,
                    zgloszenie.id_klienta,
                    zgloszenie.id_urzadzenia,
                    IFNULL(zgloszenie.data_odbioru, 'Nieodebrane'),
                    klient.firma_k,
                    CONCAT(klient.imie_k, ' ', klient.nazwisko_k) AS klient,
                    CONCAT(pracownik.imie_p, ' ', pracownik.nazwisko_p) AS pracownik,
                    CONCAT(sprzet.nr_seryjny, ' - ', sprzet.producent, ' ', sprzet.model) AS sprzet,
                    IFNULL(status_naprawy.status, 'BRAK') AS status_naprawy,
                    COUNT(czynnosci_serwisowe.id_czynnosci) AS liczba_czynnosci
                FROM
                    zgloszenie
                JOIN
                    klient USING (id_klienta)
                JOIN
                    pracownik USING (id_pracownika)
                JOIN
                    sprzet USING (id_urzadzenia)
                LEFT JOIN
                    czynnosci_serwisowe USING (id_zgloszenia)
                JOIN
                    status_naprawy ON zgloszenie.id_zgloszenia = status_naprawy.id_zgloszenia
                JOIN
                    (
                        SELECT
                            id_zgloszenia,
                            MAX(data_zmiany) AS najnowsza_data_zmiany
                        FROM
                            status_naprawy
                        GROUP BY
                            id_zgloszenia
                    ) AS najnowszy_status ON status_naprawy.id_zgloszenia = najnowszy_status.id_zgloszenia
                        AND status_naprawy.data_zmiany = najnowszy_status.najnowsza_data_zmiany
                WHERE (zgloszenie.id_urzadzenia = ? OR ? = 0) AND (zgloszenie.id_klienta = ? OR ? = 0) AND (zgloszenie.id_pracownika = ? OR ? = 0)
                GROUP BY
                    zgloszenie.id_zgloszenia;");
mysqli_stmt_bind_param($kwerenda, 'iiiiii', $id_urz, $id_urz, $id_kl, $id_kl, $id_pr, $id_pr);
mysqli_stmt_execute($kwerenda);
mysqli_stmt_bind_result($kwerenda, $iz, $oz, $dz, $ip, $ik, $iu, $do, $k1, $k2, $p, $s, $status, $lc);
$data = array();
while (mysqli_stmt_fetch($kwerenda)) {
    $data[] = [
        "id" => $iz,
        "opis" => $oz,
        "dataZg" => $dz,
        "idp" => $ip,
        "idk" => $ik,
        "idu" => $iu,
        "data_od" => $do,
        "klient1" => $k1,
        "klient2" => $k2,
        "pracownik" => $p,
        "sprzet" => $s,
        "status" => $status,
        "liczbaCzynnosci" => $lc
    ];
}
mysqli_close($conn);
$json = json_encode($data);
echo $json;
