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
    require_once "php/auth.php";
    clientAuth($_GET['id']);
    include_once("incl/leftPanelMin.php");
    ?>
    <div class="main-panel">
        <h1><?php echo "Witaj, " . $_SESSION['uID'];?></h1>
        <h2>Twoje zgłoszenia</h2>
        <div class="device-data">
            <?php
            define('host', 'localhost');
            define('user', 'root');
            define('pass', '');
            $conn = mysqli_connect(host, user, pass);
            $baza = mysqli_select_db($conn, 'serwis_3ct_gr1');
            $kwerenda = mysqli_prepare($conn, "SELECT id_klienta, CONCAT(imie_k, ' ', nazwisko_k) as in_k, firma_k, ulica_k, nr_domu_k, nr_lokalu_k, kod_p_k, miejscowosc_k, telefon_k, email_k FROM klient WHERE id_klienta = ?");
            mysqli_stmt_bind_param($kwerenda, 'i', $_GET['id']);
            mysqli_stmt_execute($kwerenda);
            mysqli_stmt_bind_result($kwerenda, $idk, $ink, $fk, $uk, $nd, $nl, $kp, $mk, $tk, $ek);
            mysqli_stmt_fetch($kwerenda);
            if ($nl == 0)
                $nl = "";
            else
                $nl = "/" . $nl;
            if ($ink != "")
                echo "<h2>Klient: $ink</h2>";
            else
                echo "<h2>Klient: $fk</h2>";
            echo "<h2>$uk $nd$nl, $kp $mk</h2>";
            echo "<h2>$tk - $ek</h2>";
            mysqli_stmt_close($kwerenda);
            ?>
        </div>
        <div class="dept-data">
            <h2>Zgłoszenia</h2>
            <table>
                <tr>
                    <th>Opis</th>
                    <th>Data zgłoszenia</th>
                    <th>Data odbioru</th>
                    <th>Sprzęt</th>
                    <th>Pracownik</th>
                    <th>Status</th>
                    <th>Czynności serwisowe</th>
                </tr>
                <?php

                $kwerenda = mysqli_prepare($conn, "SELECT
                    zgloszenie.id_zgloszenia,
                    zgloszenie.opis_zgloszenia,
                    zgloszenie.data_zgloszenia,
                    zgloszenie.id_urzadzenia,
                    zgloszenie.id_pracownika,
                    IFNULL(zgloszenie.data_odbioru, 'Nieodebrane'),
                    CONCAT(sprzet.nr_seryjny, ' - ', sprzet.producent, ' ', sprzet.model) AS sprzet,
                    CONCAT(pracownik.imie_p, ' ', pracownik.nazwisko_p) AS pracownik,
                    IFNULL(status_naprawy.status, 'BRAK') AS status_naprawy,
                    COUNT(czynnosci_serwisowe.id_czynnosci) AS liczba_czynnosci
                FROM
                    zgloszenie
                JOIN
                    sprzet USING (id_urzadzenia)
                JOIN
                    pracownik USING (id_pracownika)
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
                WHERE zgloszenie.id_klienta = ?
                GROUP BY
                    zgloszenie.id_zgloszenia;");
                $id_kl = $_GET['id'];
                mysqli_stmt_bind_param($kwerenda, 'i', $id_kl);
                mysqli_stmt_execute($kwerenda);
                mysqli_stmt_bind_result($kwerenda, $iz, $oz, $dz, $iu, $ip, $do, $s, $p, $status, $lc);
                while (mysqli_stmt_fetch($kwerenda)) {
                    echo "<tr id='zgl-$iz'>";
                    echo "<td>" . $oz . "</td>";
                    echo "<td>" . $dz . "</td>";
                    echo "<td class='data-odbioru'>" . $do . "</td>";
                    echo "<td>$s</td>";
                    echo "<td>$p</td>";
                    echo "<td class='status'>" . $status . "</td>";
                    echo "<td><a href='czynnosciSerwisoweMin.php?zgl=$iz'>Czynności ($lc)</a></td>";
                    echo "</tr>";
                }
                mysqli_close($conn);
                ?>
            </table>
        </div>
    </div>
    <script src="script/main.js"></script>
    <script>
        const STATUSY = ["Przyjęto w oddziale", "W trakcie naprawy", "Gotowy do odbioru"]
        const endBtnArr = document.querySelectorAll("button.end");
        const restartBtnArr = document.querySelectorAll("button.restart");
        const statusBtnArr = document.querySelectorAll("button.status-btn");

        $(document).ready(function() {
            $('.select2#id_urzadzenia').select2({
                placeholder: '-- Wybierz urządzenie --',
                language: 'pl'
            });
            $('.select2#id_pracownika').select2({
                placeholder: '-- Wybierz pracownika --',
                language: 'pl'
            });

            $(document).on('select2:open', () => {
                document.querySelector('.select2-container--open .select2-search__field').focus();
            });
        })

        

        window.addEventListener("load", () => {
            endBtnArr.forEach(btn => {
                btn.addEventListener("click", changeOdb);
            })
            restartBtnArr.forEach(btn => {
                btn.addEventListener("click", changeOdb);
            })
            statusBtnArr.forEach(btn => {
                btn.addEventListener("click", changeStatus);
            })
        })
    </script>
</body>

</html>