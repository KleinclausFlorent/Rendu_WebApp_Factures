<!-- Page permet de consulter les factures et leurs détails
-->
<!--
Ajout de la feuille qui gère la déconnexion à partir du clique sur le bouton Déconnexion
-->
<?php include("Gestion_Session.php") ?>
<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Kleinclaus Consultation Factures</title>
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
			<h1>Les Factures</h1>
				<h2>Consulter</h2>
					<!--formulaire de recherche facture et détail facture-->
					<form id="Recherche" action="Factures.php" method="POST">
						<div>
							<p><label for="NUMFACTURE">Numéro de la facture : </label><input type="text" name="NUMFACTURE"/></p>
							<p><label for="DATEFACT">Date de la facturation : </label><input type="text" name="DATEFACT"/></p>
							<p><label for="NUMCLIENT">Numéro du client : </label><input type="text" name="NUMCLIENT"/></p>
							<p><input type="submit" value="Chercher" name="seek" /></p>	
						</div>
					</form>
					<?php
					/*
					BUT : Afficher les données facture et détail correspondantes à la recherche
					ENTREE : NumFacture et/ou dateFacture et/ou NumCLIENT / clique bouton
					SORTIE : Tableau contentant les données correspondantes à la recherche
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
								$whereseek="";
								if ((isset($_POST['NUMFACTURE'])) AND ($_POST['NUMFACTURE']!=""))
								{
									$whereseek='facture.NUMFACTURE = '.$_POST["NUMFACTURE"];
								}
								if ((isset($_POST['DATEFACT'])) AND ($_POST['DATEFACT']!=""))
								{
									if ($whereseek=='')
									{
										$whereseek='facture.DATEFACT =\''.$_POST["DATEFACT"].'\'';
									} else 
									{
										$whereseek.=' AND facture.DATEFACT =\''.$_POST["DATEFACT
										"].'\'';
									}
								}
								if ((isset($_POST['NUMCLIENT'])) AND ($_POST['NUMCLIENT']!=""))
								{
									if ($whereseek=='')
									{
										$whereseek='facture.NUMCLIENT =\''.$_POST["NUMCLIENT"].'\'';
									} else 
									{
										$whereseek.=' AND facture.NUMCLIENT =\''.$_POST["NUMCLIENT"].'\'';
									}
								}
								$reponse = $bdd->query('SELECT facture.NUMFACTURE,NUMCLIENT,DATEFACT,dfacture.NUMPRODUIT,QUANTITE,LIBELLE,PRIXUNITAIRE FROM facture,dfacture,produit WHERE ('.$whereseek.' AND facture.NUMFACTURE=dfacture.NUMFACTURE AND dfacture.NUMPRODUIT=produit.NUMPRODUIT) ');
										$rows = $reponse->rowCount();
										/*print('SELECT NUMFACTURE.facture,NUMCLIENT,DATEFACT,NUMPRODUIT,QUANTITE FROM facture,dfacture WHERE ('.$whereseek.' AND NUMFACTURE.facture=NUMFACTURE.dfacture)  ');
										NUMFACTURE.facture,NUMCLIENT,DATEFACT,NUMPRODUIT,QUANTITE*/
										

										if ($rows == 0) {
												echo 'Pas de facture répondant aux critères <br/>';
										} else {
											echo '
													<div id=result>
														<table>
															<tr>
																<th>NUMFACTURE</th>
																<th>DATEFACT</th>
																<th>NUMCLIENT</th>
																<th>NUMPRODUIT</th>
																<th>LIBELLE</th>
																<th>PRIXUNITAIRE</th>
																<th>QUANTITE</th>
															</tr>';
											while ($donnees = $reponse->fetch())
												{	
											
													echo '
															<tr>
																<td>'.$donnees['NUMFACTURE'].'</td>
																<td>'.$donnees['DATEFACT'].'</td>
																<td>'.$donnees['NUMCLIENT'].'</td>
																<td>'.$donnees['NUMPRODUIT'].'</td>
																<td>'.$donnees['LIBELLE'].'</td>
																<td>'.$donnees['PRIXUNITAIRE'].'</td>
																<td>'.$donnees['QUANTITE'].'</td>

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

								echo('Erreur ! Pas de facture répondant aux critères.'.$e->getMessage());
							}
						}
						
					?>
				
		</div>
	</body>
</html>