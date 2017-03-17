<!--Feuille php contenant le menu avec les liens vers toutes les pages de l'App et le bouton de déconnexion-->

<header>
	<p><a href="Consultation.php">Accueil</a></p> 
	<p><a href="Factures.php">Consulter données factures</a></p>	
	<p><a href="CreateFacture.php">Ajouter une facture</a><br/></p>
	<p><a href="Clients.php">Ajouter/Consulter données clients</a></p>
	<p><a href="Produits.php">Ajouter/Consulter données produits</a></p>
	<p><a href="UpdateClient.php">Mettre à jour ou supprimer les données clients<a></p>
	<p><a href="UpdateProduit.php">Mettre à jour ou supprimer les données produits<a></p>
	<p><a href="UpdateFacture.php">Mettre à jour ou supprimer les données factures<a></p>
	<p><a href="Impression.php">Imprimer une facture<a></p>
	<form id="Deconnexion" action="" method="POST">
		<div>
			<p><input type="submit" action="" value="Deconnexion" name="deco"/></p>
		</div>
	</form>
</header>