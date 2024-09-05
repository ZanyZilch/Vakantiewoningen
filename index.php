<?php
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="robots" content="noindex, nofollow">
	<link rel="icon" href="data/img/favicon.png" type="image/png">
	<link rel="stylesheet" href="data/css/main.css">
	<link rel="stylesheet" href="data/css/index.css">
	<script defer src="data/js/main.js"></script>
	<script defer src="https://kit.fontawesome.com/769f05a054.js" crossorigin="anonymous"></script>
	<title>Vakantiewoningen • Vind je droomverblijf</title>
</head>

<body>
	<img class="topright" src="data/img/topright.png">
	<header>
		<div class="items">
			<a href="#" class="title">Vakantiewoningen</a>
			<ul>
				<a href="index.php">Home</a>
				<a href="pages/huizen.php">Huizen</a>
				<?php if (isset($_SESSION["ROL"]) && $_SESSION["ROL"] != 0){ ?>
					<a href="RelevantAdmin/house_pages/houses.php">Bewerk huis</a>
					<a href="pages/openhuizen.php">Mijn Huizen</a>
					<a href="pages/logout.php">Afmelden</a>
				<?php } ?>
				<?php if (isset($_SESSION["ROL"]) && $_SESSION["ROL"] != 1){ ?>
					<a href="RelevantAdmin/index.php">Admin panel</a>
					<a href="pages/openhuizen.php">Mijn Huizen</a>
					<a href="pages/logout.php">Afmelden</a>
				<?php } ?>
				<?php
				if (!isset($_SESSION["ROL"])) { ?>
					<a href="pages/inlog_page.php">Log in</a>
				<?php } ?>
			</ul>
		</div>
	</header>
	<div class="viewport">
		<div class="right">
			<img src="data/img/house.png">
		</div>
		<div class="left">
			<p>Jouw mooiste nieuwe verblijf!</p>
			<span>Ben je op zoek naar je droomhuis of een slimme investeringsmogelijkheid? Vakantiewoningenis jouw toegangspoort tot een breed scala aan koopwoningen in verschillende prijsklassen en locaties.</span>
			<div>
				<a href="pages/huizen.php">Bekijk ons aanbod</a>
				<a href="#container">Meer informatie</a>
			</div>
		</div>
	</div>

	<div class="search-box">

		<div class="container" id="container">
			<div class="first">
				<p>Waarom ons kiezen?</p>
				<span>Wij bieden diversiteit aan opties, Onze lokale experts staan klaar om je te begeleiden en al je vragen te beantwoorden!
</span>
			</div>
			<div class="second">
				<div class="item">
					<i class="fa-solid fa-star icon"></i>
					<p>Beste kwaliteit</p>
					<span>Wij verzekeren de hoogste normen voor elke woning. Geverifieerd en ondersteund door toegewijde klantenservice voor jouw tevredenheid.</span>
				</div>
				<div class="item">
					<i class="fa-solid fa-thumbs-up icon"></i>
					<p>Blije klanten</p>
					<span> ⭐️⭐️⭐️⭐️⭐️<br>Fantastische ervaring! Vakantiewoningen leverde een geweldige vakantie-accommodatie, precies zoals beloofd. Vriendelijk team Zeker weer boeken!</span>
				</div>
				<div class="item">
					<i class="fa-solid fa-graduation-cap icon"></i>
					<p>Top Makelaars</p>
					<span>Professioneel, efficiënt, en toegewijd. Ze vonden mijn droomhuis binnen mijn budget. Dankzij hen heb ik mijn perfecte woning!</span>
				</div>
			</div>
		</div>
</body>

</html>