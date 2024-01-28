<?php
require_once "auth.php";
adminAuth();
if (isset($_SESSION['uID']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    define('host', 'localhost');
    define('user', 'root');
    define('pass', '');
    $conn = mysqli_connect(host, user, pass);
    $baza = mysqli_select_db($conn, 'serwis_3ct_gr1');

    // Wstawienie zgłoszenia do tabeli zgloszenie
    $kwerendaZgloszenie = mysqli_prepare($conn, "INSERT INTO zgloszenie VALUES (null, ?, ?, null, ?, ?, ?)");
    $opis = $_POST['opis'];
    $data_zgl = $_POST['data_zgloszenia'];
    $idk = $_POST['id_klienta'];
    $idp = $_POST['id_pracownika'];
    $idu = $_POST['id_urzadzenia'];

    mysqli_stmt_bind_param($kwerendaZgloszenie, "ssiii", $opis, $data_zgl, $idk, $idp, $idu);
    mysqli_stmt_execute($kwerendaZgloszenie);

    if (mysqli_stmt_affected_rows($kwerendaZgloszenie) == 1) {
        // Pobranie id wstawionego wiersza
        $id_zgloszenia = mysqli_insert_id($conn);

        // Wstawienie statusu naprawy do tabeli status_naprawy
        $kwerendaStatusNaprawy = mysqli_prepare($conn, "INSERT INTO status_naprawy VALUES (null, now(), 'Przyjęto w oddziale', ?)");
        mysqli_stmt_bind_param($kwerendaStatusNaprawy, "i", $id_zgloszenia);
        mysqli_stmt_execute($kwerendaStatusNaprawy);

        if (mysqli_stmt_affected_rows($kwerendaStatusNaprawy) == 1) {
            header("Location: ../sprzetSzczegoly.php?id=$idu");
        } else {
            echo "Błąd wykonywania kwerendy status_naprawy";
        }
    } else {
        echo "Błąd wykonywania kwerendy zgloszenie";
    }
} else {
    echo "Brak uprawnień!";
}
?>
