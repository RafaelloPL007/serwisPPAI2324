<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>

<body>
    <?php
    require_once "php/auth.php";
    adminAuth();
    include_once("incl/leftPanel.php");
    ?>
    <div class="main-panel">
        <div class="form-container">
            <div class="device-data">
                <?php
                define('host', 'localhost');
                define('user', 'root');
                define('pass', '');
                $conn = mysqli_connect(host, user, pass);
                $baza = mysqli_select_db($conn, 'serwis_3ct_gr1');
                $kwerenda = mysqli_prepare($conn, "SELECT id_zgloszenia, opis_zgloszenia, data_zgloszenia, data_odbioru, sprzet.id_urzadzenia, sprzet.nr_seryjny, sprzet.producent, sprzet.model, sprzet.kategoria, klient.id_klienta, CONCAT(klient.imie_k, ' ', klient.nazwisko_k) as in_k, klient.firma_k, pracownik.id_pracownika, CONCAT(pracownik.imie_p, ' ', pracownik.nazwisko_p) as in_p FROM zgloszenie JOIN sprzet USING (id_urzadzenia) JOIN klient USING (id_klienta) JOIN pracownik USING (id_pracownika) WHERE id_zgloszenia = ?");
                mysqli_stmt_bind_param($kwerenda, 'i', $_GET['zgl']);
                mysqli_stmt_execute($kwerenda);
                mysqli_stmt_bind_result($kwerenda, $iz, $oz, $dz, $do, $spr_id, $nr_ser, $pro, $mod, $kat, $idk, $k1, $k2, $idp, $p);
                mysqli_stmt_fetch($kwerenda);
                if($do == "")
                    echo "<h3>Zgłoszenie nr $iz z dnia $dz</h3>";
                else
                    echo "<h3>Zgłoszenie nr $iz z dnia $dz - odebrane $do</h3>";
                echo "<h3>Opis zgłoszenia: $oz<h3>";
                echo "<h3>Sprzęt: <a href='sprzetSzczegoly.php?id=$spr_id'>$nr_ser - $pro $mod - $kat</a></h3>";
                if($k1 != "")
                    echo "<h3>Klient: <a href='klientSzczegoly.php?id=$idk'>$k1</a></h3>";
                else
                    echo "<h3>Klient: <a href='klientSzczegoly.php?id=$idk'>$k2</a></h3>";
                echo "<h3>Pracownik: <a href='pracownikSzczegoly.php?id=$idp'>$p</a></h3>";
                mysqli_stmt_close($kwerenda);
                ?>
            </div>
            <form action="php/add_servicework.php" method="post">
                <h2>Czynności serwisowe</h2>
                <fieldset>
                    <label for="opis">Opis: </label><textarea id="opis" name="opis" required></textarea>
                    <label for="cena">Cena: </label><input type="number" name="cena" id="cena" value="0.00" min="0.00" step="0.01" required>
                    <input type="hidden" name="id_zgloszenia" id="id_zgloszenia" value="<?php echo $_GET['zgl']; ?>">
                </fieldset>
                <fieldset>
                    <input type="submit" value="Dodaj czynność">
                </fieldset>
            </form>
        </div>
        <div class="dept-data">
            <h2>Czynności serwisowe</h2>
            <table>
                <tr>
                    <th>Opis</th>
                    <th>Cena</th>
                </tr>
                <?php

                $kwerenda = mysqli_prepare($conn, "SELECT id_czynnosci, opis_czynnosci, cena FROM czynnosci_serwisowe WHERE id_zgloszenia = ?");
                $id_zgl = $_GET['zgl'];
                mysqli_stmt_bind_param($kwerenda, 'i', $id_zgl);
                mysqli_stmt_execute($kwerenda);
                mysqli_stmt_bind_result($kwerenda, $ic, $oc, $c);
                while (mysqli_stmt_fetch($kwerenda)) {
                    echo "<tr id='czy-$ic'>";
                    echo "<td>" . $oc . "</td>";
                    echo "<td>" . $c . " zł</td>";
                    echo "</tr>";
                }
                mysqli_close($conn);
                ?>
            </table>
        </div>
    </div>
    <script>
        
    </script>
</body>

</html>