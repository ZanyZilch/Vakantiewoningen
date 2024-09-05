<?php
session_start(); // Start the session
include('../RelevantAdmin/DBconfig.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Database Records with Bootstrap</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <!--  CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.rtl.min.css"
        integrity="sha384-DOXMLfHhQkvFFp+rWTZwVlPVqdIhpDVYT9csOnHSgWQWPX0v5MCGtjCJbY6ERspU" crossorigin="anonymous">
    <style>
        .box {
            padding: 20px;
            margin-top: 20px;
            display: flex;
            align-items: center;
            flex-direction: column;
            height: 100vh;
        }

        .centered {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 15%;
            height: 7vh
        }

        .btn-success {
            margin-top: 20px;
            width: 100% !important;
            height: 100% !important;
        }

        .display-8 {
            margin-top: 40px;
        }

        #arrowImg {
            margin-top: 20px;
            width: 100px;
            height: 100px;
        }

        
    </style>
</head>
<body>


<div class="container">
    <div class="row">
        <?php

        if (isset($_POST['assignUser']) && isset($_SESSION['USER_ID'])) {
            $houseIDToAssign = $_POST['houseID'];
            $userIDToAssign = $_SESSION['USER_ID'];

            $updateSql = "UPDATE house SET userID = :userid WHERE houseID = :houseid";
            $updateStmt = $verbinding->prepare($updateSql);
            $updateStmt->bindParam(':userid', $userIDToAssign, PDO::PARAM_INT);
            $updateStmt->bindParam(':houseid', $houseIDToAssign, PDO::PARAM_INT);

            try {
                $updateStmt->execute();
            } catch (PDOException $e) {
                echo "Error updating userID: " . $e->getMessage();
            }
        }

        if (isset($_POST['unassignUser']) && isset($_SESSION['USER_ID'])) {
            $houseIDToAssign = $_POST['houseID'];
            $userIDToAssign = $_SESSION['USER_ID'];

            $updateSql = "UPDATE house SET userID = NULL WHERE houseID = :houseid";
            $updateStmt = $verbinding->prepare($updateSql);
            $updateStmt->bindParam(':houseid', $houseIDToAssign, PDO::PARAM_INT);

            try {
                $updateStmt->execute();
            } catch (PDOException $e) {
                echo "Error updating userID: " . $e->getMessage();
            }
        }
        ?>
    </div>

    <div class="container">

</div>

<div class="col-md-12">
    <h3>Your Houses</h3>
    <div class="row">
        <?php
        // Fetch and display houses with the same user_ID
        $userHousesSql = "SELECT * FROM house WHERE userID = :user_id";
        $userHousesStmt = $verbinding->prepare($userHousesSql);
        $userHousesStmt->bindParam(':user_id', $_SESSION['USER_ID'], PDO::PARAM_INT);
        $userHousesStmt->execute();
        $userHousesResult = $userHousesStmt->fetchAll();

        $counter = 0; // Initialize a counter to keep track of the cards per row

        foreach ($userHousesResult as $row) {
            if ($counter % 3 == 0) {
                // Start a new row for every three cards
                echo '</div><div class="row">';
            }

            echo '<div class="col-md-4 mb-3">';
            echo '<div class="card">';

            // Card Header (Title)
            echo '<div class="card-header">' . $row['adress'] . '</div>';

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
            echo '</div>'; // Close the image grid
            echo '</div>'; // Close the container

            // Card Body (Description)
            echo '<div class="card-footer">';
            //echo '<p class="card-text">' . $row['description'] . '</p>';

            // Add a button with a form to view details
            echo '<form method="post">';
            echo '<a href="HouseDetail.php?id=' . $row['houseID'] . '" class="btn btn-text">View Details</a>';
            echo '</form>';

            echo '</div>';

            echo '</div>'; // Close the Card
            echo '</div>'; // Close the Column

            $counter++; // Increment the counter
        }
        ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<form id="search-form">
    <div class="input-group mb-3">
        <input type="text" name="search" id="search-input" class="form-control" placeholder="Search for house addresses" aria-label="Search for house addresses" aria-describedby="search-button">
        <div class="input-group-append">
            <button type="submit" class="btn btn-primary" id="search-button">Search</button>
        </div>
    </div>

    <div class="form-check">
        <input type="checkbox" class="form-check-input" id="search-owned">
        <label class="form-check-label" for="search-owned">Search Owned Houses</label>
    </div>
</form>

<div id="search-results"></div>


<script>
$(document).ready(function() {
    $('#search-form').submit(function(e) {
        e.preventDefault(); // Prevent form submission
        var searchQuery = $('#search-input').val();
        var searchOwned = $('#search-owned').is(':checked') ? 1 : 0; // 1 for owned, 0 for all

        $.ajax({
            type: 'GET',
            url: 'search.php',
            data: { search: searchQuery, owned: searchOwned },
            success: function(response) {
                $('#search-results').html(response);
            }
        });
    });
});
</script>


</div>
</body>
</html>