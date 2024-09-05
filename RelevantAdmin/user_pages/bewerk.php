<?php
include('../DBconfig.php');

if (isset($_POST['submit'])) {
    try {
        $id = $_POST['id'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $rol = $_POST['rol'];
        
        if (isset($_POST['wachtwoord']) && !empty($_POST['wachtwoord'])) {
            $wachtwoord = $_POST['wachtwoord'];
            $wachtwoordHash = password_hash($wachtwoord, PASSWORD_DEFAULT);
        } else {
            // Als wachtwoord niet wordt bijgewerkt, laat de database waarde ongewijzigd
            $wachtwoordHash = null;
        }

        if ($rol == 'Admin') {
            $rol = 0;
        } else if ($rol == 'Makelaar') {
            $rol = 1;
        }

        $query = "UPDATE users SET username = :username, email = :email, rol = :rol";
        
        if ($wachtwoordHash !== null) {
            $query .= ", wachtwoord = :wachtwoord";
        }
        
        $query .= " WHERE userID = :id";

        $stmt = $verbinding->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':rol', $rol, PDO::PARAM_INT);
        
        if ($wachtwoordHash !== null) {
            $stmt->bindParam(':wachtwoord', $wachtwoordHash, PDO::PARAM_STR);
        }

        $stmt->execute();

        $_SESSION['message'] = "Update successful";
        header('Location: gebruiker.php');
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
