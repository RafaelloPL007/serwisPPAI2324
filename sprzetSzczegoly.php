<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
                $kwerenda = mysqli_prepare($conn, "SELECT id_urzadzenia, nr_seryjny, producent, model, kategoria FROM sprzet WHERE id_urzadzenia = ?");
                mysqli_stmt_bind_param($kwerenda, 'i', $_GET['id']);
                mysqli_stmt_execute($kwerenda);
                mysqli_stmt_bind_result($kwerenda, $iu, $ns, $pr, $mo, $kat);
                mysqli_stmt_fetch($kwerenda);
                echo "<h2>" . $ns . " - " . $pr . " " . $mo . " - " . $kat . "</h2>";
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
                    <th>Klient</th>
                    <th>Pracownik</th>
                </tr>
                <?php
                
                $kwerenda = mysqli_prepare($conn, "SELECT id_zgloszenia, opis_zgloszenia, data_zgloszenia, data_odbioru, IFNULL(klient.firma_k, CONCAT(klient.imie_k, ' ', klient.nazwisko_k)), CONCAT(pracownik.imie_p, ' ', pracownik.nazwisko_p) FROM zgloszenie JOIN klient USING (id_klienta) JOIN pracownik USING (id_pracownika)");
                mysqli_stmt_execute($kwerenda);
                mysqli_stmt_bind_result($kwerenda, $iz, $oz, $dz, $do, $k, $p);
                while (mysqli_stmt_fetch($kwerenda)) {
                    echo "<tr>";
                    echo "<td>" . $oz . "</td>";
                    echo "<td>" . $dz . "</td>";
                    echo "<td>" . $do . "</td>";
                    echo "<td>" . $k . "</td>";
                    echo "<td>" . $p . "</td>";
                    echo "</tr>";
                }
                mysqli_close($conn);
                ?>
            </table>
        </div>
    </div>
    <script>
        const fNameItp = document.querySelector("#imie_p");
        const lNameItp = document.querySelector("#nazwisko_p");
        const telItp = document.querySelector("#telefon");
        const emailItp = document.querySelector("#email");
        const depSel = document.querySelector("#oddzial");
        const formEl = document.querySelector(".form-container form");

        formEl.addEventListener("submit", () => {
            if (depSel.value == -1) {
                alert("Wybierz oddział");
                event.preventDefault();
            }
        })
    </script>
</body>

</html>