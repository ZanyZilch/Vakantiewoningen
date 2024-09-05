<?php
include("../DBconfig.php");
session_start();

if (!isset($_SESSION["ROL"]) || $_SESSION["ROL"] != 0) {
    echo"hoi";
    header("location: ../home.php");
    exit();
}
?>
<!doctype html>
<html lang="eng">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.rtl.min.css" integrity="sha384-DOXMLfHhQkvFFp+rWTZwVlPVqdIhpDVYT9csOnHSgWQWPX0v5MCGtjCJbY6ERspU" crossorigin="anonymous">
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
  <title>Bewerk gebruiker</title>
</head>

<body>

  <?php

  $host = "localhost";
  $user = "root";
  $pass = "";
  $dbname = "vakantie_woningen";

  $conn = mysqli_connect($host, $user, $pass, $dbname) or die(mysqli_error($conn));
  if (isset($_GET['userID'])) {
    $id = $_GET['userID'];
    $users = "SELECT * FROM users WHERE userID =" . $id;
    $user_run = mysqli_query($conn, $users);

    if (mysqli_num_rows($user_run) > 0) {
      foreach ($user_run as $users) {
      }

  ?>

    <?php

    } else {
    ?>
      <h4> Niks gevonden </h4>
  <?php
    }
  }

  ?>




  <div class="bulkMain">
        <h1>Bewerk gebruiker</h1>
        <form class="bewerk-form" name="Bewerken" action="bewerk.php" method="POST">
        <input type="hidden" name="id" value="<?= $users['userID']; ?>" />
            <div class="form-group">
                <label for="username">Voornaam:</label>
                <input type="text" class="form-control" name="username" value="<?= $users['username']; ?>" /><br
            </div>
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="text" required type="email" class="form-control" name="email" value="<?= $users['email']; ?>" /><br>
            </div>
            <div class="form-group">
                <label for="rol">Rol:</label>
                <select class="form-control" id="rol" name="rol" value="<?= $users['rol']; ?>">
                    <option value="Admin">Admin</option>
                    <option value="Makelaar">Makelaar</option>
                </select>
            </div>
            <br>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="showPasswordCheckbox">
                <label class="form-check-label" for="showPasswordCheckbox">Verander wachtwoord</label>
            </div>
            <div class="form-group">
                <label for="password"></label>
                <input type="password" class="form-control" name="wachtwoord" id="passwordField" style="display: none;" value="" /><br>
            </div>

            
            <button type="submit" name="submit" value="submit" class="btn btn-primary">Bewerken</button>
            <a href="gebruiker.php" class="btn btn-primary">Gebruikers</a>

            
        </form>
    </div>  




</body>

</html>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var showPasswordCheckbox = document.getElementById("showPasswordCheckbox");
    var passwordField = document.getElementById("passwordField");

    showPasswordCheckbox.addEventListener("click", function() {
        if (showPasswordCheckbox.checked) {
            passwordField.style.display = "block";
        } else {
            passwordField.style.display = "none";
        }
    });
});
</script>

