<!-- Page de connexion vers laquelle le joueur est redirigé s'il ne s'est pas connecté ou s'il s'est déconnecté -->


<?php
	//On démarra la session pour accèder aux variables de session
	session_start();
	//On initialise la date
	date_default_timezone_set('Europe/Berlin');
	$jour = date ('d');
	$mois = date ('m');
	$annee = date('Y');
	$heure = date('H');
	$minute = date('i');
?>
<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Kleinclaus Connexion</title>
		<link rel="stylesheet" href="style.css">
		<script src="script.js"></script>
	</head>
	<body>
		<!-- Formulaire de connexion -->
		<div id="corps">
			<h1>Portail de connexion</h1>
			<form id="login" action="Connexion.php" method="POST">
				<div>
					<p><label for="identifiant">Identifiant : </label><input type="text" name="identifiant"  required /></p>
					<p><label for="password">Mot de passe : </label><input type="password" name="password" required /></p>
					<p><input type="submit" value="login" name="login" /></p>				
				</div>
			</form>	
			<!--lien vers la page de création d'identifiant-->
			<a href="New_ID.php">Créer un identifiant</a>
		</div>
		<?php
			/*
			BUT : Vérification mot de passe et identifiant afin de donner l'accès à la base de donnée.
			ENTREE : Appuie sur le bouton de login / Identifiant / mot de passe
			SORTIE : Création de la session et accès à la webApp 
			*/
			if (isset($_POST['login']))
				{
					//Connexion à la base de donnée
					Try
					{
						$bdd = new PDO('mysql:host=localhost;dbname=facture','Florent','1234Florent',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
					}
					catch (Exception $e)
					{
						die('Erreur : ' . $e->getMessage());
					}
						$req=$bdd->prepare('SELECT PASSWORD FROM utilisateur WHERE NOM_UTIL=?');
						$req->execute(array($_POST["identifiant"]));
						if (password_verify($_POST["password"],$req->fetch()[0])==1)
						{
							$_SESSION['id'] = $_POST["identifiant"];
							header('Location: Consultation.php');
							exit();
						} else {
							echo('Identifiant ou mot de pass incorrecte');
						}
					
				}	
		?>
	</body>
</html>
	