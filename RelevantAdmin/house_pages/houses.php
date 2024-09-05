<?php
include('../DBconfig.php');
session_start();

if (!isset($_SESSION["ROL"])) {
	echo "hoi";
	header("location: ../../home.php");
	exit();
}
?>

<!doctype html>
<html lang="eng">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!--  CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.rtl.min.css"
		integrity="sha384-DOXMLfHhQkvFFp+rWTZwVlPVqdIhpDVYT9csOnHSgWQWPX0v5MCGtjCJbY6ERspU" crossorigin="anonymous">
	<link rel="stylesheet" href="../css/display.css">
	<title>Adminpanel</title>
</head>

<body>
	<div class="top-left-items" style="display: flex; flex-direction: column;">
	</div>

	<?php
	$query = "SELECT * FROM house";
	$stmt = $verbinding->prepare($query);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

	?>

	<div class="container">
		<div class="box">
			<h4 class="display-4 text-center">Huizen</h4><br>
			<form method="post" action="add_house.php">
				<button type="submit" name="submit" class="btn btn-primary">Huis toevoegen</button>
			</form>




			<table class="table table-striped">
				<thead>
					<tr>

						<th scope="col">Omschrijving</th>
						<th scope="col">Adress</th>
						<th scope="col">Postcode</th>
						<th scope="col">Provincie</th>
						<th scope="col">Stad</th>
						<th scope="col">Prijs</th>
						<th scope="col">Ligging</th>
						<th scope="col">Eigenschappen</th>
						<th scope="col">MakelaarNaam</th>
						<th scope="col">Status</th>

					</tr>
				</thead>
				<tbody>
					<?php
					// For-loop gaan we veranderen voor een foreach-loop om door de DB data heen te gaan
					foreach ($result as $value) {
						$makelaarID = $value['userID'];
						$makelaarQuery = "SELECT username FROM users WHERE userID = :userID";
						$stmtMakelaar = $verbinding->prepare($makelaarQuery);
						$stmtMakelaar->bindParam(':userID', $makelaarID);
						$stmtMakelaar->execute();
						$makelaarResult = $stmtMakelaar->fetch(PDO::FETCH_ASSOC);

						if ($makelaarResult) {
							// Controleer of er resultaten zijn voordat je de waarde ophaalt
							$makelaarNaam = $makelaarResult['username'];
						} else {
							// Geen resultaten gevonden, doe hier iets anders
							$makelaarNaam = "Geen makelaar gevonden";
						}

						$houseID = $value['houseID'];
						$imgQuery = "SELECT img_path FROM house_images WHERE houseID = :houseID";
						$stmtImg = $verbinding->prepare($imgQuery);
						$stmtImg->bindParam(':houseID', $houseID);
						$stmtImg->execute();
						$imgResult = $stmtImg->fetch(PDO::FETCH_ASSOC);

						if ($imgResult !== false) {
							$imgPath = $imgResult['img_path'];
						} else {

						}

						$houseID = $value['houseID'];
						$liggingQuery = "SELECT ligging.naam
										FROM house_ligging
										JOIN ligging ON house_ligging.ligging_id = ligging.liggingID
										WHERE house_ligging.house_id = :houseID";
						$stmtLigging = $verbinding->prepare($liggingQuery);
						$stmtLigging->bindParam(':houseID', $houseID);
						$stmtLigging->execute();
						$liggingResult = $stmtLigging->fetchAll(PDO::FETCH_ASSOC);

						$houseID = $value['houseID'];
						$eigenschappenQuery = "SELECT eigenschappen.naam
										FROM house_eigenschappen
										JOIN eigenschappen ON house_eigenschappen.eigenschap_id = eigenschappen.eigenschapID
										WHERE house_eigenschappen.house_id = :houseID";
						$stmtEigenschappen = $verbinding->prepare($eigenschappenQuery);
						$stmtEigenschappen->bindParam(':houseID', $houseID);
						$stmtEigenschappen->execute();
						$eigenschappenResult = $stmtEigenschappen->fetchAll(PDO::FETCH_ASSOC);

						$verkocht = ($value['verkocht'] == 1) ? "Verkocht" : "Te koop";
						?>
						<tr>

							<td>
								<?= $value['omschrijving']; ?>
							</td>
							<td>
								<?= $value['adress']; ?>
							</td>
							<td>
								<?= $value['postcode']; ?>
							</td>
							<td>
								<?= $value['provincie']; ?>
							</td>
							<td>
								<?= $value['stad']; ?>
							</td>
							<td>
								<?= $value['prijs']; ?>
							</td>
							<td>
								<?php
								foreach ($liggingResult as $ligging) {
									echo $ligging['naam'] . '<br>';
								}
								?>
							</td>
							<td>
								<?php
								foreach ($eigenschappenResult as $eigenschap) {
									echo $eigenschap['naam'] . '<br>';
								}
								?>
							</td>
							<td>
								<?= $makelaarNaam ?>
							</td>
							<td>
								<?= $verkocht ?>
							</td>

							<td><a href="edit-houses.php?houseID=<?= $value['houseID']; ?>">
									<button class="btn btn-success">Bewerk</button>
								</a>

								<form action="verwijder.php" method="post">
									<input type="hidden" name="delete_id" value="<?php echo $value['houseID']; ?>">
									<button class="btn btn-danger" name="delete_btn" type="submit">Verwijder</button>
								</form>

							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
			<form>
				<?php
				if (isset($_SESSION["ROL"]) && $_SESSION["ROL"] != 1) { ?>
					<a href="../index.php" class="btn btn-primary">Terug naar adminpanel</a>
				<?php } ?>
				<?php
				if (isset($_SESSION["ROL"]) && $_SESSION["ROL"] != 0) { ?>
					<a href="../../index.php" class="btn btn-primary">Terug naar homepagina</a>
				<?php } ?>
			</form>


		</div>
	</div>







</body>

</html>