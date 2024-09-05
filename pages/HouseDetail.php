<?php
session_start();
require_once("../RelevantAdmin/DBconfig.php");
require('../data/fpdf/fpdf.php');

// Controleer of het houseID is meegegeven via de URL
if (isset($_GET['houseID'])) {
	$houseID = $_GET['houseID'];


	$query = "SELECT * FROM house WHERE houseID = :houseID";
	$stmt = $verbinding->prepare($query);
	$stmt->bindParam(':houseID', $houseID, PDO::PARAM_INT);
	$stmt->execute();
	$housedata = $stmt->fetch(PDO::FETCH_ASSOC);

	$imageQuery = "SELECT img_path FROM house_images WHERE houseID = :houseID";
	$imageStmt = $verbinding->prepare($imageQuery);
	$imageStmt->bindParam(':houseID', $houseID, PDO::PARAM_INT);
	$imageStmt->execute();
	$imageResult = $imageStmt->fetchAll(PDO::FETCH_ASSOC);

	$userQuery = "SELECT * FROM users WHERE userID = :userID";
	$userStmt = $verbinding->prepare($userQuery);
	$userStmt->bindParam(':userID', $housedata['userID'], PDO::PARAM_INT);
	$userStmt->execute();
	$userdata = $userStmt->fetch(PDO::FETCH_ASSOC);

	// Query voor ligging 

	$liggingQuery = "SELECT naam FROM ligging WHERE liggingID IN 
                     (SELECT ligging_id FROM house_ligging WHERE house_id = :houseID)";
	$liggingStmt = $verbinding->prepare($liggingQuery);
	$liggingStmt->bindParam(':houseID', $houseID, PDO::PARAM_INT);
	$liggingStmt->execute();
	$liggingData = $liggingStmt->fetchAll(PDO::FETCH_ASSOC);

	// Query voor eigenschappen
	$eigenschappenQuery = "SELECT naam FROM eigenschappen WHERE eigenschapID IN 
	 (SELECT eigenschap_id FROM house_eigenschappen WHERE house_id = :houseID)";
	$eigenschappenStmt = $verbinding->prepare($eigenschappenQuery);
	$eigenschappenStmt->bindParam(':houseID', $houseID, PDO::PARAM_INT);
	$eigenschappenStmt->execute();
	$eigenschappenData = $eigenschappenStmt->fetchAll(PDO::FETCH_ASSOC);
} else {
	header("Location: huizen.php");
}
if (isset($_POST['generate_pdf'])) {
	$pdf = new FPDF();
	$pdf->AddPage('P', array(210, 297));
	$pdf->SetFillColor(227, 228, 229);
	$pdf->Rect(0, 0, 210, 297, 'F');
	$pdf->SetFont('Arial', 'B', 10);
	$pdf->SetTextColor(0, 0, 0);
	$omschrijving = $housedata['omschrijving'];
	$omschrijvingParts = str_split($omschrijving, 100);
	foreach ($omschrijvingParts as $part) {
		$pdf->Cell(0, 10, $part, 0, 1, 'C');
	}
	$pdf->SetFont('Arial', 'I', 12);
	$pdf->Cell(0, 10, $housedata['adress'] . ', ' . $housedata['stad'], 0, 1, 'C');
	$pdf->SetFont('Arial', 'B', 12);
	$pdf->Cell(0, 10, 'Postcode: ' . $housedata['postcode'], 0, 1, 'C');
	$pdf->Cell(0, 10, 'Provincie: ' . $housedata['provincie'], 0, 1, 'C');
	$pdf->SetFont('Arial', 'B', 12);
	$priceFormatted = number_format($housedata['prijs'], 0, ',', '.'); // Formatteer de prijs
	$pdf->Cell(0, 10, iconv('UTF-8', 'windows-1252', '€') . ' ' . $priceFormatted, 0, 1, 'C');
	$pdf->SetFont('Arial', 'B', 12);
	$pdf->Cell(0, 10, 'Makelaar:', 0, 1, 'L');
	$pdf->SetFont('Arial', '', 12);
	$pdf->Cell(0, 10, $userdata['username'], 0, 1, 'L');
	$pdf->SetFont('Arial', 'B', 12);
	$pdf->Cell(0, 10, 'Ligging:', 0, 1, 'L');
	foreach ($liggingData as $ligging) {
		$liggingNaam = iconv('UTF-8', 'windows-1252', $ligging['naam']);
		$pdf->SetFont('Arial', '', 12);
		$pdf->Cell(0, 10, $liggingNaam, 0, 1, 'L');
	}
	$pdf->SetFont('Arial', 'B', 12);
	$pdf->Cell(0, 10, 'Eigenschappen:', 0, 1, 'L');
	foreach ($eigenschappenData as $eigenschap) {
		$eigenschapNaam = iconv('UTF-8', 'windows-1252', $eigenschap['naam']);
		$pdf->SetFont('Arial', '', 12);
		$pdf->Cell(0, 10, $eigenschapNaam, 0, 1, 'L');
	}
	$pdf->AddPage('P', array(210, 297)); // Nieuwe pagina voor afbeeldingen
	$pdf->SetFillColor(227, 228, 229);
	$pdf->Rect(0, 0, 210, 297, 'F');
	$x = 5;
	$y = 40;
	$imageWidth = 60;
	$imageHeight = 60;
	foreach ($imageResult as $image) {
		$imagePath = '../data/houseimages/house_' . $houseID . '/' . $image['img_path'];
		if (file_exists($imagePath)) {
			$pdf->Image($imagePath, $x, $y, $imageWidth, $imageHeight);
		}
		$x += $imageWidth + 5;
		if ($x + $imageWidth > 210) {
			$x = 5;
			$y += $imageHeight + 5;
		}
	}
	$pdf->SetFillColor(145, 187, 226);
	$pdf->Rect(0, 0, 210, 10, 'F');
	$pdf->Rect(0, 287, 210, 10, 'F');
	$pdf->SetFont('Arial', 'I', 10);
	$pdf->SetTextColor(255, 255, 255);
	$pdf->Text(10, 291, iconv('UTF-8', 'windows-1252', '©') . ' Vakantiewoningen INC.');

	$pdf->Output('house_details.pdf', 'D');
	exit;
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
	<title>detailpagina</title>
</head>

<body>
	<img class="topright" src="../data/img/topright.png">
	<div class="container">
		<div class="house">
			<div class="left">
				<?php
				echo "<a href='HouseDetail.php?houseID=" . $houseID . "'><img class='houseimage' src='../data/houseimages/house_" . $houseID . '/' . $imageResult[0]["img_path"] . "'></a>";
				?>

			</div>
			<div class="right">
				<p><?php echo $housedata["omschrijving"]; ?></p>
				<br>

				<h3>Eigenschappen:</h3> <?php foreach ($eigenschappenData as $eigenschap) : ?>
					<li><?php echo $eigenschap['naam']; ?></li>
				<?php endforeach; ?>
				<br>
				<p>
				<h3>Ligging: </h3>
			
					<?php foreach ($liggingData as $ligging) : ?>
						<li><?php echo $ligging['naam']; ?></li>
					<?php endforeach; ?>
				<h3>Makelaar:</h3>
				<?php echo $userdata['username']; ?>
				<br>
				<h3>Foto's:</h3>
				<div class="HuisImages">
					<?php
					for ($i = 1; $i < count($imageResult); $i++) {
						echo "<a href='HouseDetail.php?houseID=" . $houseID . "'><img class='houseimage' src='../data/houseimages/house_" . $houseID . '/' . $imageResult[$i]["img_path"] . "'></a>";
					}
					?>
				</div>

				<form action="" method="post">
					<input type="hidden" name="houseID" value="<?php echo $houseID; ?>">
					<button type="submit" name="generate_pdf">Generate PDF</button>
				</form>
			</div>
		</div>
	</div>
</body>

</html>
