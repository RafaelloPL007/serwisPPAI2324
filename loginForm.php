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
        if(isset($_SESSION['uID'])){
            header("Location: dashboard.php");
        }
        if(!isset($_SESSION['log_token'])){
            $_SESSION['log_token'] = bin2hex(random_bytes(32));
        }
    ?>
    <form action="php/login.php" method="post">
        <h1>Logowanie</h1>
        <label>Login:</label><br><input type="text" name="login" id="login" class="input" required><br>
        <label>Hasło:</label><br><input type="password" name="pass" id="pass" class="input" required><br><br>
        <input type="hidden" name="loginToken" value="<?php echo $_SESSION['log_token']; ?>">
        <input type="submit" value="ZALOGUJ" class="but">
    </form>
</body>
</html>