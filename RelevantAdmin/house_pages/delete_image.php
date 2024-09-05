<?php
include('../DBconfig.php');

if (isset($_POST['submit'])) {
    try {
        // Get the array of image IDs to delete
        $imgIDs = $_POST['deleteID'];
        $houseID = $_GET["houseID"];

        // Define the directory where your images are stored
        $uploadDirectory = '../../data/houseimages/house_' . $houseID . "/";

        foreach ($imgIDs as $imgID) {
            // Fetch the image filename from the database
            $selectQuery = "SELECT img_path FROM house_images WHERE imageID = :imgID";
            $stmt = $verbinding->prepare($selectQuery);
            $stmt->bindParam(':imgID', $imgID, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $filename = $result['img_path'];
                $filepath = $uploadDirectory . $filename;

                // Delete the file from the file system
                if (file_exists($filepath) && unlink($filepath)) {
                    // Delete the database record for this image
                    $deleteQuery = "DELETE FROM house_images WHERE imageID = :imgID";
                    $stmt = $verbinding->prepare($deleteQuery);
                    $stmt->bindParam(':imgID', $imgID, PDO::PARAM_INT);
                    $stmt->execute();
                }
            }
        }

        // Redirect to the edit page
        header('Location: edit-houses.php?houseID=' . $houseID);
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
