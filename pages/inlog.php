<?php
include("../RelevantAdmin/DBconfig.php");
session_start();

    if(isset($_POST["submit"])) {
        $melding = "";
        $email = htmlspecialchars($_POST["email"]);
        $wachtwoord = htmlspecialchars($_POST["wachtwoord"]);
        try {
            $sql = "SELECT * FROM users WHERE email = ?";
            $stmt = $verbinding->prepare($sql);
            $stmt->execute(array($email));
            $resultaat = $stmt->fetch(PDO::FETCH_ASSOC);
            var_dump($resultaat);
            if($resultaat) {
                $wachtwoordInDatabase = $resultaat["wachtwoord"];
                $rol = $resultaat["rol"];
                if(password_verify($wachtwoord, $wachtwoordInDatabase)){
                    $_SESSION["ID"] = session_id();
                    $_SESSION["USER_ID"] = $resultaat["userID"];
                    $_SESSION["USER_NAAM"] = $resultaat["username"];
                    $_SESSION["E-MAIL"] = $resultaat["email"];
                    $_SESSION["STATUS"] = "ACTIEF";
                    $_SESSION["ROL"] = $rol;
                    // 
                    if($rol == 0) {         
                        header("location: ../index.php");
                    }elseif($rol == 1) { 
                        header("location: huizen.php");
                    }else{
                        $melding .= "Toegang geweigerd<br>";
                    }

                } else {
                    $melding .= "Probeer nogmaals in te loggen<br>";
                }
            } else {
                $melding .= "Probeer nogmaals in te loggen<br>";
            }
        }catch(PDOException $e) {
            echo $e->getMessage();
        }
            echo "<div id='melding'>$melding</div>";
    }
?>