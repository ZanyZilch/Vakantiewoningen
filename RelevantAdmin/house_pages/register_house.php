<?php
include("../DBconfig.php");

if (isset($_POST["submit"])) {
    $melding = "";
    $img_path = $_FILES['img_path']['name'];
    $omschrijving = $_POST['omschrijving'];
    $adress = $_POST['adress'];
    $postcode = $_POST['postcode'];
    $provincie = $_POST['provincie'];
    $stad = $_POST['stad'];
    $prijs = $_POST['prijs'];

    // Retrieve the selected 'userID'
    $username = $_POST['makelaar'];

    try {
        $verbinding->beginTransaction();

        // Your SQL query to insert into the house table
        $query1 = "INSERT INTO house (omschrijving, adress, postcode, provincie, stad, prijs, userID)
        VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt1 = $verbinding->prepare($query1);
        $stmt1->execute(array($omschrijving, $adress, $postcode, $provincie, $stad, $prijs, $username));

        // Get the newly inserted houseID
        $newHouseID = $verbinding->lastInsertId();

        // Handle file uploads for multiple images
        $uploadDirectory = '../../data/houseimages/house_' . $newHouseID . "/"; // Adjust this to your directory
        $imagePaths = array();

        if (!file_exists($uploadDirectory)) {
            mkdir($uploadDirectory, 0777, true);
        }

        foreach ($_FILES['img_path']['name'] as $key => $value) {
            if (!empty($_FILES['img_path']['name'][$key])) {
                $uploadedFile = $_FILES['img_path'];
                $extension = pathinfo($uploadedFile['name'][$key], PATHINFO_EXTENSION);
                $uniqueFilename = uniqid() . '_' . $key . '.' . $extension;
                $img_path = $uploadDirectory . $uniqueFilename;

                if (move_uploaded_file($uploadedFile['tmp_name'][$key], $img_path)) {
                    $img_path = $uniqueFilename;
                    $imagePaths[] = $img_path;
                    // Your SQL query to insert into the house_images table for each image
                    $query2 = "INSERT INTO house_images (houseID, img_path) VALUES (?, ?)";
                    $stmt2 = $verbinding->prepare($query2);
                    $stmt2->execute(array($newHouseID, $img_path));
                }
            }
        }

        if (isset($_POST["ligging"])) {
            $selectedLiggingen = $_POST["ligging"];

            $insertQuery = "INSERT INTO house_ligging (house_id, ligging_id) VALUES (:houseID, :liggingID)";
            $stmtInsert = $verbinding->prepare($insertQuery);
            $stmtInsert->bindParam(':houseID', $newHouseID, PDO::PARAM_INT);

            foreach ($selectedLiggingen as $liggingID) {
                $stmtInsert->bindParam(':liggingID', $liggingID, PDO::PARAM_INT);
                $stmtInsert->execute();
            }
        }

        if (isset($_POST["eigenschappen"])) {
            $selectedEigenschap = $_POST["eigenschappen"];

            $insertQuery = "INSERT INTO house_eigenschappen (house_id, eigenschap_id) VALUES (:houseID, :eigenschapID)";
            $stmtInsert = $verbinding->prepare($insertQuery);
            $stmtInsert->bindParam(':houseID', $newHouseID, PDO::PARAM_INT);

            foreach ($selectedEigenschap as $eigenschapID) {
                $stmtInsert->bindParam(':eigenschapID', $eigenschapID, PDO::PARAM_INT);
                $stmtInsert->execute();
            }
        }

        // Commit the transaction
        header('Location: houses.php');
        $verbinding->commit();
    } catch (PDOException $e) {
        // Rollback the transaction if an error occurs
        $verbinding->rollBack();
        echo "Error: " . $e->getMessage();
    }
}
?>