<?php
session_start();
require_once("../RelevantAdmin/DBconfig.php");

$eigenschappenSQL = "SELECT * FROM eigenschappen";
$eigenschappenStmt = $verbinding->prepare($eigenschappenSQL);
$eigenschappenStmt->execute();
$eigenschappenResult = $eigenschappenStmt->fetchAll(PDO::FETCH_ASSOC);

$locatiesSQL = "SELECT * FROM ligging";
$locatiesStmt = $verbinding->prepare($locatiesSQL);
$locatiesStmt->execute();
$locatiesResult = $locatiesStmt->fetchAll(PDO::FETCH_ASSOC);

$query = "SELECT * FROM house";
$stmt = $verbinding->prepare($query);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM house";

if (isset($_GET['filters'])) {
    $filterClauses = array();

    foreach ($_GET['filters'] as $eigenschapID => $waarde) {
        if (is_numeric($eigenschapID)) {
            $filterClauses[] = "EXISTS (SELECT 1 FROM house_eigenschappen WHERE house_id = house.houseID AND eigenschap_id = " . (int)$eigenschapID . ")";
        }
    }

    if (!empty($filterClauses)) {
        $filterSQL = implode(" AND ", $filterClauses);
        $sql .= " WHERE $filterSQL";
    }
}

if (isset($_GET['locatiefilters'])) {
    $locatiefilters = $_GET['locatiefilters'];
    $locatieClauses = array();
    foreach ($locatiefilters as $locatie) {
        if (is_numeric($locatie)) {
            $locatieClauses[] = "EXISTS (SELECT 1 FROM house_ligging WHERE house_id = house.houseID AND ligging_id = " . (int)$locatie . ")";
        }
    }

    if (!empty($locatieClauses)) {
        $locatieSQL = implode(" AND ", $locatieClauses);
        if (!empty($filterClauses)) {
            $sql .= " AND $locatieSQL";
        } else {
            $sql .= " WHERE $locatieSQL";
        }
    }
}

try {
    $stmt = $verbinding->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Er is een fout opgetreden: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" href="../data/img/favicon.png" type="image/png">
    <link rel="stylesheet" href="../data/css/main.css">
    <link rel="stylesheet" href="../data/css/huizen.css">
    <script defer src="../data/js/main.js"></script>
    <script defer src="https://kit.fontawesome.com/769fs05a054.js" crossorigin="anonymous"></script>
    <title>Huizen</title>
</head>
<body>
    <img class="topright" src="../data/img/topright.png">
    <header>
        <div class="items">
            <a href="#" class="title">Vakantiewoningen</a>
            <ul>
                <a href="../index.php">Home</a>
                <a href="../pages/huizen.php">Huizen</a>
                <?php if (isset($_SESSION["ROL"]) && $_SESSION["ROL"] != 0) { ?>
                    <a href="../RelevantAdmin/house_pages/houses.php">Bewerk huis</a>
                    <a href="../pages/openhuizen.php">Mijn Huizen</a>
                    <a href="../pages/logout.php">Afmelden</a>
                <?php } ?>
                <?php if (isset($_SESSION["ROL"]) && $_SESSION["ROL"] != 1) { ?>
                    <a href="../RelevantAdmin/index.php">Admin panel</a>
                    <a href="../pages/logout.php">Afmelden</a>
                <?php } ?>
                <?php if (!isset($_SESSION["ROL"])) { ?>
                    <a href="../pages/inlog_page.php">Log in</a>
                <?php } ?>
            </ul>
        </div>
    </header>
    
    <div class="container">
        <!-- Filters aan de linkerkant -->
        <div class="filters">
            <h3>Filters:</h3>
            <form method="get">
                <?php foreach ($eigenschappenResult as $eigenschap) : ?>
                    <label>
                        <input type="checkbox" name="filters[<?= $eigenschap['eigenschapID'] ?>" value="1" <?php if(isset($_GET['filters'][$eigenschap['eigenschapID']])) echo 'checked'; ?>>
                        <?= $eigenschap['naam'] ?>
                    </label>
                <?php endforeach; ?>

                <h3>Ligging:</h3>
                <?php foreach ($locatiesResult as $locatie) : ?>
                    <label>
                        <input type="checkbox" name="locatiefilters[]" value="<?= $locatie['liggingID'] ?>" <?php if(in_array($locatie['liggingID'], (isset($_GET['locatiefilters']) ? $_GET['locatiefilters'] : []))) echo 'checked'; ?>>
                        <?= $locatie['naam'] ?>
                    </label>
                <?php endforeach; ?>
                <button type="submit">Filter toepassen</button>
                <button type="button" onclick="resetFilters()">Reset</button>
            </form>
        </div>

        <div class="container">
            <?php if (!empty($result)) : ?>
                <?php foreach ($result as $value): ?>
                    <div class="house">
                        <div class="left">
                            <?php
                                $houseID = $value["houseID"];
                                $imageQuery = "SELECT img_path FROM house_images WHERE houseID = :houseID";
                                $imageStmt = $verbinding->prepare($imageQuery);
                                $imageStmt->bindParam(':houseID', $houseID, PDO::PARAM_INT);
                                $imageStmt->execute();
                                $imageResult = $imageStmt->fetchAll(PDO::FETCH_ASSOC);
                                if (!$imageResult) {
                                    echo "<a href='HouseDetail.php?houseID=" . $houseID . "'><img class='houseimage' src='../data/houseimages/default.jpg" . "'></a>";
                                } else {
                                echo "<a href='HouseDetail.php?houseID=" . $houseID . "'><img class='houseimage' src='../data/houseimages/house_" . $houseID . '/' . $imageResult[0]["img_path"] . "'></a>";
                                }
                            ?>
                        </div>
                        <div class="right">
                            <h2><?php echo $value["omschrijving"]; ?></h2>
                             <span><?php echo $value["adress"]; ?>, <?php echo $value["stad"]; ?><p style='font-weight: bold;'>€<?php echo number_format($value["prijs"], 2, ',', '.'); ?> n.o.t.k</p></span>
                            <a class="check" href="HouseDetail.php?houseID=<?php echo $houseID ?>">Bekijk</a>
                            <br>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>Geen resultaten gevonden.</p>
            <?php endif; ?>
        </div>
    </div>
    <script>
        function resetFilters() {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = false;
            });

            document.querySelector('form').submit();
        }
    </script>
</body>
</html>
