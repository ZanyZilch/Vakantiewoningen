<?php

include('../DBconfig.php');

if (isset($_POST['submit'])) {
    var_dump($_POST);
    try {
        $id = $_POST['id'];
        $omschrijving = $_POST['omschrijving'];
        $adress = $_POST['adress'];
        $postcode = $_POST['postcode'];
        $provincie = $_POST['provincie'];
        $stad = $_POST['stad'];
        $prijs = $_POST['prijs'];
        $makelaar = $_POST['makelaar'];

        // Determine the value for the 'verkocht' boolean based on the checkbox input
        $verkocht = isset($_POST['verkocht']) ? $_POST['verkocht'] : 0;

        $query = "UPDATE house SET omschrijving = :omschrijving, adress = :adress, postcode = :postcode, provincie = :provincie,
                  stad = :stad, prijs = :prijs, userID = :makelaar, verkocht = :verkocht WHERE houseID = :id";
        $stmt = $verbinding->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->bindParam(':omschrijving', $omschrijving, PDO::PARAM_STR);
        $stmt->bindParam(':adress', $adress, PDO::PARAM_STR);
        $stmt->bindParam(':postcode', $postcode, PDO::PARAM_STR);
        $stmt->bindParam(':provincie', $provincie, PDO::PARAM_STR);
        $stmt->bindParam(':stad', $stad, PDO::PARAM_STR);
        $stmt->bindParam(':prijs', $prijs, PDO::PARAM_INT);
        $stmt->bindParam(':makelaar', $makelaar, PDO::PARAM_INT);
        $stmt->bindParam(':verkocht', $verkocht, PDO::PARAM_INT);
        $stmt->execute();

        $imgPath = $_POST['imgPath']; // Retrieve the new img_path value
        $imageID = 13; // Replace with the desired imageID

        // Update the img_path for the specified imageID
        $updateQuery = "UPDATE house_images SET img_path = :img_path WHERE imageID = :imageID";
        $stmtUpdate = $verbinding->prepare($updateQuery);
        $stmtUpdate->bindParam(':img_path', $imgPath, PDO::PARAM_STR);
        $stmtUpdate->bindParam(':imageID', $imageID, PDO::PARAM_INT);
        $stmtUpdate->execute();

        $selectedLiggingen = $_POST['ligging']; // Get the selected "ligging" values from the form
        $houseID = $id; // Get the house ID

        // First, delete the existing "liggingen" for the house
        $deleteQuery = "DELETE FROM house_ligging WHERE house_id = :houseID";
        $stmtDelete = $verbinding->prepare($deleteQuery);
        $stmtDelete->bindParam(':houseID', $houseID, PDO::PARAM_INT);
        $stmtDelete->execute();

        // Insert the new "liggingen" for the house
        $insertQuery = "INSERT INTO house_ligging (house_id, ligging_id) VALUES (:houseID, :liggingID)";
        $stmtInsert = $verbinding->prepare($insertQuery);
        $stmtInsert->bindParam(':houseID', $houseID, PDO::PARAM_INT);

        // Loop through selected "ligging" values and insert them
        foreach ($selectedLiggingen as $liggingID) {
            $stmtInsert->bindParam(':liggingID', $liggingID, PDO::PARAM_INT);
            $stmtInsert->execute();
        }


        $selectedEigenschap = $_POST['eigenschap']; // Get the selected "ligging" values from the form
        $houseID = $id; // Get the house ID

        // First, delete the existing "liggingen" for the house
        $deleteEigenschapQuery = "DELETE FROM house_eigenschappen WHERE house_id = :houseID";
        $stmtEigenschapDelete = $verbinding->prepare($deleteEigenschapQuery);
        $stmtEigenschapDelete->bindParam(':houseID', $houseID, PDO::PARAM_INT);
        $stmtEigenschapDelete->execute();

        // Insert the new "liggingen" for the house
        $insertEigenschapQuery = "INSERT INTO house_eigenschappen (house_id, eigenschap_id) VALUES (:houseID, :eigenschapID)";
        $stmtEigenschapInsert = $verbinding->prepare($insertEigenschapQuery);
        $stmtEigenschapInsert->bindParam(':houseID', $houseID, PDO::PARAM_INT);

        // Loop through selected "ligging" values and insert them
        foreach ($selectedEigenschap as $eigenschapID) {
            $stmtEigenschapInsert->bindParam(':eigenschapID', $eigenschapID, PDO::PARAM_INT);
            $stmtEigenschapInsert->execute();
        }


        $uploadDirectory = '../../data/houseimages/house_' . $id . "/";
        $imgPath = $_FILES['imgPath']; // Retrieve the new img_path value

        if (!file_exists($uploadDirectory)) {
            mkdir($uploadDirectory, 0777, true);
        }

        // Update the img_path for the specified imageID
        $imagePaths = array();

        $newHouseID = $id;

        foreach ($_FILES['imgPath']['name'] as $key => $value) {
            if (!empty($_FILES['imgPath']['name'][$key])) {
                $uploadedFile = $_FILES['imgPath'];
                $extension = pathinfo($uploadedFile['name'][$key], PATHINFO_EXTENSION);
                $uniqueFilename = uniqid() . '_' . $key . '.' . $extension;
                $img_path = $uploadDirectory . $uniqueFilename;

                if (move_uploaded_file($uploadedFile['tmp_name'][$key], $img_path)) {
                    $img_path = $uniqueFilename;
                    $imagePaths[] = $img_path;

                    // Prepare and execute an INSERT query for each new image
                    $query2 = "INSERT INTO house_images (houseID, img_path) VALUES (?, ?)";
                    $stmt2 = $verbinding->prepare($query2);
                    $stmt2->execute([$newHouseID, $img_path]);

                    // Continue with any other image processing logic if needed
                }
            }
        }


        $_SESSION['message'] = "Update successful";
        header('Location: houses.php');

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>