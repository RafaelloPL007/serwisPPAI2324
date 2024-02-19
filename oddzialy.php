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
            <form action="php/add_department.php" method="post">
                <h2>Rejestracja oddziału firmy</h2>
                <fieldset>
                    <label for="nazwaOddzialu">Nazwa oddziału: </label><input type="text" id="nazwaOddzialu" name="nazwaOddzialu" required>
                    <label for="ul">Ulica: </label><input type="text" name="ul" id="ul" required>
                    <label for="nd">Nr domu: </label><input type="text" name="nd" id="nd" required>
                    <label for="nl">Nr lokalu: </label><input type="text" name="nl" id="nl">
                </fieldset>
                <fieldset>
                    <label for="kp">Kod pocztowy: </label><input type="text" name="kp" id="kp" required>
                    <label for="m">Miejscowość: </label><input type="text" name="m" id="m" required>
                    <label for="telefon">Telefon: </label><input type="tel" name="telefon" id="telefon" required>
                    <label for="email">Email: </label><input type="email" name="email" id="email" required>
                </fieldset>
                <fieldset>
                    <input type="submit" value="Zarejestruj oddział">
                </fieldset>
            </form>
        </div>
        <div class="dept-data">
            <table>
                <tr>
                    <th>Nazwa oddziału</th>
                    <th>Ulica</th>
                    <th>Nr domu</th>
                    <th>Nr lokalu</th>
                    <th>Kod pocztowy</th>
                    <th>Miejscowość</th>
                    <th>Telefon</th>
                    <th>Email</th>
                </tr>
                <?php
                define('host', 'localhost');
                define('user', 'root');
                define('pass', '');
                $conn = mysqli_connect(host, user, pass);
                $baza = mysqli_select_db($conn, 'serwis_3ct_gr1');
                $kwerenda = mysqli_prepare($conn, "SELECT nazwa_oddzialu, ulica_o, nr_domu_o, nr_lokalu_o, kod_o, miejscowosc_o, telefon_o, email_o FROM oddzial");
                mysqli_stmt_execute($kwerenda);
                mysqli_stmt_bind_result($kwerenda, $no, $uo, $nd, $nl, $ko, $mo, $to, $eo);
                while (mysqli_stmt_fetch($kwerenda)) {
                    echo "<tr>";
                    echo "<td>" . $no . "</td>";
                    echo "<td>" . $uo . "</td>";
                    echo "<td>" . $nd . "</td>";
                    echo "<td>" . $nl . "</td>";
                    echo "<td>" . $ko . "</td>";
                    echo "<td>" . $mo . "</td>";
                    echo "<td>" . $to . "</td>";
                    echo "<td>" . $eo . "</td>";
                    echo "</tr>";
                }
                mysqli_close($conn);
                ?>
            </table>
        </div>
    </div>
</body>

</html>