<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>
<style>
    * {
        /*margin: 0;*/
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    i {
        margin: 0 6px;
    }

    div.menuPanel {
        width: 18vw;
        height: 100vh;
        background-color: black;
        position: fixed;
        top: 0px;
        left: 0px;
        text-align: center;
    }

    div.menuPanel p {
        text-align: center;
        width: 100%;
        color: white;
        font-size: 24px;
    }

    div.menuPanel hr {
        width: 100%;
        color: white;
        margin: 15px 0;
    }

    .fa-user-tie {
        color: white;
        font-size: 34px;
        padding: 20px;
        border: 2px solid white;
        border-radius: 50%;
        margin-top: 20px;
    }

    div.menuPanel input[type="button"] {
        border: 1px solid white;
        color: white;
        padding: 8px 14px;
        outline: none;
        background-color: black;
        border-radius: 6px;
        margin-left: 3px;
        margin-right: 3px;
    }

    div.menuPanel input[type="button"]:hover {
        background-color: gainsboro;
        color: black;
        cursor: pointer;
    }

    div.menuPanel ul {
        list-style-type: none;
        margin-top: 30px;
    }

    div.menuPanel li {
        color: white;
        border-bottom: 1px solid white;
        text-align: left;
        margin-left: 15px;
        margin-right: 20px;
        padding: 20px;
        cursor: pointer;
    }

    div.menuPanel li a {
        text-decoration: none;
        color: white;
    }

    div.main-panel {
        width: 80vw;
        position: fixed;
        top: 0;
        right: 15px;
    }

    .form-container h2 {
        text-align: center;
    }

    .form-container form {
        display: flex;
        flex-direction: column;
        border: 1px solid gray;
        margin: 10px auto;
    }

    .form-container form input[type="submit"] {
        background-color: black;
        color: white;
        cursor: pointer;
        padding: 6px 12px;
        outline: none;
        border-radius: 5px;
        font-weight: bold;
    }

    .form-container form input[type="submit"]:hover {
        background-color: gainsboro;
        color: black;
    }

    fieldset {
        text-align: center;
        padding: 10px;
        border: none;
    }

    fieldset input:not(:last-of-type) {
        margin-right: 20px;
    }

    fieldset label[for='oddzial'] {
        margin-left: 20px;
    }

    fieldset input {
        padding: 5px 2px;
    }

    .dept-data {
        border: 1px solid gray;
        padding: 10px 40px;
    }

    table {
        width: 100%;
        border-spacing: 0;
    }

    tr th {
        font-size: 17px;
        text-align: center;
        border-bottom: 2px solid black;
        padding: 8px;
    }

    tr td {
        padding: 4px 8px;
    }

    table tr td {
        border-bottom: 1px solid #BBB;
    }

    textarea#opis {
        width: 200px;
        height: 100px;
    }
</style>

<body>
    <?php
    include_once("incl/leftPanel.php");
    ?>
    <div class="main-panel">
        <div class="device-data">
            <?php
            define('host', 'localhost');
            define('user', 'root');
            define('pass', '');
            $conn = mysqli_connect(host, user, pass);
            $baza = mysqli_select_db($conn, 'serwis_3ct_gr1');
            $kwerenda = mysqli_prepare($conn, "SELECT id_zgloszenia, opis_zgloszenia, data_zgloszenia, data_odbioru, sprzet.id_urzadzenia, sprzet.nr_seryjny, sprzet.producent, sprzet.model, sprzet.kategoria, CONCAT(klient.imie_k, ' ', klient.nazwisko_k) as in_k, klient.firma_k, CONCAT(pracownik.imie_p, ' ', pracownik.nazwisko_p) as in_p FROM zgloszenie JOIN sprzet USING (id_urzadzenia) JOIN klient USING (id_klienta) JOIN pracownik USING (id_pracownika) WHERE id_zgloszenia = ?");
            mysqli_stmt_bind_param($kwerenda, 'i', $_GET['zgl']);
            mysqli_stmt_execute($kwerenda);
            mysqli_stmt_bind_result($kwerenda, $iz, $oz, $dz, $do, $spr_id, $nr_ser, $pro, $mod, $kat, $k1, $k2, $p);
            mysqli_stmt_fetch($kwerenda);
            if($do == "")
                echo "<h2>Zgłoszenie nr $iz z dnia $dz</h2>";
            else
                echo "<h2>Zgłoszenie nr $iz z dnia $dz - odebrane $do</h2>";
            echo "<h2>Opis zgłoszenia: $oz<h2>";
            echo "<h2>Sprzęt: <a href='sprzetSzczegoly.php?id=$spr_id'>$nr_ser - $pro $mod - $kat</a></h2>";
            if($k1 != "")
                echo "<h2>Klient: $k1</h2>";
            else
                echo "<h2>Klient: $k2</h2>";
            echo "<h2>Pracownik: $p</h2>";
            mysqli_stmt_close($kwerenda);
            ?>
        </div>
        <div class="form-container">
            <form action="add_servicework.php" method="post">
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