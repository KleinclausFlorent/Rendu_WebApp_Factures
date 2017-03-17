<!-- Page permet de recherche un produit dans la table et d'ajouter un produit
-->
<!--
Ajout de la feuille qui gère la déconnexion à partir du clique sur le bouton Déconnexion
-->
<?php include("Gestion_Session.php") ?>
<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Kleinclaus Consultation Produits</title>
		<link rel="stylesheet" href="style.css">
		<script src="script.js"></script>
	</head>
	<body>
		<!--
		Ajout de la feuille header qui contient les liens vers les pages de la webApp
		Le "menu"
		-->
		<?php include("header.php") ?>
		<div id="corps">
			<h1>Les Produits</h1>
				<h2>Consulter</h2>
				<!--formulaire de recherche dans la table produit-->
					<form id="Recherche" action="Produits.php" method="POST">
						<div>
							<p><label for="NUMPRODUIT">Numéro du produit : </label><input type="text" name="NUMPRODUIT"/></p>
							<p><label for="LIBELLE">Libellé du produit : </label><input type="text" name="LIBELLE"/></p>
							<p><label for="PRIXUNITAIRE">Prix unitaire du produit : </label><input type="text" name="PRIXUNITAIRE"/></p>
							<p><input type="submit" value="Chercher" name="seek" /></p>	
						</div>
					</form>
					<!--formulaire d'ajout dans la table produit-->
				<h2>Ajouter</h2>
					<form id="Ajout" action="Produits.php" method="POST">
						<div>
							<p><label for="LIBELLE">Libellé du produit : </label><input type="text" name="LIBELLE"/></p>
							<p><label for="PRIXUNITAIRE">Prix unitaire du produit : </label><input type="text" name="PRIXUNITAIRE"/></p>
							<p><input type="submit" value="Ajout" name="add" /></p>
						</div>
					</form>
					<?php
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
							/*
							BUT: Afficher les données répondant à la recherche
							ENTREE: clique bouton / NumProd et/ou Libelle et/ou PRIXU
							SORTIE: un tableau contenant les données correspondantes à la recherche
							*/
							Try 
							{
								$whereseek="";
								if ((isset($_POST['NUMPRODUIT'])) AND ($_POST['NUMPRODUIT']!=""))
								{
									$whereseek='NUMPRODUIT = '.$_POST["NUMPRODUIT"];
								}
								if ((isset($_POST['LIBELLE'])) AND ($_POST['LIBELLE']!=""))
								{
									if ($whereseek=='')
									{
										$whereseek='LIBELLE =\''.$_POST["LIBELLE"].'\'';
									} else 
									{
										$whereseek.=' AND LIBELLE =\''.$_POST["LIBELLE
										"].'\'';
									}
								}
								if ((isset($_POST['PRIXUNITAIRE'])) AND ($_POST['PRIXUNITAIRE']!=""))
								{
									if ($whereseek=='')
									{
										$whereseek='PRIXUNITAIRE =\''.$_POST["PRIXUNITAIRE"].'\'';
									} else 
									{
										$whereseek.=' AND PRIXUNITAIRE =\''.$_POST["PRIXUNITAIRE"].'\'';
									}
								}
								$reponse = $bdd->query('SELECT * FROM produit WHERE ('.$whereseek.') ');
										$rows = $reponse->rowCount();
										

										if ($rows == 0) {
												echo 'Pas de produit répondant aux critères <br/>';
										} else {
											echo '
													<div id=result>
														<table>
															<tr>
																<th>NUMPRODUIT</th>
																<th>LIBELLE</th>
																<th>PRIXUNITAIRE</th>
															</tr>';
											while ($donnees = $reponse->fetch())
												{	
											
													echo '
															<tr>
																<td>'.$donnees['NUMPRODUIT'].'</td>
																<td>'.$donnees['LIBELLE'].'</td>
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
								echo('Pas de produits répondant aux critères.');
							}
						}
						
					?>
					<?php
						
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
							/*
							BUT: Ajout d'un produit dans la base
							ENTREE: LIBELLE / PRIX U / clique bouton
							SORTIE: Feedback ajout et ajout dans la base
							*/
							Try 
							{
								$req=$bdd->prepare('INSERT INTO produit(LIBELLE,PRIXUNITAIRE)VALUES(:Lib,:Prix)');
								$req->execute(array(
										'Lib'=>$_POST['LIBELLE'],
										'Prix'=>$_POST["PRIXUNITAIRE"]
										));
								echo("Le produit a bien été ajouté.");

								$req->closeCursor();
							}
							catch (Exception $e)
							{
								echo('Erreur lors de la création du produit.');
							}
						}
						
					?>
		</div>
	</body>
</html>