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
		Déconnexion réussie

			<?php
			unset($_SESSION['id']);
			 echo '<meta http-equiv="refresh" content="2;url=index.php"/>';
			?>
		</div>
	</div>


</body>

</html>