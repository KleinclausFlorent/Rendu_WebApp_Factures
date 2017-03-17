<!-- Page qui affiche la table produit et qui permet de mettre à jour les données produits ou de les supprimer
-->
<!--
Ajout de la feuille qui gère la déconnexion à partir du clique sur le bouton Déconnexion
-->
<?php include("Gestion_Session.php") ?>
<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Kleinclaus Update/delete produit</title>
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
			if (isset($_POST['update']))
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
					BUT: Mise à jour du produit visé
					ENTREE: NumProduit / Libellé prod / Prix U
					SORTIE: Feedback maj et maj dans la base
					*/
					Try 
					{
						$req=$bdd->prepare('UPDATE produit SET LIBELLE = :Libelle,PRIXUNITAIRE = :PrixU WHERE NUMPRODUIT = :numProduit');
						$req->execute(array(
								'numProduit'=>$_POST['NUMPRODUIT'],
								'Libelle'=>$_POST['LIBELLE'],
								'PrixU'=>$_POST["PRIXUNITAIRE"]
								));
						echo("Les données produit ont bien été mise à jour.");

						$req->closeCursor();
					}
					catch (Exception $e)
					{
						echo('Erreur lors de la maj du produit.'. $e->getMessage());
					}
				}
		?>
		<?php
			if (isset($_POST['delete']))
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
					BUT: Suprression du produit visé
					ENTREE: NumProduit
					SORTIE: Feedback suppression et suppression
					*/
					Try 
					{
						$req=$bdd->prepare('DELETE FROM produit WHERE NUMPRODUIT = :numProduit');
						$req->execute(array(
								'numProduit'=>$_POST['NUMPRODUIT']
								));
						echo("Les données produits ont bien été supprimées.");

						$req->closeCursor();
					}
					catch (Exception $e)
					{
						echo('Erreur lors de la suppression du produit.'. $e->getMessage());
					}
				}
		?>

		<div id="corps">
			<h1>Les Produits</h1>
				<h2>La table</h2>
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
						BUT: Affichage de la table produit
						ENTREE: 
						SORTIE: affichage de la table sous forme de tableau
						*/
						Try 
						{
							$reponse = $bdd->query('SELECT * FROM produit');
									$rows = $reponse->rowCount();
									

									if ($rows == 0) {
											echo 'Pas de produit répondant aux critères <br/>';
									} else {
										echo '
												<div id=result>
													<table>
														<tr>
															<th>LIBELLE</th>
															<th>NUMPRODUIT</th>
															<th>PRIXUNITAIRE</th>		
														</tr>';
										while ($donnees = $reponse->fetch())
											{	
										
												echo '
														<tr>
															<td>'.$donnees['LIBELLE'].'</td>
															<td>'.$donnees['NUMPRODUIT'].'</td>
															<td>'.$donnees['PRIXUNITAIRE'].'</td>
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
							echo('Pas de produit répondant aux critères.');
						}

					?>

				<h2>Mise à jour</h2>
					<!--formulaire de mise à jour produit et affichage des numProduit existants sous forme de menu déroulant-->
					<form id="Update" action="UpdateProduit.php" method="POST">
						<div>
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
							<p><label for="LIBELLE">Libellé du produit : </label><input type="text" name="LIBELLE"/></p>
							<p><label for="PRIXUNITAIRE">Prix unitaire du produit : </label><input type="text" name="PRIXUNITAIRE"/></p>
							<p><input type="submit" value="maj" name="update" /></p>
						</div>
					</form>
					
				<h2>Delete</h2>
					<!--formulaire de suppression produit et affichage des numProduit existants sous forme de menu déroulant-->
					<form id="Delete" action="UpdateProduit.php" method="POST">
						<div>
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
							<p><input type="submit" value="Suppr" name="delete" /></p>	
						</div>
					</form>
					
		</div>
	</body>
</html>