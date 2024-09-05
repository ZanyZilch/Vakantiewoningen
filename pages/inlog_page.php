<?php
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" href="data/img/favicon.png" type="image/png">
    <link rel="stylesheet" href="../data/css/main.css">
    <link rel="stylesheet" href="../data/css/index.css">
    <script defer src="../data/js/main.js"></script>
    <script defer src="https://kit.fontawesome.com/769f05a054.js" crossorigin="anonymous"></script>
    <title>Vakantiewoningen • Vind je droomverblijf</title>
</head>

<body>
    <img class="topright" src="../data/img/topright.png">
    <header>
        <div class="items">
            <a href="#" class="title">Vakantiewoningen</a>
            <ul>
                <a href="index.php">Home</a>
                <a href="huizen.php">Huizen</a>
            </ul>
        </div>
    </header>
    <div class="viewport">
        <div class="right">
            <img src="../data/img/house.png">
        </div>
        <div class="left">
            <div class="login">
                <div class="login-container">
                    <form class="login-form" name="registreren" method="post" action="inlog.php">
                        <h3>E-mail:</h3>
                        <input type="text" required type="email" name="email" placeholder="bij@voorbeeld.com" /><br>
                        <h3>Wachtwoord:</h3>
                        <input required type="password" name="wachtwoord" placeholder="Wachtwoord" /><br>
                        <button type="submit" value="Login" name="submit" class="login-button">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>