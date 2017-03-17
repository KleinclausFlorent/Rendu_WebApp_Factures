<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Kleinclaus New_ID</title>
		<link rel="stylesheet" href="style.css">
		<script src="script.js"></script>
	</head>
	<body>
		<!-- Formulaire de connexion -->
		<div id="corps">
			<h1>Création d'identifiants de connexion</h1>
			<form id="FormNewID" action="New_ID.php" method="POST">
				<div>
					<p><label for="identifiant">Identifiant : </label><input type="text" name="identifiant"  required /></p>
					<p><label for="password">Mot de passe : </label><input type="password" name="password" required /></p>
					<p><input name="newid" type="submit" value="newid" /></p>				
				</div>
			</form>		
		</div>
		<?php
			if (isset($_POST['newid']))
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
					//On essaie de créer le nouvelle identifiant et mot de passe
					Try 
					{
						$bdd->exec('INSERT INTO utilisateur(NOM_UTIL,PASSWORD)
						VALUES (\''.$_POST["identifiant"].'\',\''.password_hash($_POST["password"],PASSWORD_DEFAULT).'\')');
						header('Location: Connexion.php');
						exit();
					}
					//On attrape toutes les erreurs dont l'existance d'un identifiant identique.
					catch (Exception $e)
					{
						echo('Cette identifiant existe déjà.');
					}
				}	
		?>
	</body>
</html>