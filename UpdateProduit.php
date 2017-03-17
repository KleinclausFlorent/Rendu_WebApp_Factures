<?php include("Gestion_Session.php")?>
<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Kleinclaus Update/delete produit</title>
		<link rel="stylesheet" href="style.css">
		<script src="script.js"></script>
	</head>
	<body>
		<?php include("header.php")?>
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
				<h2>Delete</h2>
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
		</div>
	</body>
</html>