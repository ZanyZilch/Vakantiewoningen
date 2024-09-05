<?php
session_start();
include_once('../RelevantAdmin/DBconfig.php');



if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $owned = $_GET['owned'];

    // Modify your SQL query to filter based on the $search value and ownership status
    if ($owned == 1) {
        $availableHousesSql = "SELECT * FROM house WHERE userID = :user_id AND adress LIKE :search";
    } else {
        $availableHousesSql = "SELECT * FROM house WHERE adress LIKE :search";
    }

    $availableHousesStmt = $verbinding->prepare($availableHousesSql);
    $availableHousesStmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    if ($owned == 1) {
        $availableHousesStmt->bindParam(':user_id', $_SESSION['USER_ID'], PDO::PARAM_INT);
    }
    $availableHousesStmt->execute();
    $availableHousesResult = $availableHousesStmt->fetchAll();


    $counter = 0;
    // Display search results
    foreach ($availableHousesResult as $row) {
        if ($counter % 3 == 0) {
            // Start a new row for every three cards
            echo '</div><div class="row">';
        }

        echo '<div class="col-md-4 mb-3">';
        echo '<div class="card">';


        // Container for Image Grid
        echo '<div class="card-body" style="max-width: 300px; max-height: 300px; overflow: auto;">';
        echo '<div class="image-grid">';

        // Fetch images from house_images for the current house
        $houseID = $row['houseID'];
        $imageQuery = "SELECT img_path FROM house_images WHERE houseID = :houseID";
        $imageStmt = $verbinding->prepare($imageQuery);
        $imageStmt->bindParam(':houseID', $houseID, PDO::PARAM_INT);
        $imageStmt->execute();
        $houseImages = $imageStmt->fetchAll();

        // Display the first image
        if (!empty($houseImages)) {
            echo '<img src="../data/houseimages/house_' . $houseID . '/' . $houseImages[0]['img_path'] . '" class="img-thumbnail" alt="House Image">';
        }

        echo '</div>';
        echo '</div>';

        echo '<h5 class="card-title">' . $row['adress'] . '</h5>';
        echo '<p class="card-text">' . $row['postcode'] . '<br>'  . $row['provincie'] . ', '. $row['stad'] . '</p>';

        // Add a button with a form to assign the house to the current user
        echo '<form method="post">';
        echo '<input type="hidden" name="houseID" value="' . $houseID . '">';
        if ($_SESSION['USER_ID'] == $row['userID']) {
            echo '<button type="submit" name="unassignUser" class="btn btn-danger">Unassign</button>';
        } else {
            echo '<button type="submit" name="assignUser" class="btn btn-primary">Assign to Me</button>';
        }
        echo '<a href="HouseDetail.php?houseID=' . $houseID . '" class="btn btn-text">View Details</a>';
        echo '</form>';
        

        echo '</div>'; // Close the Card
        echo '</div>'; // Close the Column

        $counter++; // Increment the counter
    }
}
?>
