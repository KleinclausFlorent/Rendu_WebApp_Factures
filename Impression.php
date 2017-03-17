<!--
 Page d'impression d'une facture
-->
<!--
Ajout de la feuille qui gère la déconnexion à partir du clique sur le bouton Déconnexion
-->
<?php include("Gestion_Session.php") ?>
<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Kleinclaus Impression Facture</title>
		<link rel="stylesheet" href="style.css">
		<script src="script.js"></script>
	</head>
	<body>
		<?php include("header.php") ?>
		<div id="corps">
			<h1>Imprimer une facture</h1>
				<h2>Choix de la facture</h2>
					<form id="Choisir" action="UpdateFacture.php" method="POST">
						<div>
							<p>
								<!-- formulaire choix de la facture à visualiser avant l'impression-->
								<label for="NUMFACTURE">NumFacture de la facture : </label>
								<select name="NUMFACTURE" required>
									<?php
									//Connexion à la base de donnée
										Try
										{
											$bdd = new PDO('mysql:host=localhost;dbname=facture;charset=utf8','Florent','1234Florent',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
										}
										catch (Exception $e)
										{
											die('Erreur : ' . $e->getMessage());
										}
										/*
											BUT : Afficher les NumFacture existant
											ENTREE : 
											SORTIE : NumFacture existant dans une menu déroulant
										*/
										Try 
										{
											$reponse = $bdd->query('SELECT NUMFACTURE FROM facture ORDER BY NUMFACTURE ASC;');
											$rows = $reponse->rowCount();
													

											if ($rows == 0) {
													echo 'Aucune facture disponible <br/>' ;
											} else {
												while ($donnees = $reponse->fetch())
													{	
														echo '<option>'.$donnees['NUMFACTURE'].'</option>';														
													}	
											}							
											$reponse->closeCursor();
										}
										catch (Exception $e)
										{

											echo('Erreur ! Pas de facture répondant aux critères.'.$e->getMessage());
										}
									?>
								</select>
							</p>
							<p><input type="submit" value="Choisir" name="Choix" /></p>
						</div>
					</form>
				<h2>Aperçu avant impression</h2>
				
		</div>
	</body>
</html>