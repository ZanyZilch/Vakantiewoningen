<?php
include('DBconfig.php');
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

    <!--  CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.rtl.min.css"
        integrity="sha384-DOXMLfHhQkvFFp+rWTZwVlPVqdIhpDVYT9csOnHSgWQWPX0v5MCGtjCJbY6ERspU" crossorigin="anonymous">
    <style>
        .box {
            padding: 20px;
            margin-top: 20px;
            display: flex;
            align-items: center;
            flex-direction: column;
            height: 100vh;
        }

        .centered {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 15%;
            height: 7vh
        }

        .btn-success {
            margin-top: 20px;
            width: 100% !important;
            height: 100% !important;
        }

        .display-8 {
            margin-top: 40px;
        }

        #arrowImg {
            margin-top: 20px;
            width: 100px;
            height: 100px;
        }
    </style>

    <title>Adminpanel</title>
</head>

<body>
    <div class="top-left-items" style="display: flex; flex-direction: column;">
    </div>

    <?php
    $query = "SELECT * FROM users";
    $stmt = $verbinding->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    ?>

    <div class="container">
        <div class="box">
            <h4 class="display-4 text-center">Admin Panel</h4><br>
            <h3 class="display-7 text-center">Dit is de adminpanel van vakantiewoningen alleen toegankelijk voor
                Administrators.</h3><br>
            <h2 class="display-8 text-center">Om <b>gebruikers</b> toe te voegen en te Beheren:</h2><br>
            <img src="images/arrow.png" id="arrowImg" alt="Arrow down"><br>
            <div class="centered">
                <!-- Create a bigger, centered green button using Bootstrap classes and custom CSS -->
                <button class="btn btn-success btn-xl" onclick="redirectToUsersPage()">Gebruikers</button>
            </div>
            <h2 class="display-8 text-center">Om <b>huizen</b> toe te voegen en te beheren:</h2><br>
            <img src="images/arrow.png" id="arrowImg" alt="Arrow down"><br>
            <div class="centered">
                <!-- Create a bigger, centered green button using Bootstrap classes and custom CSS -->
                <button class="btn btn-success btn-xl" onclick="redirectToHousePage()">Huizen</button>
            </div>
            </form>
        </div>
    </div>
</body>

</html>

<script>
        function redirectToUsersPage(){
            location.href = "user_pages/gebruiker.php";
        };
        function redirectToHousePage(){
            location.href = "house_pages/houses.php";
        };

    </script>

