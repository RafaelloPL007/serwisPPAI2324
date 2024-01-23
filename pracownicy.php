<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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

    fieldset label[for='oddzial']{
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
        <div class="form-container">
            <form action="add_employee.php" method="post">
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
                </tr>
                <?php

                $kwerenda = mysqli_prepare($conn, "SELECT imie_p, nazwisko_p, telefon_p, email_p, oddzial.nazwa_oddzialu FROM pracownik JOIN oddzial USING (id_oddzialu)");
                mysqli_stmt_execute($kwerenda);
                mysqli_stmt_bind_result($kwerenda, $ip, $np, $tp, $ep, $no);
                while (mysqli_stmt_fetch($kwerenda)) {
                    echo "<tr>";
                    echo "<td>" . $ip . "</td>";
                    echo "<td>" . $np . "</td>";
                    echo "<td>" . $tp . "</td>";
                    echo "<td>" . $ep . "</td>";
                    echo "<td>" . $no . "</td>";
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