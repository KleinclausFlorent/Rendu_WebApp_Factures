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
<!-- 
BUT : Vérification de l'existence d'une session sinon renvoi à la page d'identification 
BUT : Vérification de la variable de temps  de la session si elle existe on vérifie qu'elle n'a pas dépasser 30 minutes sinon on la crée
-->
<?php
			if (isset($_SESSION['id']))
			{
				if (isset($_POST['deco'])) 
				{
					session_destroy();
					print("bye");
					header('Location: Connexion.php');
				}
				/*if (isset($_SESSION['Time']))
				{
					if ( time() > $_SESSION['Time']+1800)
					{
						session_destroy();
					}
				} else {
					$_SESSION['Time'] = time();
				}*/
			} else {
				header('Location: Connexion.php');
				exit();
			}
		?>