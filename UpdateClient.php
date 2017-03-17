<!-- Page qui affiche la table clients et qui permet de mettre à jour les données clients ou de les supprimer
-->
<!--
Ajout de la feuille qui gère la déconnexion à partir du clique sur le bouton Déconnexion
-->
<?php include("Gestion_Session.php") ?>
<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Kleinclaus Update/delete client</title>
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
					BUT: Suprression du client visé
					ENTREE: Numclient
					SORTIE: Feedback suppression et suppression
					*/
					Try 
					{
						$req=$bdd->prepare('DELETE FROM client WHERE NUMCLIENT = :numClient');
						$req->execute(array(
								'numClient'=>$_POST['NUMCLIENT']
								));
						echo("Les données client ont bien été supprimées.");

						$req->closeCursor();
					}
					catch (Exception $e)
					{
						echo('Erreur lors de la maj du client.'. $e->getMessage());
					}
				}
		?>
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
					BUT: MISE à jour du client visé
					ENTREE: NUMCLIENT / NOM / PRENOM / CP / ADRESSE / VILLE / PAYS
					SORTIE: feedback maj et mise à jour dans la base
					*/
					Try 
					{
						$req=$bdd->prepare('UPDATE client SET NOM = :Nom,PRENOM = :Prenom,ADRESSECLIENT = :Adr,CP = :Cp,VILLE = :Ville ,PAYS = :Pays WHERE NUMCLIENT = :numClient');
						$req->execute(array(
								'numClient'=>$_POST['NUMCLIENT'],
								'Nom'=>$_POST['NOM'],
								'Prenom'=>$_POST["PRENOM"],
								'Adr'=>$_POST['ADRESSECLIENT'],
								'Cp'=>$_POST["CP"],
								'Ville'=>$_POST["VILLE"],
								'Pays'=>$_POST["PAYS"]
								));
						echo("Les données client ont bien été mise à jour.");

						$req->closeCursor();
					}
					catch (Exception $e)
					{
						echo('Erreur lors de la maj du client.'. $e->getMessage());
					}
				}
		?>
		<div id="corps">
			<h1>Les Clients</h1>

				
				<h2>La table</h2>
					<?php 
						/*
						BUT: Affichage de la table clients
						ENTREE: 
						SORTIE: Tableau contenant l'ensemble de la table client
						*/
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
							$reponse = $bdd->query('SELECT * FROM client');
									$rows = $reponse->rowCount();
									

									if ($rows == 0) {
											echo 'Pas de client répondant aux critères <br/>';
									} else {
										echo '
												<div id=result>
													<table>
														<tr>
															<th>NUMCLIENT</th>
															<th>NOM</th>
															<th>PRENOM</th>
															<th>CP</th>
															<th>ADRESSE</th>
															<th>VILLE</th>
															<th>PAYS</th>
															<th>Action</th>
														</tr>';
										while ($donnees = $reponse->fetch())
											{	
										
												echo '
														<tr>
															<td>'.$donnees['NUMCLIENT'].'</td>
															<td>'.$donnees['NOM'].'</td>
															<td>'.$donnees['PRENOM'].'</td>
															<td>'.$donnees['CP'].'</td>
															<td>'.$donnees['ADRESSECLIENT'].'</td>
															<td>'.$donnees['VILLE'].'</td>
															<td>'.$donnees['PAYS'].'</td>
															<td></td>
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
							echo('Pas de clients répondant aux critères.');
						}
					?>
				<h2>Mise à jour</h2>
					<!--formulaire de mise à jour client-->
					<form id="Update" action="UpdateClient.php" method="POST">
						<div>
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
										/*
											BUT:afficher les numclients existants
											ENTREE:
											SORTIE : Numclients dans un menu déroulant
										*/
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
							<p><label for="NOM">Nom du client : </label><input type="text" name="NOM" required/></p>
							<p><label for="PRENOM">Prenom du client : </label><input type="text" name="PRENOM" required/></p>
							<p><label for="CP">Code Postal : </label><input type="text" name="CP" required/></p>
							<p><label for="ADRESSECLIENT">Adresse du client : </label><input type="text" name="ADRESSECLIENT" required/></p>
							<p><label for="VILLE">Ville de résidence du client : </label><input type="text" name="VILLE" required/></p>
							<p><label for="PAYS">Pays de résidence du client : </label><input type="text" name="PAYS" required/></p>
							<p><input type="submit" value="MaJ" name="update" /></p>	
						</div>
					</form>
					
				<h2>Delete</h2>
					<!--formulaire de suppression de client-->
					<form id="Delete" action="UpdateClient.php" method="POST">
						<div>
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
										/*
										BUT:AFFICHAGE Numclient existant
										ENTREE:
										SORTIE: Numclient existant dans menu déroulant
										*/
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
							<p><input type="submit" value="Suppr" name="delete" /></p>	
						</div>
					</form>
					


		</div>
	</body>
</html>