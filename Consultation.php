<?php include("Gestion_Session.php")?>
<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Kleinclaus Consultation Menu</title>
		<link rel="stylesheet" href="style.css">
		<script src="script.js"></script>
	</head>
	<body>
		<!-- Formulaire de connexion -->
		<div id="corps">
			<h1>Menu de consultation</h1>
			<?php 
				echo('<p> Bonjour, ' .$_SESSION['id'].'.</p>')
			?>
			<h1>Liens</h1>
				<?php include("header.php")?>
			<form id="Deconnexion" action="Consultation.php" method="POST">
				<div>
					<p><input type="submit" value="Deconnexion" name="deco"/></p>
				</div>
			</form>
		</div>
	</body>
</html>