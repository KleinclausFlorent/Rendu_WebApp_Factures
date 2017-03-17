<!-- Page d'accueil contenant le menu de redirection vers toutes les pages de la webApp
-->
<!--
Ajout de la feuille qui gère la déconnexion à partir du clique sur le bouton Déconnexion
-->
<?php include("Gestion_Session.php") ?>
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
				<!--
					Ajout de la feuille header qui contient les liens vers les pages de la webApp
					Le "menu"
				-->
				<?php include("header.php") ?>
				<!--Bouton de déconnexion-->
			<form id="Deconnexion" action="Consultation.php" method="POST">
				<div>
					<p><input type="submit" value="Deconnexion" name="deco"/></p>
				</div>
			</form>
		</div>
	</body>
</html>