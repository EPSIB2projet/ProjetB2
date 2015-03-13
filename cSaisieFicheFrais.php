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



<?php

// à revoir
$reponse = $bdd->query('SELECT * FROM LigneFraisForfait WHERE idFraisForfait = "ETP" AND mois = "' . date("Ym") . '" ');
$donnees = $reponse->fetch();

$reponse2 = $bdd->query('SELECT * FROM LigneFraisForfait WHERE idFraisForfait = "KM" AND mois = "' . date("Ym") . '" ');
$donnees2 = $reponse2->fetch();

$reponse3 = $bdd->query('SELECT * FROM LigneFraisForfait WHERE idFraisForfait = "NUI" AND mois = "' . date("Ym") . '" ');
$donnees3 = $reponse3->fetch();

$reponse4 = $bdd->query('SELECT * FROM LigneFraisForfait WHERE idFraisForfait = "REP" AND mois = "' . date("Ym") . '" ');
$donnees4 = $reponse4->fetch();
?>
	 <?php
        echo "Eléments forfaitisés pour le mois de ";
        setlocale (LC_TIME, 'fr_FR.utf8','fra');
        echo (strftime("%B"));
     ?>
			<!-- Formulaire 1 - Eléments forfaitisés -->
			<form method="post" action="">
				<label for="nom">* Forfait Etape:</label><input name="forfaitetape" value="<?php echo $donnees['quantite']; ?>" type="text"></input><br />
                <label for="nom">* Frais Kilométrique:</label><input name="fraiskilo" value="<?php echo $donnees2['quantite']; ?>" type="text"></input><br />
				<label for="nom">* Nuitée Hotel:</label><input name="nuitee" value="<?php echo $donnees3['quantite']; ?>" type="text"></input><br />
				<label for="nom">* Repas Restaurant:</label><input name="repas" value="<?php echo $donnees4['quantite']; ?>" type="text"></input><br />
				<input name="envoie" type="submit"></input>
				<input name="reset" type="reset" value="Effacer"></input>
			</form>
                        

	
			
			<!-- AFFICHAGE  -  Descriptif des éléments hors forfait -->
			<?php
			$reponse_count = $bdd->query('SELECT COUNT(*) as NB FROM LigneFraisHorsForfait ');
			$donnees_count = $reponse_count->fetch();

			if($donnees_count['NB'] > 0)
			{
				echo '<br />Descriptif des éléments hors forfait';
				$reponse = $bdd->query('SELECT * FROM LigneFraisHorsForfait');
				echo '<table>';
				echo '<tr>
				<th>Date</th>
				<th>Libelle</th>
				<th>Montant</th>
				<th></th>
				</tr>';

				while($donnees = $reponse->fetch())
					{
						echo '<tr>';
						echo '<td>'.$donnees['date'].'</td>';
						echo '<td>'.$donnees['libelle'].'</td>';
						echo '<td>'.$donnees['montant'].'</td>';
						echo '<td><a href="">Supprimer</a></td>';
						echo '</tr>';
					}
				
				echo '</table>';
			}

			?>

			<br />

			Nouvel élément hors forfait
			<!-- Formulaire 2 - Nouvel élément hors forfait -->
			<form method="post" action="">
				<label for="nom">* Date:</label><input name="date"  type="date"></input><br />
				<label for="nom">* Libellé:</label><input name="libelle" type="text"></input><br />
				<label for="nom">* Montant:</label><input name="montant" type="text"></input><br />
				<input name="envoie2" type="submit"></input>
				<input name="reset" type="reset" value="Effacer"></input>
			</form>


			<?php
                if(isset($_POST['envoie']))
                {
                    include('include/config.php');

                    $reponse_count = $bdd->query('SELECT COUNT(*) as NB FROM LigneFraisForfait WHERE mois = "' . date("Ym") . '" ');
                    $donnees_count = $reponse_count->fetch();

                    if($donnees_count['NB'] > 0) {

                        $sth = $bdd->prepare('UPDATE LigneFraisForfait SET quantite = :forfaitetape WHERE idFraisForfait = "ETP" AND mois = "' . date("Ym") . '" ');
                        $sth->bindValue(':forfaitetape', $_POST['forfaitetape'], PDO::PARAM_STR);
                        $sth->execute();

                        $sth = $bdd->prepare('UPDATE LigneFraisForfait SET quantite = :fraiskilo WHERE idFraisForfait = "KM" AND mois = "' . date("Ym") . '"  ');
                        $sth->bindValue(':fraiskilo', $_POST['fraiskilo'], PDO::PARAM_STR);
                        $sth->execute();

                        $sth = $bdd->prepare('UPDATE LigneFraisForfait SET quantite = :nuitee WHERE idFraisForfait = "NUI" AND mois = "' . date("Ym") . '"  ');
                        $sth->bindValue(':nuitee', $_POST['nuitee'], PDO::PARAM_STR);
                        $sth->execute();

                        $sth = $bdd->prepare('UPDATE LigneFraisForfait SET quantite = :repas WHERE idFraisForfait = "REP" AND mois = "' . date("Ym") . '"  ');
                        $sth->bindValue(':repas', $_POST['repas'], PDO::PARAM_STR);
                        $sth->execute();
                    }
                    else{
                        $sth = $bdd->prepare('INSERT INTO LigneFraisForfait (idVisiteur, mois, idFraisForfait, quantite) VALUES (:id, :mois, :idfraisforfait, :qte)');
                        $sth->bindValue(':id', $_SESSION['id'], PDO::PARAM_STR);
                        $sth->bindValue(':mois', date('Ym'), PDO::PARAM_STR);
                        $sth->bindValue(':idfraisforfait', "ETP", PDO::PARAM_STR);
                        $sth->bindValue(':qte', $_POST['forfaitetape'], PDO::PARAM_STR);
                        $sth->execute();

                        $sth = $bdd->prepare('INSERT INTO LigneFraisForfait (idVisiteur, mois, idFraisForfait, quantite) VALUES (:id, :mois, :idfraisforfait, :qte)');
                        $sth->bindValue(':id', $_SESSION['id'], PDO::PARAM_STR);
                        $sth->bindValue(':mois', date('Ym'), PDO::PARAM_STR);
                        $sth->bindValue(':idfraisforfait', "KM", PDO::PARAM_STR);
                        $sth->bindValue(':qte', $_POST['fraiskilo'], PDO::PARAM_STR);
                        $sth->execute();

                        $sth = $bdd->prepare('INSERT INTO LigneFraisForfait (idVisiteur, mois, idFraisForfait, quantite) VALUES (:id, :mois, :idfraisforfait, :qte)');
                        $sth->bindValue(':id', $_SESSION['id'], PDO::PARAM_STR);
                        $sth->bindValue(':mois', date('Ym'), PDO::PARAM_STR);
                        $sth->bindValue(':idfraisforfait', "NUI", PDO::PARAM_STR);
                        $sth->bindValue(':qte', $_POST['nuitee'], PDO::PARAM_STR);
                        $sth->execute();

                        $sth = $bdd->prepare('INSERT INTO LigneFraisForfait (idVisiteur, mois, idFraisForfait, quantite) VALUES (:id, :mois, :idfraisforfait, :qte)');
                        $sth->bindValue(':id', $_SESSION['id'], PDO::PARAM_STR);
                        $sth->bindValue(':mois', date('Ym'), PDO::PARAM_STR);
                        $sth->bindValue(':idfraisforfait', "REP", PDO::PARAM_STR);
                        $sth->bindValue(':qte', $_POST['repas'], PDO::PARAM_STR);
                        $sth->execute();
                    }


                    echo 'modification réussie';
                    echo '<meta http-equiv="refresh" content="2;url="/>';

                }

				if(isset($_POST['envoie2']))
                {
					include('include/config.php');

                            $sth = $bdd->prepare('INSERT INTO LigneFraisHorsForfait (id, idVisiteur, mois, libelle, date, montant) VALUES (NULL, :idVisiteur, :mois, :libelle, :date, :montant)');
		            $sth->bindValue(':idVisiteur', $_SESSION['id'], PDO::PARAM_STR);
		            $sth->bindValue(':libelle', $_POST['libelle'], PDO::PARAM_STR);
		            $sth->bindValue(':montant', $_POST['montant'], PDO::PARAM_STR);
		            $sth->bindValue(':mois', date('Ym'), PDO::PARAM_STR);
		            $sth->bindValue(':date', $_POST['date'], PDO::PARAM_STR);
		            $sth->execute();

					echo 'modification réussie';
					echo '<meta http-equiv="refresh" content="0;url="/>';

                }

			?>
		</div>
	</div>


</body>

</html>
