<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/main.css">
</head>

<body>
    <?php
    require_once "php/auth.php";
    adminAuth();
    include_once("incl/leftPanel.php");
    ?>
    <div class="main-panel">
        <div class="form-container">
            <form action="php/add_employee.php" method="post">
                <h2>Rejestracja pracownika</h2>
                <fieldset>
                    <label for="imie_p">Imię: </label><input type="text" id="imie_p" name="imie_p" required>
                    <label for="nazwisko_p">Nazwisko: </label><input type="text" name="nazwisko_p" id="nazwisko_p" required>
                </fieldset>
                <fieldset>
                    <label for="telefon">Telefon: </label><input type="tel" name="telefon" id="telefon" required>
                    <label for="email">Email: </label><input type="email" name="email" id="email" required>
                    <label for="oddzial">Oddział: </label><select id="oddzial" name="oddzial" required>
                        <option value="-1">-- Wybierz oddział --</option>
                        <?php
                        define('host', 'localhost');
                        define('user', 'root');
                        define('pass', '');
                        $conn = mysqli_connect(host, user, pass);
                        $baza = mysqli_select_db($conn, 'serwis_3ct_gr1');
                        $kwerenda = mysqli_prepare($conn, "SELECT id_oddzialu, nazwa_oddzialu FROM oddzial");
                        mysqli_stmt_execute($kwerenda);
                        mysqli_stmt_bind_result($kwerenda, $io, $no);
                        while (mysqli_stmt_fetch($kwerenda)) {
                            echo "<option value='" . $io . "'>" . $no . "</option>";
                        }
                        ?>
                    </select>
                </fieldset>
                <fieldset>
                    <input type="submit" value="Zarejestruj pracownika">
                </fieldset>
            </form>
        </div>
        <div class="dept-data">
            <table>
                <tr>
                    <th>Imię</th>
                    <th>Nazwisko</th>
                    <th>Telefon</th>
                    <th>Email</th>
                    <th>Oddział</th>
                    <th>Zgłoszenia</th>
                </tr>
                <?php

                $kwerenda = mysqli_prepare($conn, "SELECT id_pracownika, imie_p, nazwisko_p, telefon_p, email_p, oddzial.nazwa_oddzialu, 
                COUNT(zgloszenie.id_zgloszenia) AS total_zgloszenia,
                SUM(CASE WHEN zgloszenie.data_odbioru IS NULL AND zgloszenie.id_zgloszenia IS NOT NULL THEN 1 ELSE 0 END) AS pending_zgloszenia
                FROM pracownik JOIN oddzial USING (id_oddzialu) LEFT JOIN zgloszenie USING (id_pracownika)");

                mysqli_stmt_execute($kwerenda);
                mysqli_stmt_bind_result($kwerenda, $id, $ip, $np, $tp, $ep, $no, $lz, $az);
                while (mysqli_stmt_fetch($kwerenda)) {
                    echo "<tr>";
                    echo "<td>" . $ip . "</td>";
                    echo "<td>" . $np . "</td>";
                    echo "<td>" . $tp . "</td>";
                    echo "<td>" . $ep . "</td>";
                    echo "<td>" . $no . "</td>";
                    echo "<td><a href='pracownikSzczegoly.php?id=$id'>Zgłoszenia ($az/$lz)</a></td>";
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
            if(depSel.value == -1){
                alert("Wybierz oddział");
                event.preventDefault();
            }
        })
    </script>
</body>

</html>