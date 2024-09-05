<?php
include('../DBconfig.php');

$directoryPath = "../../data/houseimages/"; // Specify your directory path

if (isset($_POST['delete_btn'])) {
    $id = $_POST['delete_id'];

    // First, retrieve the image paths associated with the house you're about to delete
    $sqlSelectImages = "SELECT img_path FROM house_images WHERE houseID = :id";
    $stmtSelectImages = $verbinding->prepare($sqlSelectImages);
    $stmtSelectImages->bindParam(':id', $id, PDO::PARAM_INT);
    $stmtSelectImages->execute();
    $imagePaths = $stmtSelectImages->fetchAll(PDO::FETCH_COLUMN, 0);

        // Delete the image files from your specified directory
        $uploadDirectory = '../../data/houseimages/house_' . $id;

        if (is_dir($uploadDirectory)) {
            // Controleer of de map bestaat
            $files = glob($uploadDirectory . '/*'); // Verkrijg een lijst van bestanden in de map
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file); // Verwijder individuele bestanden in de map
                }
            }
        
            if (rmdir($uploadDirectory)) {
                echo "Map is verwijderd: " . $uploadDirectory;
            } else {
                echo "Fout bij het verwijderen van de map: " . $uploadDirectory;
            }
        } else {
            echo "Map bestaat niet: " . $uploadDirectory;
        }

        // Delete the image records from the 'house_images' table
        $sqlDeleteImages = "DELETE FROM house_images WHERE houseID = :id";
        $stmtDeleteImages = $verbinding->prepare($sqlDeleteImages);
        $stmtDeleteImages->bindParam(':id', $id, PDO::PARAM_INT);
        $query_imgRun = $stmtDeleteImages->execute();

        // First, delete records in house_ligging
        $queryDeleteLigging = "DELETE FROM house_ligging WHERE house_id = :id";
        $stmtDeleteLigging = $verbinding->prepare($queryDeleteLigging);
        $stmtDeleteLigging->bindParam(':id', $id, PDO::PARAM_INT);
        $ligging_Run = $stmtDeleteLigging->execute();

        // First, delete records in house_eigenschappen
        $queryDeleteEigenschap = "DELETE FROM house_eigenschappen WHERE house_id = :id";
        $stmtDeleteEigenschap = $verbinding->prepare($queryDeleteEigenschap);
        $stmtDeleteEigenschap->bindParam(':id', $id, PDO::PARAM_INT);
        $Eigenschap_Run = $stmtDeleteEigenschap->execute();

        // Delete the record from the 'house' table
        $sqlDeleteHouse = "DELETE FROM house WHERE houseID = :id";
        $stmtDeleteHouse = $verbinding->prepare($sqlDeleteHouse);
        $stmtDeleteHouse->bindParam(':id', $id, PDO::PARAM_INT);
        $query_run = $stmtDeleteHouse->execute();

    if ($query_run && $query_imgRun && $ligging_Run && $Eigenschap_Run) {
        $_SESSION['message'] = "Your Data and Images are Deleted";
        header('Location: houses.php');
    } else {
        $_SESSION['message'] = "Your Data and/or Images are NOT DELETED";
        header('Location: houses.php');
    }
}
?>