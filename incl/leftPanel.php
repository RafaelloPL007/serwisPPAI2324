<div class="menuPanel">
    <p><i class="fa-solid fa-user-tie"></i></p>
    <?php
    echo "<p>" . $_SESSION['uID'] . "</p>";
    ?>
    <hr>
    <a href="dashboard.php"><input type="button" value="Panel główny"></a>
    <a href="php/logout.php"><input type="button" value="Wylogowywanie"></a>
    <hr>
    <ul>
        <li><a href="oddzialy.php"><i class="fa-solid fa-city"></i>Dane oddziału</a></li>
        <li><a href="klienci.php"><i class="fa-solid fa-user-group"></i>Klienci serwisu</a></li>
        <li><a href="pracownicy.php"><i class="fa-solid fa-person-praying"></i>Pracownicy serwisu</a></li>
        <li><a href="sprzet.php"><i class="fa-solid fa-folder-open"></i>Kartoteka sprzętu</a></li>
        <li><a href="zgloszenia.php"><i class="fa-solid fa-flag"></i>Zgłoszenia serwisowe</a></li>
    </ul>
</div>