<div class="menuPanel">
    <p><i class="fa-solid fa-user-tie"></i></p>
    <?php
    session_start();
    echo "<p>" . $_SESSION['uID'] . "</p>";
    ?>
    <hr>
    <input type="button" value="Rejestracja">
    <a href="logout.php"><input type="button" value="Wylogowywanie"></a>
    <hr>
    <ul>
        <li><a href="oddzialy.php"><i class="fa-solid fa-city"></i>Dane oddziału</a></li>
        <li><a href="klienci.php"><i class="fa-solid fa-user-group"></i>Klienci serwisu</a></li>
        <li><a href="pracownicy.php"><i class="fa-solid fa-person-praying"></i>Pracownicy serwisu</a></li>
        <li><a href="sprzet.php"><i class="fa-solid fa-folder-open"></i>Kartoteka sprzętu</a></li>
        <li>Opcja Aplikacji Nr 5</li>
    </ul>
</div>