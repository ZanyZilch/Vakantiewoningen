<?php
include "../DBconfig.php";
session_start();

if (!isset($_SESSION["ROL"])) {
    echo "hoi";
    header("location: ../../index.php");
    exit();
}

$liggingQuery = "SELECT liggingID, naam FROM ligging";
$stmtLigging = $verbinding->prepare($liggingQuery);
$stmtLigging->execute();
$liggingOptions = $stmtLigging->fetchAll(PDO::FETCH_ASSOC);

$eigenschapQuery = "SELECT eigenschapID, naam FROM eigenschappen";
$stmteigenschap = $verbinding->prepare($eigenschapQuery);
$stmteigenschap->execute();
$eigenschapOptions = $stmteigenschap->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="eng">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.rtl.min.css"
        integrity="sha384-DOXMLfHhQkvFFp+rWTZwVlPVqdIhpDVYT9csOnHSgWQWPX0v5MCGtjCJbY6ERspU" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/edit.css">

    <style>
        body {
            height: 100vh;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
    <title>Gebruiker toevoegen</title>
</head>

<body>

    <div class="bulkMain">
        <h1>Huis toevoegen</h1>
        <form action="register_house.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?=
                $query = "SELECT * FROM house";
            $stmt = $verbinding->prepare($query);
            $stmt->execute();
            $house = $stmt->fetch(PDO::FETCH_ASSOC);
            ?>">
            <input type="hidden" name="id" value="<?= $house['houseID']; ?>">
            <input type="hidden" id="img_filename" name="img_filename" value="">
            <div class="form-group">
                <label for="username">Omschrijving:</label>
                <input type="text" class="form-control" id="omschrijving" name="omschrijving" required>
            </div>
            <div class="form-group">
                <label for="email">Adress:</label>
                <input type="text" class="form-control" id="adress" name="adress" required>
            </div>
            <div class="form-group">
                <label for="email">Postcode:</label>
                <input type="text" class="form-control" id="postcode" name="postcode" required>
            </div>
            <div class="form-group">
                <label for="email">Provincie:</label>
                <input type="text" class="form-control" id="provincie" name="provincie" required>
            </div>
            <div class="form-group">
                <label for="email">Stad:</label>
                <input type="text" class="form-control" id="stad" name="stad" required>
            </div>
            <div class="form-group">
                <label for="ligging">Ligging:</label>
                <select class="form-control" name="ligging[]" multiple>
                    <?php
                    $selectedLiggingen = [];
                    foreach ($liggingOptions as $liggingOption): ?>
                        <option value="<?= $liggingOption['liggingID']; ?>" <?php if (in_array($liggingOption['liggingID'], $selectedLiggingen))
                              echo 'selected'; ?>>
                            <?= $liggingOption['naam']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="ligging">Eigenschap:</label>
                <select class="form-control" name="eigenschappen[]" multiple>
                    <?php
                    $selectedEigenschappen = [];
                    foreach ($eigenschapOptions as $eigenschapOption): ?>
                        <option value="<?= $eigenschapOption['eigenschapID']; ?>" <?php if (in_array($eigenschapOption['eigenschapID'], $selectedEigenschappen))
                              echo 'selected'; ?>>
                            <?= $eigenschapOption['naam']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="email">Prijs:</label>
                <input type="number" class="form-control" id="prijs" name="prijs" required>
            </div>
            <div class="form-group">
                <label for="img_path">Image Upload (Multiple):</label>
                <input type="file" class="form-control-file" id="img_path" name="img_path[]" accept="image/*" multiple
                    required>
            </div>

            <div id="file-path-display"></div>
            <div class="form-group">
                <label for="makelaar">Makelaar:</label>
                <select class="form-control" name="makelaar" id="makelaar">
                    <?php
                    // Fetch user data from the 'users' table
                    $sql = "SELECT userID, username FROM users WHERE ROL = 1";
                    $stmt = $verbinding->query($sql);
                    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    // Iterate through the user data and create options
                    foreach ($users as $user) {
                        echo '<option value="' . $user['userID'] . '">' . $user['username'] . '</option>';
                    }
                    ?>
                </select>
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Toevoegen</button>
        </form>
    </div>
</body>

</html>

<script>
    // Add an event listener to the file input
    document.getElementById('img_path').addEventListener('change', function () {
        // Get the selected file's path and display it
        const filePath = this.value;
        document.getElementById('file-path-display').textContent = "Selected file path: " + filePath;

        // Extract and set the filename in the hidden input
        const fileInput = this;
        const filename = fileInput.files[0] ? fileInput.files[0].name : '';
        document.getElementById('img_filename').value = filePath;
    });
</script>