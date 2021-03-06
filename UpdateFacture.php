<!-- Page qui affiche les tables factureset détails factures et qui permet de mettre à jour les données factures ou/et détail facture ou de les supprimer
-->
<!--
Ajout de la feuille qui gère la déconnexion à partir du clique sur le bouton Déconnexion
-->
<?php include("Gestion_Session.php") ?>
<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Kleinclaus Update/delete facture</title>
		<link rel="stylesheet" href="style.css">
		<script src="script.js"></script>
	</head>
	<body>
		<!--
		Ajout de la feuille header qui contient les liens vers les pages de la webApp
		Le "menu"
		-->
		<?php include("header.php") ?>
		<?php
			if (isset($_POST['updatefac']))
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
					/*
					BUT: mise à jour données factures
					ENTREE: Numfacture / date fac / Numclient
					SORTIE: feedback et mise à jour dans la base
					*/
					Try 
					{
						$req=$bdd->prepare('UPDATE facture SET DATEFACT = :DateFact,NUMCLIENT = :NumClient WHERE NUMFACTURE = :NumFacture');
						$req->execute(array(
								'NumFacture'=>$_POST['NUMFACTURE'],
								'DateFact'=>$_POST['DATEFACT'],
								'NumClient'=>$_POST["NUMCLIENT"]
								));
						echo("Les données facture ont bien été mise à jour.");

						$req->closeCursor();
					}
					catch (Exception $e)
					{
						echo('Erreur lors de la maj de la facture.'. $e->getMessage());
					}
				}
		?>
		<?php
			if (isset($_POST['updatedfac']))
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
					/*
					BUT: mise à jour données détail factures
					ENTREE: Numfacture / quantité produit / NumProduit
					SORTIE: feedback et mise à jour dans la base
					*/
					Try 
					{
						$req=$bdd->prepare('UPDATE dfacture SET QUANTITE = :Quantite WHERE NUMFACTURE = :NumFacture AND NUMPRODUIT = :NumProduit');
						$req->execute(array(
								'NumFacture'=>$_POST['NUMFACTURE'],
								'Quantite'=>$_POST['QUANTITE'],
								'NumProduit'=>$_POST["NUMPRODUIT"]
								));
						echo("Les données détail facture ont bien été mise à jour.");

						$req->closeCursor();
					}
					catch (Exception $e)
					{
						echo('Erreur lors de la maj du détail fac.'. $e->getMessage());
					}
				}
		?>
		<?php
			if (isset($_POST['deletedFac']))
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
					/*
					BUT: suppression données détail factures
					ENTREE: Numfacture et NumProduit
					SORTIE: feedback et suppression dans la base
					*/
					Try 
					{
						$req=$bdd->prepare('DELETE FROM dfacture WHERE NUMFACTURE = :NumFacture AND NUMPRODUIT = :NumProduit');
						$req->execute(array(
								'NumFacture'=>$_POST['NUMFACTURE'],
								'NumProduit'=>$_POST['NUMPRODUIT']
								));
						echo("Les données détail factures ont bien été supprimées.");

						$req->closeCursor();
					}
					catch (Exception $e)
					{
						echo('Erreur lors de la suppression du détail facture.'. $e->getMessage());
					}
				}
		?>
		<?php
			if (isset($_POST['deleteFac']))
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
					/*
					BUT: suppression données factures
					ENTREE: Numfacture
					SORTIE: feedback et suppression dans la base
					*/
					Try 
					{
						$req=$bdd->prepare('DELETE FROM facture WHERE NUMFACTURE = :NumFacture');
						$req->execute(array(
								'NumFacture'=>$_POST['NUMFACTURE']
								));
						echo("Les données factures ont bien été supprimées.");

						$req->closeCursor();
					}
					catch (Exception $e)
					{
						echo('Erreur lors de la suppression de la facture.'. $e->getMessage());
					}
				}
		?>
		<div id="corps">
			<h1>Les Factures et détail factures</h1>
				<h2>La table facture</h2>
					<?php 
						Try
						{
							$bdd = new PDO('mysql:host=localhost;dbname=facture;charset=utf8','Florent','1234Florent',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
						}
						catch (Exception $e)
						{
							die('Erreur : ' . $e->getMessage());
						}
						/*
						BUT: Affichage de la table facture
						ENTREE: 
						SORTIE: Tableau contenant l'ensemble de la table facture
						*/
						Try 
						{
							$reponse = $bdd->query('SELECT * FROM facture');
									$rows = $reponse->rowCount();
									

									if ($rows == 0) {
											echo 'Pas de facture répondant aux critères <br/>';
									} else {
										echo '
												<div id=result>
													<table>
														<tr>
															<th>DATEFACT</th>
															<th>NUMCLIENT</th>
															<th>NUMFACTURE</th>		
														</tr>';
										while ($donnees = $reponse->fetch())
											{	
										
												echo '
														<tr>
															<td>'.$donnees['DATEFACT'].'</td>
															<td>'.$donnees['NUMCLIENT'].'</td>
															<td>'.$donnees['NUMFACTURE'].'</td>
													  	</tr>';														
											}
											echo '
												</div>
													</table>';												    
								    }

									
									$reponse->closeCursor();
						}
						catch (Exception $e)
						{
							echo('Pas de facture répondant aux critères.');
						}

					?>

				<h2>La table détail facture</h2>
					<?php 
						Try
						{
							$bdd = new PDO('mysql:host=localhost;dbname=facture;charset=utf8','Florent','1234Florent',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
						}
						catch (Exception $e)
						{
							die('Erreur : ' . $e->getMessage());
						}
						/*
						BUT: Affichage de la table détail facture
						ENTREE: 
						SORTIE: Tableau contenant l'ensemble de la table détail facture
						*/
						Try 
						{
							$reponse = $bdd->query('SELECT * FROM dfacture');
									$rows = $reponse->rowCount();
									

									if ($rows == 0) {
											echo 'Pas de détail facture répondant aux critères <br/>';
									} else {
										echo '
												<div id=result>
													<table>
														<tr>
															<th>NUMPRODUIT</th>
															<th>QUANTITE</th>
															<th>NUMFACTURE</th>		
														</tr>';
										while ($donnees = $reponse->fetch())
											{	
										
												echo '
														<tr>
															<td>'.$donnees['NUMPRODUIT'].'</td>
															<td>'.$donnees['QUANTITE'].'</td>
															<td>'.$donnees['NUMFACTURE'].'</td>
													  	</tr>';														
											}
											echo '
												</div>
													</table>';												    
								    }

									
									$reponse->closeCursor();
						}
						catch (Exception $e)
						{
							echo('Pas de  détail facture répondant aux critères.');
						}

					?>
				<h2>Mise à jour</h2>
					<h3>Facture</h3>
						<!--
						Formulaire mise à jour facture avec fonction affichage numfacture et numclient dans menu déroulants-->
						<form id="Update" action="UpdateFacture.php" method="POST">
							<div>
								<p>
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
								<p><label for="DATEFACT">Date de la facture : </label><input type="date" name="DATEFACT" required /></p>
								<p>
									<label for="NUMCLIENT">NumClient du client : </label>
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

												echo('Erreur ! Pas de client répondant aux critères.'.$e->getMessage());
											}
										?>
									</select>
								</p>
								<p><input type="submit" value="majfac" name="updatefac" /></p>
							</div>
						</form>
						
					<h3>Détail facture</h3>
						<!--
						Formulaire mise à jour détail facture avec fonction affichage numfacture existant et NumProduit existant dans menu déroulants-->
						<form id="Update" action="UpdateFacture.php" method="POST">
							<div>
								<p>
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
								<p><label for="QUANTITE">Quantité de produit : </label><input type="number" name="QUANTITE" required /></p>
								<p>
									<label for="NUMPRODUIT">NumProduit du produit : </label>
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
									</select>
								</p>
								<p><input type="submit" value="majdfac" name="updatedfac" /></p>
							</div>
						</form>
						
				<h2>Delete</h2>
					<h3>Facture</h3>
						<!--
						Formulaire suppression facture avec fonction affichage numfacture existant dans menu déroulants-->
						<form id="Delete" action="UpdateFacture.php" method="POST">
							<div>
								<p>
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
								<p><input type="submit" value="SupprFac" name="deleteFac" /></p>	
							</div>
						</form>
						
					<h3>Détail Facture</h3>
						<!--
						Formulaire suppression détail facture avec fonction affichage numfacture existant et NumProduit existant dans menu déroulants-->
						<form id="Delete" action="UpdateFacture.php" method="POST">
							<div>
								<p>
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
								<p>
									<label for="NUMPRODUIT">NumProduit du produit : </label>
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
									</select>
								</p>
								<p><input type="submit" value="SupprdFac" name="deletedFac" /></p>	
							</div>
						</form>
						
		</div>
	</body>
</html>