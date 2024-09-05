<?php
include('../DBconfig.php');

if (isset($_POST['submit'])) {
    $houseID = $_GET["houseID"];
    try {
        // Controleer of de parameter 'ligging' als een array is ontvangen
        if (isset($_POST['liggingID']) && is_array($_POST['liggingID'])) {
            $liggingIds = $_POST['liggingID'];
            foreach($liggingIds as $liggingId) {
                // Delete the selected "ligging" from the database
                $deleteQuery = "DELETE FROM ligging WHERE liggingID = :liggingID";
                $stmt = $verbinding->prepare($deleteQuery);
                $stmt->bindParam(':liggingID', $liggingId, PDO::PARAM_INT);
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
            echo "Fout: Deze ligging kan niet worden verwijderd omdat deze nog steeds is gekoppeld aan een huis. Verwijder eerst de koppeling met het huis en probeer het opnieuw.";
        } else {
            echo "Er is een databasefout opgetreden. Neem contact op met de beheerder voor hulp.";
        }
}
}
?>


