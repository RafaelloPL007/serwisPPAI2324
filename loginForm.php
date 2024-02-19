<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/login_pages.css">
</head>
<body>
    <?php
        session_start();
        // if(isset($_SESSION['uID'])){
        //     header("Location: dashboard.php");
        // }
        if(!isset($_SESSION['log_token'])){
            $_SESSION['log_token'] = bin2hex(random_bytes(32));
        }
    ?>
    <div class="formbox">
    <form action="php/login.php" method="post">
        <div class="header"><h1>Logowanie</h1></div>
        <div class="login"><label>Login:</label><input type="text" name="login" id="login" class="input" required></div>
        <div class="pass"><label>Hasło:</label><input type="password" name="pass" id="pass" class="input" required></div>
        <input type="hidden" name="loginToken" value="<?php echo $_SESSION['log_token']; ?>">
        <input type="submit" value="ZALOGUJ" class="but" class = "log_button">
    </form>
    </div>
</body>
</html>