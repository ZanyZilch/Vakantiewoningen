<?php
include('../DBconfig.php');

if (isset($_POST['submit'])) {
    $houseID = $_GET["houseID"];
    try {
        $liggingName = $_POST['liggingName'];

        // Insert the new "ligging" into the database
        $insertQuery = "INSERT INTO ligging (naam) VALUES (:liggingName)";
        $stmt = $verbinding->prepare($insertQuery);
        $stmt->bindParam(':liggingName', $liggingName, PDO::PARAM_STR);
        $stmt->execute();

        // Redirect or display a success message
        // ...

        header('Location: edit-houses.php?houseID=' . $houseID);
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
