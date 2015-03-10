<?php include('include/header.php'); ?>

<body>
	<div id="header">
		<div id="logo"><img src="images/logo.jpg"></div>
		<div id="titre">Suivi du remboursement des frais</div>
	</div>

	<div id="contenu">
		<div id="menu">
			<?php include('include/menu.php'); ?>
		</div>
		<div id="bloc">

			<form method="post" action="">
				<label for="nom">* Login:</label><input name="login" type="text"></input><br />
				<label for="nom">* Mot de passe:</label><input name="mdp" type="text"></input><br />
				<input name="envoie" type="submit"></input>
			</form>

			<?php
				// connexion à la base de données
				include('include/config.php');

				if(isset($_POST['envoie']))
					{
						$reponse = $bdd->query('SELECT * FROM visiteur WHERE login = "'.$_POST['login'].'" ');
						$connexion = $reponse->fetch();

						if($_POST['mdp'] == $connexion['mdp'])
						{
							echo 'Connexion réussie';
							$_SESSION['id'] =  $connexion['id'];
							 echo '<meta http-equiv="refresh" content="2;url=index.php"/>';
						}
						else
						{
							echo 'Mot de passe ou login incorrect !';
						}


					}

			?>
		</div>
	</div>


</body>

</html>