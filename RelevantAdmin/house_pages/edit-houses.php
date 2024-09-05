<?php
include('../DBconfig.php');
session_start();

if (!isset($_SESSION["ROL"])) {
    header("location: ../../index.php");
    exit();
}

if (isset($_GET['houseID'])) {
    $houseID = $_GET['houseID'];

    // Haal de gegevens van het geselecteerde huis op
    $query = "SELECT * FROM house WHERE houseID = :houseID";
    $stmt = $verbinding->prepare($query);
    $stmt->bindParam(':houseID', $houseID, PDO::PARAM_INT);
    $stmt->execute();
    $house = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vul de waarden in het bewerkingsformulier in
    $omschrijving = $house['omschrijving'];
    $adress = $house['adress'];
    $postcode = $house['postcode'];
    $provincie = $house['provincie'];
    $stad = $house['stad'];
    $prijs = $house['prijs'];
    // ... Vul de andere waarden in

} else {
    // Geen houseID in de URL
    echo "HouseID not set";
}
?>

<!doctype html>
<html lang="eng">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.rtl.min.css"
        integrity="sha384-DOXMLfHhQkvFFp+rWTZwVlPVqdIhpDVYT9csOnHSgWQWPX0v5MCGtjCJbY6ERspU" crossorigin="anonymous">
    <link rel="stylesheet" href="../../data/css/edit.css">
    <style>
        body {
            height: 100vh;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
    <title>Bewerk huizen</title>
</head>

<body>

    <?php
    if (isset($_GET['houseID'])) {
        $id = $_GET['houseID'];
        $stmt = $verbinding->prepare("SELECT * FROM house WHERE houseID = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $houses = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($houses) > 0) {
            $house = $houses[0];
  
            $imgQuery = "SELECT img_path, imageID FROM house_images";
            $stmtImg = $verbinding->prepare($imgQuery);
            $stmtImg->execute();
            $imgOptions = $stmtImg->fetchAll(PDO::FETCH_ASSOC);


            $selectedImg = array();
            $houseID = $house['houseID'];
            $selectedImgQuery = "SELECT img_path, imageID FROM house_images WHERE houseID = :houseID";
            $stmtSelectedImg = $verbinding->prepare($selectedImgQuery);
            $stmtSelectedImg->bindParam(':houseID', $houseID, PDO::PARAM_INT);
            $stmtSelectedImg->execute();
            $selectedImgRows = $stmtSelectedImg->fetchAll(PDO::FETCH_ASSOC);

            $selectedImages = array();

            foreach ($selectedImgRows as $imgRow) {
                $selectedImages[] = $imgRow['imageID'];
            }
            $eigenschapQuery = "SELECT eigenschapID, naam FROM eigenschappen";
            $stmtEigenschappen = $verbinding->prepare($eigenschapQuery);
            $stmtEigenschappen->execute();
            $eigenschapOptions = $stmtEigenschappen->fetchAll(PDO::FETCH_ASSOC);

            $selectedEigenschappen = array();
            $houseID = $house['houseID'];
            $selectedEigenschapQuery = "SELECT eigenschap_id FROM house_eigenschappen WHERE house_id = :houseID";
            $stmtSelectedEigenschap = $verbinding->prepare($selectedEigenschapQuery);
            $stmtSelectedEigenschap->bindParam(':houseID', $houseID, PDO::PARAM_INT);
            $stmtSelectedEigenschap->execute();
            $selectedEigenschappenRows = $stmtSelectedEigenschap->fetchAll(PDO::FETCH_ASSOC);

            foreach ($selectedEigenschappenRows as $rowEigenschap) {
                $selectedEigenschappen[] = $rowEigenschap['eigenschap_id'];
            }

            $liggingQuery = "SELECT liggingID, naam FROM ligging";
            $stmtLigging = $verbinding->prepare($liggingQuery);
            $stmtLigging->execute();
            $liggingOptions = $stmtLigging->fetchAll(PDO::FETCH_ASSOC);

            $selectedLiggingen = array();
            $houseID = $house['houseID'];
            $selectedLiggingQuery = "SELECT ligging_id FROM house_ligging WHERE house_id = :houseID";
            $stmtSelectedLigging = $verbinding->prepare($selectedLiggingQuery);
            $stmtSelectedLigging->bindParam(':houseID', $houseID, PDO::PARAM_INT);
            $stmtSelectedLigging->execute();
            $selectedLiggingenRows = $stmtSelectedLigging->fetchAll(PDO::FETCH_ASSOC);

            foreach ($selectedLiggingenRows as $row) {
                $selectedLiggingen[] = $row['ligging_id'];
            }

            // Retrieve makelaarNaam
            $makelaarID = $house['userID'];
            $makelaarQuery = "SELECT username FROM users WHERE userID = :userID";
            $stmtMakelaar = $verbinding->prepare($makelaarQuery);
            $stmtMakelaar->bindParam(':userID', $makelaarID);
            $stmtMakelaar->execute();
            $makelaarResult = $stmtMakelaar->fetch(PDO::FETCH_ASSOC);
            $makelaarNaam = $makelaarResult['username'];

            // Retrieve imgPath
            $houseID = $house['houseID'];
            $imgQuery = "SELECT img_path FROM house_images WHERE houseID = :houseID";
            $stmtImg = $verbinding->prepare($imgQuery);
            $stmtImg->bindParam(':houseID', $houseID);
            $stmtImg->execute();
            $imgResult = $stmtImg->fetch(PDO::FETCH_ASSOC);

            if ($imgResult !== false) {
                $imgPath = $imgResult['img_path'];
            } else {

            }


            // Fetch a list of all makelaars
            $makelaarListQuery = "SELECT rol, userID, username FROM users where rol = 1";
            $stmtMakelaarList = $verbinding->prepare($makelaarListQuery);
            $stmtMakelaarList->execute();
            $makelaarList = $stmtMakelaarList->fetchAll(PDO::FETCH_ASSOC);

            // Fetch a list of all makelaars
            $houseID = $house['houseID'];
            $imgQuery = "SELECT houseID, img_path, imageID FROM house_images WHERE houseID = :houseID";
            $stmtImg = $verbinding->prepare($imgQuery);
            $stmtImg->bindParam(':houseID', $houseID, PDO::PARAM_INT);
            $stmtImg->execute();
            $imgList = $stmtImg->fetchAll(PDO::FETCH_ASSOC);




        } else {
            // Handle case where no house is found
            echo "<h4>Niks gevonden</h4>";
        }
    } else {
        // Handle case where 'houseID' is not set
        echo "<h4>HouseID not set</h4>";
    }
    ?>
    <div class="liggingGroup">
        <button id="openForm">Ligging toevoegen</button>
        <div id="liggingForm" style="display: none;">
            <form action="insert_ligging.php?houseID=<?= $house['houseID']; ?>" method="post">
                <label for="liggingName">Ligging naam:</label>
                <input type="text" name="liggingName" required>
                <button type="submit" name="submit">Toevoegen</button>
            </form>
        </div>

        <button id="openDeleteForm">Ligging verwijderen</button>

        <div id="deleteForm" style="display: none;">
            <form action="delete_ligging.php?houseID=<?= $house['houseID']; ?>" method="post">
                <select class="form-control" name="liggingID[]" multiple>
                    <?php foreach ($liggingOptions as $liggingOption): ?>
                        <option value="<?= $liggingOption['liggingID']; ?>" <?php if (in_array($liggingOption['liggingID'], $selectedLiggingen))
                              echo 'selected'; ?>>
                            <?= $liggingOption['naam']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <button type="submit" name="submit">Verwijderen</button>
            </form>
        </div>

        <button id="openEigenschapForm">Eigenschap toevoegen</button>

        <div id="eigenschapForm" style="display: none;">
            <form action="insert_eigenschap.php?houseID=<?= $house['houseID']; ?>" method="post">
                <label for="eigenschapName">Eigenschap naam:</label> <!-- Corrected label -->
                <input type="text" name="eigenschapName" required>
                <button type="submit" name="submit">Toevoegen</button>
            </form>
        </div>

        <button id="openEigenschapDeleteForm">Eigenschap verwijderen</button>

        <div id="deleteEigenschapForm" style="display: none;">
            <form action="delete_eigenschap.php?houseID=<?= $house['houseID']; ?>" method="post">
                <select class="form-control" name="eigenschapID[]" multiple>
                    <?php foreach ($eigenschapOptions as $eigenschapOption): ?>
                        <option value="<?= $eigenschapOption['eigenschapID']; ?>" <?php if (in_array($eigenschapOption['eigenschapID'], $selectedEigenschappen))
                              echo 'selected'; ?>>
                            <?= $eigenschapOption['naam']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <button type="submit" name="submit">Verwijderen</button>
            </form>
        </div>

        <button id="openImgForm">Afbeeldingen verwijderen</button>

        <div id="imgForm" style="display: none;">
            <form action="delete_image.php?houseID=<?= $house['houseID']; ?>" method="post">
                <select class="form-control" name="deleteID[]" multiple>
                    <?php foreach ($selectedImgRows as $imgOption): ?>
                        <option value="<?= $imgOption['imageID']; ?>">
                            <?= $imgOption['img_path']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <button type="submit" name="submit">Verwijderen</button>
            </form>
        </div>



    </div>


    <div class="bulkMain">
        <h1>Bewerk huis</h1>
        <form enctype="multipart/form-data" class="bewerk-form" name="Bewerken" action="bewerk_house.php" method="POST">
            <input type="hidden" name="id" value="<?= $house['houseID']; ?>" />
            <input type="hidden" id="img_filename" name="img_filename" value="">
            <div class="form-group">
                <label for="omschrijving">Omschrijving:</label>
                <textarea class="form-control" name="omschrijving"><?= $house['omschrijving']; ?></textarea><br>
            </div>
            <div class="form-group">
                <label for="email">Adress:</label>
                <input type="text" required class="form-control" name="adress" value="<?= $house['adress']; ?>" /><br>
            </div>
            <div class="form-group">
                <label for="postcode">Postcode:</label>
                <input type="text" required class="form-control" name="postcode"
                    value="<?= $house['postcode']; ?>" /><br>
            </div>
            <div class="form-group">
                <label for="provincie">Provincie:</label>
                <input type="text" required class="form-control" name="provincie"
                    value="<?= $house['provincie']; ?>" /><br>
            </div>
            <div class="form-group">
                <label for="stad">Stad:</label>
                <input type="text" required class="form-control" name="stad" value="<?= $house['stad']; ?>" /><br>
            </div>
            <div class="form-group">
                <label for="ligging">Ligging:</label>
                <select class="form-control" name="ligging[]" multiple>
                    <?php foreach ($liggingOptions as $liggingOption): ?>
                        <option value="<?= $liggingOption['liggingID']; ?>" <?php if (in_array($liggingOption['liggingID'], $selectedLiggingen))
                              echo 'selected'; ?>>
                            <?= $liggingOption['naam']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="eigenschap">Eigenschappen:</label>
                <select class="form-control" name="eigenschap[]" multiple>
                    <?php foreach ($eigenschapOptions as $eigenschapOption): ?>
                        <option value="<?= $eigenschapOption['eigenschapID']; ?>" <?php if (in_array($eigenschapOption['eigenschapID'], $selectedEigenschappen))
                              echo 'selected'; ?>>
                            <?= $eigenschapOption['naam']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="prijs">prijs:</label>
                <input type="text" required class="form-control" name="prijs" value="<?= $house['prijs']; ?>" /><br>
            </div>
            <div class="form-group">
                <label for="makelaar">Makelaar:</label>
                <select class="form-control" name="makelaar">
                    <?php foreach ($makelaarList as $agent): ?>
                        <?php if ($agent['rol'] == 1): ?>
                            <option value="<?= $agent['userID'] ?>" <?= ($agent['userID'] == $makelaarID) ? 'selected' : '' ?>>
                                <?= $agent['username'] ?>
                            </option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Status:</label><br>
                <input type="radio" name="verkocht" value="0" <?= ($house['verkocht'] == 0) ? 'checked' : ''; ?> /> Te
                koop<br>
                <input type="radio" name="verkocht" value="1" <?= ($house['verkocht'] == 1) ? 'checked' : ''; ?> />
                Verkocht
            </div>


            <br>
            <div class="form-group">
                <label for="img_path">Upload foto:</label>
                <input type="file" class="form-control-file" id="imgPath" name="imgPath[]" accept="image/*" multiple>
            </div>
            <br>
            <button type="submit" name="submit" value="submit" class="btn btn-primary">Bewerken</button>
            <a href="houses.php" class="btn btn-primary">Huizen</a>
        </form>
        <script type="text/javascript" src="../script.js"></script>
</body>

</html>