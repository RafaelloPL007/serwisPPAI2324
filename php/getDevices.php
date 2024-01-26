<?php
if(!isset($_POST['serial'])){
    echo "Brak wymaganych parametrów";
    exit();
}
$serialNr = "%" . $_POST['serial'] . "%";

define('host', 'localhost');
define('user', 'root');
define('pass', '');

$conn = mysqli_connect(host, user, pass);
$baza = mysqli_select_db($conn, 'serwis_3ct_gr1');
$kwerenda = mysqli_prepare($conn, "SELECT id_urzadzenia, nr_seryjny, producent, model, kategoria, 
            COUNT(zgloszenie.id_zgloszenia) AS total_zgloszenia,
            SUM(CASE WHEN zgloszenie.data_odbioru IS NULL AND zgloszenie.id_zgloszenia IS NOT NULL THEN 1 ELSE 0 END) AS pending_zgloszenia
        FROM sprzet 
        LEFT JOIN zgloszenie USING (id_urzadzenia) 
        WHERE nr_seryjny LIKE ? 
        GROUP BY id_urzadzenia");
mysqli_stmt_bind_param($kwerenda, 's', $serialNr);
mysqli_stmt_execute($kwerenda);
mysqli_stmt_bind_result($kwerenda, $iu, $ns, $pr, $mo, $kat, $lz, $az);
$data = array();
while (mysqli_stmt_fetch($kwerenda)) {
    $data[] = [
        "idUrzadzenia" => $iu,
        "nrSeryjny" => $ns,
        "producent" => $pr,
        "model" => $mo,
        "kategoria" => $kat,
        "liczbaZgloszen" => $lz,
        "aktywneZgloszenia" => $az
    ];
}
mysqli_close($conn);
$json = json_encode($data);
echo $json;
?>