<?php
include('../DBconfig.php');

if (isset($_POST['submit'])) {
    $houseID = $_GET["houseID"];
    try {
        // Controleer of de parameter 'ligging' als een array is ontvangen
        if (isset($_POST['eigenschapID']) && is_array($_POST['eigenschapID'])) {
            $eigenschapIds = $_POST['eigenschapID'];
            foreach($eigenschapIds as $eigenschapId) {
                // Delete the selected "ligging" from the database
                $deleteQuery = "DELETE FROM eigenschappen WHERE eigenschapID = :eigenschapID";
                $stmt = $verbinding->prepare($deleteQuery);
                $stmt->bindParam(':eigenschapID', $eigenschapId, PDO::PARAM_INT);
                $stmt->execute();
            }

            // Redirect to the desired page
            header('Location: edit-houses.php?houseID=' . $houseID);
            exit();
        } else {
            // Handle the case where 'ligging' is not an array
            echo "Invalid input received.";
            var_dump($_POST);
        }
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), "SQLSTATE[23000]: Integrity constraint violation") !== false) {
            echo "Fout: Deze eigenschap kan niet worden verwijderd omdat deze nog steeds is gekoppeld aan een huis. Verwijder eerst de koppeling met het huis en probeer het opnieuw.";
        } else {
            echo "Er is een databasefout opgetreden. Neem contact op met de beheerder voor hulp.";
        }
    }
}
?>

