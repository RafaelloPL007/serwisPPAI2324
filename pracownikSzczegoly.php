<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/main.css">
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
            $kwerenda = mysqli_prepare($conn, "SELECT id_pracownika, imie_p, nazwisko_p, telefon_p, email_p FROM pracownik WHERE id_pracownika = ?");
            mysqli_stmt_bind_param($kwerenda, 'i', $_GET['id']);
            mysqli_stmt_execute($kwerenda);
            mysqli_stmt_bind_result($kwerenda, $id, $imie, $naz, $tel, $email);
            mysqli_stmt_fetch($kwerenda);
            echo "<h3>Pracownik: $imie $naz ";
            echo "$tel - $email</h3>";
            mysqli_stmt_close($kwerenda);
            ?>
        </div>
            <form action="php/add_zgl.php" method="post">
                <h2>Rejestracja zgłoszenia</h2>
                <fieldset>
                    <label for="opis">Opis: </label><textarea id="opis" name="opis" required></textarea>
                    <label for="data_zgloszenia">Data zgłoszenia: </label><input type="date" name="data_zgloszenia" id="data_zgloszenia" value="<?php echo date("Y-m-d"); ?>" max="<?php echo date("Y-m-d"); ?>" required>
                    <input type="hidden" name="id_pracownika" id="id_pracownika" value="<?php echo $_GET['id']; ?>">
                </fieldset>
                <fieldset>
                    <label for="id_urzadzenia">Urządzenie: </label>
                    <select id="id_urzadzenia" name="id_urzadzenia" class="select2" required>
                        <option value=""></option>
                        <?php
                        $kwerenda = mysqli_prepare($conn, "SELECT id_urzadzenia, nr_seryjny, producent, model FROM sprzet");
                        mysqli_stmt_execute($kwerenda);
                        mysqli_stmt_bind_result($kwerenda, $id, $ns, $pr, $mo);
                        while (mysqli_stmt_fetch($kwerenda)) {
                            echo "<option value='$id'>$ns ($pr $mo)</option>";
                        }
                        mysqli_stmt_close($kwerenda);
                        ?>
                    </select>
                    <label for="id_klienta">Klient: </label>
                    <select id="id_klienta" name="id_klienta" class="select2" required>
                        <option value=""></option>
                        <?php
                        $kwerenda = mysqli_prepare($conn, "SELECT id_klienta, CONCAT(imie_k, ' ', nazwisko_k) as in_k, firma_k, email_k FROM klient");
                        mysqli_stmt_execute($kwerenda);
                        mysqli_stmt_bind_result($kwerenda, $idk, $ink, $fk, $email);
                        while (mysqli_stmt_fetch($kwerenda)) {
                            if ($fk == "")
                                echo "<option value='$idk'>$ink ($email)</option>";
                            else
                                echo "<option value='$idk'>$fk ($email)</option>";
                        }
                        mysqli_stmt_close($kwerenda);
                        ?>
                    </select>
                </fieldset>
                <fieldset>
                    <input type="submit" value="Dodaj zgłoszenie">
                </fieldset>
            </form>
        </div>
        <div class="dept-data">
            <h2>Zgłoszenia</h2>
            <table>
                <tr>
                    <th>Opis</th>
                    <th>Data zgłoszenia</th>
                    <th>Data odbioru</th>
                    <th>Klient</th>
                    <th>Sprzęt</th>
                    <th>Status</th>
                    <th>Czynności serwisowe</th>
                    <th>Akcje</th>
                </tr>
                <?php

                $kwerenda = mysqli_prepare($conn, "SELECT
                    zgloszenie.id_zgloszenia,
                    zgloszenie.opis_zgloszenia,
                    zgloszenie.data_zgloszenia,
                    zgloszenie.id_urzadzenia,
                    zgloszenie.id_klienta,
                    IFNULL(zgloszenie.data_odbioru, 'Nieodebrane'),
                    klient.firma_k,
                    CONCAT(klient.imie_k, ' ', klient.nazwisko_k) AS klient,
                    CONCAT(sprzet.nr_seryjny, ' - ', sprzet.producent, ' ', sprzet.model) AS sprzet,
                    IFNULL(status_naprawy.status, 'BRAK') AS status_naprawy,
                    COUNT(czynnosci_serwisowe.id_czynnosci) AS liczba_czynnosci
                FROM
                    zgloszenie
                JOIN
                    klient USING (id_klienta)
                JOIN
                    sprzet USING (id_urzadzenia)
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
                WHERE zgloszenie.id_pracownika = ?
                GROUP BY
                    zgloszenie.id_zgloszenia;");
                $id_kl = $_GET['id'];
                mysqli_stmt_bind_param($kwerenda, 'i', $id_kl);
                mysqli_stmt_execute($kwerenda);
                mysqli_stmt_bind_result($kwerenda, $iz, $oz, $dz, $iu, $ik, $do, $k1, $k2, $s, $status, $lc);
                while (mysqli_stmt_fetch($kwerenda)) {
                    echo "<tr id='zgl-$iz'>";
                    echo "<td>" . $oz . "</td>";
                    echo "<td>" . $dz . "</td>";
                    echo "<td class='data-odbioru'>" . $do . "</td>";
                    if ($k1 != "")
                        echo "<td><a href='klientSzczegoly.php?id=$ik'>$k1</a></td>";
                    else
                        echo "<td><a href='klientSzczegoly.php?id=$ik'>$k2</a></td>";
                    echo "<td><a href='sprzetSzczegoly.php?id=$iu'>$s</a></td>";
                    echo "<td class='status'>" . $status . "</td>";
                    echo "<td><a href='czynnosciSerwisowe.php?zgl=$iz'>Czynności ($lc)</a></td>";
                    echo "<td class='buttons'>";
                    if ($do == "Nieodebrane")
                        echo "<button class='end'>Odbiór</button>";
                    else
                        echo "<button class='restart'>Anuluj odbiór</button>";

                    if ($status != "Przyjęto w oddziale")
                        echo "<button class='status-btn prev-status'>Poprz. status</button>";
                    else
                        echo "<button class='status-btn prev-status' hidden>Poprz. status</button>";

                    if ($status != "Gotowy do odbioru")
                        echo "<button class='status-btn next-status'>Nast. status</button>";
                    else
                        echo "<button class='status-btn next-status' hidden>Nast. status</button>";

                    echo "</td></tr>";
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
            $('.select2#id_klienta').select2({
                placeholder: '-- Wybierz klienta --',
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