<?php include("Gestion_Session.php")?>
<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Kleinclaus Consultation Factures</title>
		<link rel="stylesheet" href="style.css">
		<script src="script.js"></script>
	</head>
	<body>
		<?php include("header.php")?>
		<div id="corps">
			<h1>Les Factures</h1>
			<h2>Ajouter</h2>
					<form id="Ajout" action="CreateFacture.php" method="POST">
						<div>
							<p><label for="DATEFACTURE">Date de la facturation : </label><input type="date" name="DATEFACTURE" required/></p>
							<p><label for="NUMCLIENT">NumClient du client : </label>
							<select name="NUMCLIENT" required>
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
									Try 
									{
										$reponse = $bdd->query('SELECT NUMCLIENT FROM client ORDER BY NUMCLIENT ASC;');
										$rows = $reponse->rowCount();
												

										if ($rows == 0) {
												echo 'Aucun client disponible <br/>' ;
										} else {
											while ($donnees = $reponse->fetch())
												{	
													echo '<option>'.$donnees['NUMCLIENT'].'</option>';														
												}	
										}							
										$reponse->closeCursor();
									}
									catch (Exception $e)
									{

										echo('Erreur ! Pas de produit répondant aux critères.'.$e->getMessage());
									}
								?>
							</select></p>
							<p><input type="submit" value="Ajout" name="add"required/></p>
						</div>
					</form>
					
					<?php
						//Permettre d'ajouter un facture puis un produit à la fois avec sa quantité dans le détail
						if (isset($_POST['add']))
						{
							//Connexion à la base de donnée
							Try
							{
								$bdd = new PDO('mysql:host=localhost;dbname=facture;charset=utf8','Florent','1234Florent',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
							}
							catch (Exception $e)
							{
								die('Erreur : ' . $e->getMessage());
							}
							Try 
							{
								$req=$bdd->prepare('INSERT INTO facture(NUMCLIENT,DATEFACT)VALUES(:NumClient,:DateFact)');
								$req->execute(array(
										'NumClient'=>$_POST['NUMCLIENT'],
										'DateFact'=>$_POST['DATEFACTURE']
										));
								echo("La facture a bien été ajouté.");

								$req->closeCursor();
							}
							catch (Exception $e)
							{
								echo('exception.');
							}
						}
						
					?>
			<h1>Le détail de la facture<h1>
			<h2>Ajouter un produit</h2>
				<form id="AjoutProd" action="CreateFacture.php" method="POST">
					<div>
						<p><label for="NUMFACTURE">Numéro de la facture : </label>
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
						</select></p>
						<p><label for="NUMPRODUIT">Numéro du produit: </label>
						<select name="NUMPRODUIT" required>
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
							Try 
							{
								$reponse = $bdd->query('SELECT NUMPRODUIT FROM produit ORDER BY NUMPRODUIT ASC;');
								$rows = $reponse->rowCount();
										

								if ($rows == 0) {
										echo 'Aucun produit disponible <br/>' ;
								} else {
									while ($donnees = $reponse->fetch())
										{	
											echo '<option>'.$donnees['NUMPRODUIT'].'</option>';														
										}	
								}							
								$reponse->closeCursor();
							}
							catch (Exception $e)
							{

								echo('Erreur ! Pas de produit répondant aux critères.'.$e->getMessage());
							}
						?>
						</select></p>
						<p><label for="QUANTITE">Quantité du produit: </label><input type="text" name="QUANTITE"required/></p>
						<p><input type="submit" value="Ajout" name="addprod"required/></p>
					</div>
				</form>
				<?php
					//Permettre d'ajouter un facture puis un produit à la fois avec sa quantité dans le détail
					if (isset($_POST['addprod']))
					{
						//Connexion à la base de donnée
						Try
						{
							$bdd = new PDO('mysql:host=localhost;dbname=facture;charset=utf8','Florent','1234Florent',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
						}
						catch (Exception $e)
						{
							die('Erreur : ' . $e->getMessage());
						}
						Try 
						{
							$req=$bdd->prepare('INSERT INTO dfacture(NUMFACTURE,NUMPRODUIT,QUANTITE)VALUES(:NumFacture,:NumProduit,:Quantite)');
							$req->execute(array(
									'NumFacture'=>$_POST['NUMFACTURE'],
									'NumProduit'=>$_POST["NUMPRODUIT"],
									'Quantite'=>$_POST["QUANTITE"]
									));
							echo("Le produit a bien été ajouté.");

							$req->closeCursor();
						}
						catch (Exception $e)
						{
							echo('exception.'.$e->getMessage());
						}
					}
						
				?>

		</div>
	</body>
</html>