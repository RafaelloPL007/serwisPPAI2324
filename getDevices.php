<?php
    if(!isset($_GET['serial'])){
        echo "Brak wymaganych parametrów";
        exit();
    }
    $serialNr = "%" . $_GET['serial'] . "%";
    define('host', 'localhost');
    define('user', 'root');
    define('pass', '');
    $conn = mysqli_connect(host, user, pass);
    $baza = mysqli_select_db($conn, 'serwis_3ct_gr1');
    $kwerenda = mysqli_prepare($conn, "SELECT id_urzadzenia, nr_seryjny, producent, model, kategoria, COUNT(zgloszenie.id_zgloszenia) FROM sprzet LEFT JOIN zgloszenie USING (id_urzadzenia) WHERE nr_seryjny LIKE ? GROUP BY id_urzadzenia");
    mysqli_stmt_bind_param($kwerenda, 's', $serialNr);
    mysqli_stmt_execute($kwerenda);
    mysqli_stmt_bind_result($kwerenda, $iu, $ns, $pr, $mo, $kat, $lz);
    $data = array();
    while (mysqli_stmt_fetch($kwerenda)) {
        $data[] = [
            "idUrzadzenia" => $iu,
            "nrSeryjny" => $ns,
            "producent" => $pr,
            "model" => $mo,
            "kategoria" => $kat,
            "liczbaZgloszen" => $lz
        ];
    }
    mysqli_close($conn);
    $json = json_encode($data);
    echo $json;
?>