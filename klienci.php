<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <?php
        require_once "php/auth.php";
        adminAuth();
        include_once("incl/leftPanel.php");
    ?>
    <div class="main-panel">
        <div class="form-container">
            <form action="php/add_customer.php" method="post">
                <h2>Rejestracja danych klienta</h2>
                <fieldset>
                    <label for="iKlienta">Imię: </label><input type="text" id="iKlienta" name="iKlienta">
                    <label for="nKlienta">Nazwisko: </label><input type="text" name="nKlienta" id="nKlienta">
                    <label for="firma">Firma / instytucja: </label><input type="text" name="firma" id="firma">
                </fieldset>
                <fieldset>
                    <label for="uKlienta">Ulica: </label><input type="text" name="uKlienta" id="uKlienta">
                    <label for="nrDKlienta">Nr domu: </label><input type="text" name="nrDKlienta" id="nrDKlienta">
                    <label for="nrLKlienta">Nr lokalu: </label><input type="text" name="nrLKlienta" id="nrLKlienta">
                </fieldset>
                <fieldset>
                    <label for="kod">Kod pocztowy: </label><input type="text" name="kod" id="kod">
                    <label for="mKlienta">Miejscowość: </label><input type="text" name="mKlienta" id="mKlienta">
                    <label for="telefon">Telefon: </label><input type="tel" name="telefon" id="telefon">
                    <label for="email">Email: </label><input type="email" name="email" id="email">
                </fieldset>
                <fieldset>
                    <label for="login">Login: </label><input type="text" name="login" id="login">
                    <label for="pass">Hasło: </label><input type="password" name="pass" id="pass">
                </fieldset>
                <fieldset>
                    <input type="submit" value="Zarejestruj klienta">
                </fieldset>
            </form>
            <div class="search-box">
            <form>
                <h2>Wyszukiwanie klienta</h2>
                <fieldset>
                    <label for="sNazwaKlienta">Imię i nazwisko / Firma: </label><input type="text" id="sNazwaKlienta" name="sNazwaKlienta">
                    <label for="sTelefon">Telefon: </label><input type="tel" name="telefon" id="sTelefon">
                    <label for="sEmail">Email: </label><input type="email" name="email" id="sEmail">
                </fieldset>
                <fieldset>
                    <input type="button" value="Wyszukaj" id="search-btn">
                    <input type="button" value="Wyczyść filtry" id="clear-btn">
                </fieldset>
            </form>
        </div>
        </div>
        <div class="dept-data">
            <table>
                <thead>
                    <tr>
                        <th>Klient</th>
                        <th>Ulica</th>
                        <th>Nr domu</th>
                        <th>Nr lokalu</th>
                        <th>Kod pocztowy</th>
                        <th>Miejscowość</th>
                        <th>Telefon</th>
                        <th>Email</th>
                        <th>Zgłoszenia</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
    <?php

    ?>
    <script src="script/main.js"></script>
    <script>
        const searchBtn = document.querySelector("#search-btn");
        const clearBtn = document.querySelector("#clear-btn");
        const cNameEl = document.querySelector("#sNazwaKlienta");
        const cTelEl = document.querySelector("#sTelefon");
        const cEmailEl = document.querySelector("#sEmail");
        const tableEl = document.querySelector(".dept-data table tbody");

        searchBtn.addEventListener("click", () => {
            displayClientData(tableEl, cNameEl.value, cTelEl.value, cEmailEl.value);
        })

        clearBtn.addEventListener("click", () => {
            cNameEl.value = "";
            cTelEl.value = "";
            cEmailEl.value = "";
            displayClientData(tableEl, cNameEl.value, cTelEl.value, cEmailEl.value);
        })

        displayClientData(tableEl);
    </script>
</body>

</html>