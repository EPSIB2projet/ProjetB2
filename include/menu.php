<?php
if(isset($_SESSION['id']))
{
	?>
	<?php 
	include('include/config.php');

	$reponse = $bdd->query('SELECT * FROM Visiteur WHERE id = "'.$_SESSION['id'].'" ');
	$connexion = $reponse->fetch();

	echo "".$connexion['nom']." ".$connexion['prenom']."<br /><br /> ";
	?>

<a href="index.php">Accueil</a><br />
<a href="cSeDeconnecter.php">Se déconnecter</a><br />
<a href="cSaisieFicheFrais.php">Saisie fiche de frais</a><br />
<a href="cConsultFichesFrais.php">Mes fiches de frais</a>
	<?php
}
else
{
	?>

<a href="index.php">Accueil</a><br />
<a href="cSeConnecter.php">Se connecter</a>
	<?php
}
?>
