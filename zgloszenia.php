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
            <form action="php/add_zgl.php" method="post">
                <h2>Rejestracja zgłoszenia</h2>
                <fieldset>
                    <label for="opis">Opis: </label><textarea id="opis" name="opis" required></textarea>
                    <label for="data_zgloszenia">Data zgłoszenia: </label><input type="date" name="data_zgloszenia" id="data_zgloszenia" value="<?php echo date("Y-m-d"); ?>" max="<?php echo date("Y-m-d"); ?>" required>
                </fieldset>
                <fieldset>
                    <label for="id_klienta">Klient: </label>
                    <select id="id_klienta" name="id_klienta" class="select2" required>
                        <option value=""></option>
                        <?php
                        define('host', 'localhost');
                        define('user', 'root');
                        define('pass', '');

                        $klStr = "";
                        $prStr = "";
                        $urzStr = "";

                        $conn = mysqli_connect(host, user, pass);
                        $baza = mysqli_select_db($conn, 'serwis_3ct_gr1');
                        $kwerenda = mysqli_prepare($conn, "SELECT id_klienta, CONCAT(imie_k, ' ', nazwisko_k) as in_k, firma_k, email_k FROM klient");
                        mysqli_stmt_execute($kwerenda);
                        mysqli_stmt_bind_result($kwerenda, $idk, $ink, $fk, $email);
                        while (mysqli_stmt_fetch($kwerenda)) {
                            if ($fk == "")
                                $klStr .= "<option value='$idk'>$ink ($email)</option>";
                            else
                                $klStr .= "<option value='$idk'>$fk ($email)</option>";
                        }
                        echo $klStr;
                        mysqli_stmt_close($kwerenda);
                        ?>
                    </select>
                    <label for="id_pracownika">Pracownik: </label>
                    <select id="id_pracownika" name="id_pracownika" class="select2" required>
                        <option value=""></option>
                        <?php
                        $kwerenda = mysqli_prepare($conn, "SELECT id_pracownika, CONCAT(imie_p, ' ', nazwisko_p) as in_p, email_p FROM pracownik");
                        mysqli_stmt_execute($kwerenda);
                        mysqli_stmt_bind_result($kwerenda, $idp, $inp, $email);
                        while (mysqli_stmt_fetch($kwerenda))
                            $prStr .= "<option value='$idp'>$inp ($email)</option>";
                        echo $prStr;
                        mysqli_stmt_close($kwerenda);
                        ?>
                    </select>
                    <label for="id_urzadzenia">Urządzenie: </label>
                    <select id="id_urzadzenia" name="id_urzadzenia" class="select2" required>
                        <option value=""></option>
                        <?php
                        $kwerenda = mysqli_prepare($conn, "SELECT id_urzadzenia, nr_seryjny, producent, model FROM sprzet");
                        mysqli_stmt_execute($kwerenda);
                        mysqli_stmt_bind_result($kwerenda, $id, $ns, $pr, $mo);
                        while (mysqli_stmt_fetch($kwerenda)) {
                            $urzStr .= "<option value='$id'>$ns ($pr $mo)</option>";
                        }
                        echo $urzStr;
                        mysqli_stmt_close($kwerenda);
                        ?>
                    </select>
                </fieldset>
                <fieldset>
                    <input type="submit" value="Dodaj zgłoszenie">
                </fieldset>
            </form>
        </div>
        <div class="search-box form-container">
            <form>
                <h2>Wyszukiwanie zgłoszeń</h2>
                <fieldset>
                    <label for="id-kl-s">Klient: </label>
                    <select id="id-kl-s" name="id-kl-s" class="select2" required>
                        <option value=""></option>
                        <?php
                        echo $klStr;
                        ?>
                    </select>
                    <label for="id-pr-s">Pracownik: </label>
                    <select id="id-pr-s" name="id-pr-s" class="select2" required>
                        <option value=""></option>
                        <?php
                        echo $prStr;
                        ?>
                    </select>
                    <label for="id-urz-s">Urządzenie: </label>
                    <select id="id-urz-s" name="id-urz-s" class="select2" required>
                        <option value=""></option>
                        <?php
                        echo $urzStr;
                        ?>
                    </select>
                </fieldset>
                <fieldset>
                    <input type="button" value="Wyszukaj" id="search-btn">
                    <input type="button" value="Wyczyść filtry" id="clear-btn">
                </fieldset>
            </form>
        </div>
        <div class="dept-data">
            <h2>Zgłoszenia</h2>
            <table>
                <thead>
                    <tr>
                        <th>Opis</th>
                        <th>Data zgłoszenia</th>
                        <th>Data odbioru</th>
                        <th>Klient</th>
                        <th>Pracownik</th>
                        <th>Sprzęt</th>
                        <th>Status</th>
                        <th>Czynności serwisowe</th>
                        <th>Akcje</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
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
            $('.select2#id_klienta').select2({
                placeholder: '-- Wybierz klienta --',
                language: 'pl'
            });
            $('.select2#id_pracownika').select2({
                placeholder: '-- Wybierz pracownika --',
                language: 'pl'
            });
            $('.select2#id_urzadzenia').select2({
                placeholder: '-- Wybierz urządzenie --',
                language: 'pl'
            });

            $('.select2#id-kl-s').select2({
                placeholder: '-- Wybierz klienta --',
                language: 'pl'
            });
            $('.select2#id-pr-s').select2({
                placeholder: '-- Wybierz pracownika --',
                language: 'pl'
            });
            $('.select2#id-urz-s').select2({
                placeholder: '-- Wybierz urządzenie --',
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

        const searchBtn = document.querySelector("#search-btn");
        const clearBtn = document.querySelector("#clear-btn");
        const klS = document.querySelector("#id-kl-s");
        const prS = document.querySelector("#id-pr-s");
        const urzS = document.querySelector("#id-urz-s");
        const tableEl = document.querySelector(".dept-data table tbody");

        searchBtn.addEventListener("click", () => {
            displayReportData(tableEl, klS.value, prS.value, urzS.value);
        })

        clearBtn.addEventListener("click", () => {
            $('#id-kl-s').val(null).trigger('change');
            $('#id-pr-s').val(null).trigger('change');
            $('#id-urz-s').val(null).trigger('change');
            displayReportData(tableEl, klS.value, prS.value, urzS.value);
        })

        displayReportData(tableEl);
    </script>
</body>

</html>