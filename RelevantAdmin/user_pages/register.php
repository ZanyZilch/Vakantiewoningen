<?php
include("../DBconfig.php");

if(isset($_POST["submit"])) {
    $melding = "";
    $email = htmlspecialchars($_POST['email']);
    $wachtwoord = htmlspecialchars($_POST['wachtwoord']);
    $rol = htmlspecialchars($_POST['rol']);
    $username = htmlspecialchars($_POST['username']);
    $wachtwoordHash = password_hash($wachtwoord, PASSWORD_DEFAULT);

    if($rol == 'Admin'){
        $rol = 0;
    } else if($rol == 'Makelaar'){
        $rol = 1;
    }

    // Controleer of e-mail al bestaat (geen dubbele adressen)
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $verbinding->prepare($sql);
    $stmt->execute(array($email));
    $resultaat = $stmt->fetch(PDO::FETCH_ASSOC);
    var_dump($email);

    if($resultaat) {
        $melding = "Dit e-mailadres is al geregistreerd";
    } else {
        $sql = "INSERT INTO users ( email, wachtwoord, rol, username)
                            values (?,?,?,?)";
                            // ID = null, de rest is ?
        $stmt = $verbinding->prepare($sql);
        try {
            $stmt->execute(array(
                $email,
                $wachtwoordHash,
                $rol,
                $username
                )
            );
            
           header('Location: gebruiker.php');
        
        }catch(PDOException $e) {
            $melding = "Kon geen account aanmaken." . $e->getMessage();
            
        }
        var_dump($sql);
        echo "<div id='melding'>".$melding."</div>";
    }
}
?>