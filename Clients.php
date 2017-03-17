<!-- Trouver un client avec une recherche par formulaire ou ajout d'un client à l'aide d'un formulaire -->

<!--
Ajout de la feuille qui gère la déconnexion à partir du clique sur le bouton Déconnexion
-->
<?php include("Gestion_Session.php")?>
<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Kleinclaus Consultation Clients</title>
		<link rel="stylesheet" href="style.css">
		<script src="script.js"></script>
	</head>
	<body>
		/*
		Ajout de la feuille header qui contient les liens vers les pages de la webApp
		Le "menu"
		*/
		<?php include("header.php")?>

		<div id="corps">
			<h1>Les Clients</h1>
				<h2>Consulter</h2>
				//Formulaire de recherche d'un client dans la table
					<form id="Recherche" action="Clients.php" method="POST">
						<div>
							<p><label for="NUMCLIENT">Numéro du client : </label><input type="text" name="NUMCLIENT"/></p>
							<p><label for="NOM">Nom du client : </label><input type="text" name="NOM"/></p>
							<p><label for="PRENOM">Prenom du client : </label><input type="text" name="PRENOM"/></p>
							<p><label for="CP">Code Postal : </label><input type="text" name="CP"/></p>
							<p><label for="ADRESSECLIENT">Adresse du client : </label><input type="text" name="ADRESSECLIENT"/></p>
							<p><label for="VILLE">Ville de résidence du client : </label><input type="text" name="VILLE"/></p>
							<p><label for="PAYS">Pays de résidence du client : </label><input type="text" name="PAYS"/></p>
							<p><input type="submit" value="Chercher" name="seek" /></p>	
						</div>
					</form>
				<h2>Ajouter</h2>
				//Formulaire d'ajout d'un client dans la table
					<form id="Ajout" action="Clients.php" method="POST">
						<div>
							<p><label for="NOM">Nom du client : </label><input type="text" name="NOM" required/></p>
							<p><label for="PRENOM">Prenom du client : </label><input type="text" name="PRENOM"required/></p>
							<p><label for="CP">Code Postal : </label><input type="text" name="CP"required/></p>
							<p><label for="ADRESSECLIENT">Adresse du client : </label><input type="text" name="ADRESSECLIENT"required/></p>
							<p><label for="VILLE">Ville de résidence du client : </label><input type="text" name="VILLE"required/></p>
							<p><label for="PAYS">Pays de résidence du client : </label><input type="text" name="PAYS"required/></p>
							<p><input type="submit" value="Ajout" name="add" /></p>	
						</div>
					</form>
					<?php
						/*
						BUT : Afficher les données correspondantes à la recherche de l'utilisateur
						ENTREE : Appuie bouton recherche / NUMCLIENT ou/et NOM ou/et PRENOM ou/et CP ou/et ADRESSECLIENT ou/et VILLE ou/et PAYS
						SORTIE : Données clients correspondant à la recherche sous forme de tableau 
						*/
						if (isset($_POST['seek']))
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
								//On concatène nos critères de recherche dans une chaîne
								$whereseek="";
								if ((isset($_POST['NUMCLIENT'])) AND ($_POST['NUMCLIENT']!=""))
								{
									$whereseek='NUMCLIENT = '.$_POST["NUMCLIENT"];
								}
								if ((isset($_POST['NOM'])) AND ($_POST['NOM']!=""))
								{
									if ($whereseek=='')
									{
										$whereseek='NOM =\''.$_POST["NOM"].'\'';
									} else 
									{
										$whereseek.=' AND NOM =\''.$_POST["NOM"].'\'';
									}
								}
								if ((isset($_POST['PRENOM'])) AND ($_POST['PRENOM']!=""))
								{
									if ($whereseek=='')
									{
										$whereseek='PRENOM =\''.$_POST["PRENOM"].'\'';
									} else 
									{
										$whereseek.=' AND PRENOM =\''.$_POST["PRENOM"].'\'';
									}
								}
								if ((isset($_POST['CP'])) AND ($_POST['CP']!=""))
								{
									if ($whereseek=='')
									{
										$whereseek='CP ='.$_POST["CP"];
									} else 
									{
										$whereseek.=' AND CP ='.$_POST["CP"];
									}
								}
								if ((isset($_POST['ADRESSECLIENT'])) AND ($_POST['ADRESSECLIENT']!=""))
								{
									if ($whereseek=='')
									{
										$whereseek='ADRESSECLIENT =\''.$_POST["ADRESSECLIENT"].'\'';
									} else 
									{
										$whereseek.=' AND ADRESSECLIENT =\''.$_POST["ADRESSECLIENT"].'\'';
									}
								}
								if ((isset($_POST['VILLE'])) AND ($_POST['VILLE']!=""))
								{
									if ($whereseek=='')
									{
										$whereseek='VILLE =\''.$_POST["VILLE"].'\'';
									} else 
									{
										$whereseek.=' AND VILLE =\''.$_POST["VILLE"].'\'';
									}
								}
								if ((isset($_POST['PAYS'])) AND ($_POST['PAYS']!=""))
								{
									if ($whereseek=='')
									{
										$whereseek='PAYS =\''.$_POST["PAYS"].'\'';
									} else 
									{
										$whereseek.=' AND PAYS =\''.$_POST["PAYS"].'\'';
									}
								}
								//On lance notre requête vers la base de données
								$reponse = $bdd->query('SELECT * FROM client WHERE ('.$whereseek.') ');
										$rows = $reponse->rowCount();
										
										//Si aucune valeur correspondante
										if ($rows == 0) {
												echo 'Pas de client répondant aux critères <br/>';
											//Sinon on affiche les valeurs dans un tableau
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
						}
						
					?>
					<?php
						/*
						BUT : Ajouter un client dans la basse
						ENTREE : Appuie bouton ajout NOM ou/et PRENOM et CP et ADRESSECLIENT et VILLE et PAYS
						SORTIE : texte pour confirmer l'ajout
						*/				
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
								//Requête qui insert le nouveau client dans la base
								$req=$bdd->prepare('INSERT INTO client(NOM,PRENOM,ADRESSECLIENT,CP,VILLE,PAYS)VALUES(:Nom,:Prenom,:Adr,:Cp,:Ville,:Pays)');
								$req->execute(array(
										'Nom'=>$_POST['NOM'],
										'Prenom'=>$_POST["PRENOM"],
										'Adr'=>$_POST['ADRESSECLIENT'],
										'Cp'=>$_POST["CP"],
										'Ville'=>$_POST["VILLE"],
										'Pays'=>$_POST["PAYS"]
										));
								echo("Le client a bien été ajouté.");

								$req->closeCursor();
							}
							catch (Exception $e)
							{
								echo('Erreur lors de la création du client.');
							}
						}
						
					?>
		</div>
	</body>
</html>


	