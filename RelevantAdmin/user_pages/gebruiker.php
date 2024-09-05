<?php
include('../DBconfig.php');
session_start();

if (!isset($_SESSION["ROL"]) || $_SESSION["ROL"] != 0) {
    echo"hoi";
    header("location: ../home.php");
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
	$query = "SELECT * FROM users";
	$stmt = $verbinding->prepare($query);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

	?>

	<div class="container">
		<div class="box">
			<h4 class="display-4 text-center">Gebruikers</h4><br>
			<form method="post" action="add_user.php">
				<button type="submit" name="submit" class="btn btn-primary">Gebruiker toevoegen</button>
			</form>



			<table class="table table-striped">
				<thead>
					<tr>

						<th scope="col">Email</th>
						<th scope="col">Naam</th>
						<th scope="col">Rol</th>
					</tr>
				</thead>
				<tbody>
					<?php
					// For-loop gaan we veranderen voor een foreach-loop om door de DB data heen te gaan
					foreach ($result as $value) {

						?>
						<tr>

							<td>
								<?= $value['email']; ?>
							</td>
							<td>
							    <?= $value['username']; ?>
							</td>
							<input type="hidden" name="wachtwoord" value="<?= $value['wachtwoord']; ?>">
							<td>
								<?php if ($value['rol'] == 1) {
									echo 'makelaar';
								} else {
									echo 'admin';
								}?>
							</td>
							<td><a href="edit-user.php?userID=<?= $value['userID']; ?>">
									<button class="btn btn-success">Bewerk</button>
								</a>

								<form action="verwijder.php" method="post">
									<input type="hidden" name="delete_id" value="<?php echo $value['userID']; ?>">
									<button class="btn btn-danger" name="delete_btn" type="submit">Verwijder</button>
								</form>

							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>

			<form >
			<?php
				if (isset($_SESSION["ROL"]) && $_SESSION["ROL"] != 1){ ?>
				<a href="../index.php" class="btn btn-primary">Terug naar adminpanel</a>
				<?php } ?>
			<?php
				if (isset($_SESSION["ROL"]) && $_SESSION["ROL"] != 0){ ?>
				<a href="../../index.php" class="btn btn-primary">Terug naar homepagina</a>
				<?php } ?>
			</form>

		</div>
	</div>







</body>

</html>