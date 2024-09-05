<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="../data/css/fourth.css">
</head>

<body>
<header>
<?php
        //hier PHP
    ?>
        <nav>
            <div class="logo">
                <img src="logo.jpg" alt="Your Logo">
            </div>
            <div class="login-register">
                <a href="second.html">pagina</a>
                <a href="third.php">na</a>
                <a href="fourth.php">4</a>
                <a href="#">Login</a><a href="#">Register</a>
            </div>
        </nav>
    </header>

    <main>
        <div class="contact-container">
            <h1>Contact Us</h1>
            <p>Heeft u vragen of wilt u contact met ons opnemen? Vul het onderstaande formulier in en wij zullen zo snel mogelijk reageren.</p>

            <form action="contact_process.php" method="post">
                <label for="name">Naam:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required>

                <label for="message">Bericht:</label>
                <textarea id="message" name="message" required></textarea>

                <button type="submit">Verzenden</button>
            </form>
        </div>
    </main>

   
    <footer>
        <p>&copy; footer</p>
    </footer>
</body>

</html>
