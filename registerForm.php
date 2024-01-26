<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="CSS.css">
</head>
<body>
    <?php
        session_start();
        if(!isset($_SESSION['log_token'])){
            $_SESSION['log_token'] = bin2hex(random_bytes(32));
        }
    ?>
    <form action="php/register.php" method="post">
        <h1>REJESTRACJA</h1>
        <label>Login:</label><br><input type="text" name="login" id="login" class="input"><br>
        <label>Hasło:</label><br><input type="text" name="pass" id="pass" class="input"><br><br>
        <input type="hidden" name="loginToken" value="<?php echo $_SESSION['log_token']; ?>">
        <input type="submit" value="Zarejestruj" class="but">
    </form>
</body>
</html>