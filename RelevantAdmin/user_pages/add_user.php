<?php include "../DBconfig.php" ?>
<!doctype html>
<html lang="eng">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.rtl.min.css"
        integrity="sha384-DOXMLfHhQkvFFp+rWTZwVlPVqdIhpDVYT9csOnHSgWQWPX0v5MCGtjCJbY6ERspU" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/edit.css">

    <style>
        body {
            height:100vh;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
    <title>Gebruiker toevoegen</title>
</head>

<body>

    <div class="bulkMain">
        <h1>Gebruiker toevoegen</h1>
        <form action="register.php" method="post">
            <div class="form-group">
                <label for="username">Gebruiker:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="rol">Rol:</label>
                <select class="form-control" id="rol" name="rol" required>
                    <option value="Admin">Admin</option>
                    <option value="Makelaar">Makelaar</option>
                </select>
            </div>
            <div class="form-group">
                <label for="password">Wachtwoord:</label>
                <input type="password" class="form-control" id="wachtwoord" name="wachtwoord" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Toevoegen</button>
        </form>
    </div>
</body>

</html>