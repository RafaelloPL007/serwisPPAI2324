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
            <form action="php/add_device.php" method="post">
                <h2>Rejestracja urządzenia</h2>
                <fieldset>
                    <label for="nrSeryjny">Nr seryjny: </label><input type="text" id="nrSeryjny" name="nrSeryjny" required>
                    <label for="producent">Producent: </label><input type="text" name="producent" id="producent" required>
                </fieldset>
                <fieldset>
                    <label for="model">Model: </label><input type="text" name="model" id="model" required>
                    <label for="kategoria">Kategoria: </label><select id="kategoria" name="kategoria" required>
                        <option value="-1">-- Wybierz kategorię --</option>
                        <option value="RTV">RTV</option>
                        <option value="AGD">AGD</option>
                        <option value="PC">PC</option>
                    </select>
                </fieldset>
                <fieldset>
                    <input type="submit" value="Zarejestruj urządzenie">
                </fieldset>
            </form>
            <div class="search-box">
            <form>
                <h2>Wyszukiwanie urządzenia</h2>
                <fieldset>
                    <label for="sNrSeryjny">Numer seryjny: </label><input type="text" id="sNrSeryjny" name="sNrSeryjny">
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
                        <th>Nr seryjny</th>
                        <th>Producent</th>
                        <th>Model</th>
                        <th>Kategoria</th>
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
        const cSerialEl = document.querySelector("#sNrSeryjny");
        const tableEl = document.querySelector(".dept-data table tbody");
        const catSel = document.querySelector("#kategoria");
        const formEl = document.querySelector(".form-container form");

        formEl.addEventListener("submit", () => {
            if(catSel.value == -1){
                alert("Wybierz kategorię");
                event.preventDefault();
            }
        })

        searchBtn.addEventListener("click", () => {
            displayDeviceData(tableEl, cSerialEl.value);
        })

        clearBtn.addEventListener("click", () => {
            cSerialEl.value = "";
            displayDeviceData(tableEl, cSerialEl.value);
        })

        displayDeviceData(tableEl);
    </script>
</body>

</html>