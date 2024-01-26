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

    div.menuPanel li{
        color: white;
        border-bottom: 1px solid white;
        text-align: left;
        margin-left: 15px;
        margin-right: 20px;
        padding: 20px;
        cursor: pointer;
    }

    div.menuPanel li a{
        text-decoration: none;
        color: white;
    }

    div.main-panel {
        width: 80vw;
        position: fixed;
        top: 0;
        right: 15px;
    }

    .form-container h2{
        text-align: center;
    }

    .form-container form{
        display: flex;
        flex-direction: column;
        border: 1px solid gray;
        margin: 10px auto;
    }

    .form-container form input[type="submit"], .form-container form input[type="button"]{
        background-color: black;
        color: white;
        cursor: pointer;
        padding: 6px 12px;
        outline: none;
        border-radius: 5px;
        font-weight: bold;
    }

    .form-container form input[type="submit"]:hover, .form-container form input[type="button"]:hover{
        background-color: gainsboro;
        color: black;
    }

    fieldset{
        text-align: center;
        padding: 10px;
        border: none;
    }

    fieldset input:not(:last-of-type){
        margin-right: 20px;
    }

    fieldset input{
        padding: 5px 2px;
    }

    .dept-data{
        border: 1px solid gray;
        padding: 10px 40px;
    }

    table{
        width: 100%;
        border-spacing: 0;
    }

    tr th{
        font-size: 17px;
        text-align: center;
        border-bottom: 2px solid black;
        padding: 8px;
    }

    tr td{
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
                    <input type="submit" value="Zarejestruj klienta">
                </fieldset>
            </form>
        </div>
        <div class="search-box form-container">
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