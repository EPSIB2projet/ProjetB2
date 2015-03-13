<?php include('include/header.php');
ob_start(); ?>
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
				<select name="mois">
				<?php
				$reponse = $bdd->query('SELECT distinct mois FROM lignefraisforfait');
				while ($donnees = $reponse->fetch())
					{
						switch (substr($donnees['mois'], -2)) {
						    case 01:
						        $mois = "Janvier";
						        break;
						    case 02:
						        $mois = "Février";
						        break;
						    case 03:
						        $mois =  "Mars";
						        break;
						    case 04:
						        $mois =  "Avril";
						        break;
						    case 05:
						        $mois =  "Mai";
						        break;
						}

						echo '<option value="'.$donnees['mois'].'">'.$mois.' '.substr($donnees['mois'], 0, 4).'</option>';
					}

				?>
				
			</select>
			<input type="submit" name="envoie"/><br /><br />
				</form>
			<!-- TABLEAU 1 -->
			
						  
			<?php
			if(isset($_POST['envoie']))
				{
					echo '<table style="width:100%">
						  <tr>
						    <td>Forfait étape</td>
						    <td>Frais kilométrique</td>		
						    <td>Nuité hotel</td>
						    <td>Repas Restaurant</td>
						  </tr>
						  <tr>';
				$reponse = $bdd->query('SELECT * FROM lignefraisforfait WHERE mois = '.$_POST['mois'].' ');
				

				while ($donnees2 = $reponse->fetch())
					{
						?>
						
						  
						    <td><?php echo $donnees2['quantite']; ?></td>
						 
						
						

						<?php
					}
				}
			?>
                                                 
			  </tr>
			</table>
			<br /><br />

		<!-- TABLEAU 2 -->
		
						  
			<?php
			if(isset($_POST['envoie']))
				{
					echo '<table style="width:100%">
						  <tr>
						    <td>Date</td>
						    <td>Libellé</td>		
						    <td>Montant</td>
						  
						  </tr>
						  ';
				$reponse = $bdd->query('SELECT * FROM lignefraishorsforfait WHERE mois = '.$_POST['mois'].' ');
				

				while ($donnees2 = $reponse->fetch())
					{
						?>
						
						 <tr>
						    <td><?php echo $donnees2['date']; ?></td>
						    <td><?php echo $donnees2['libelle']; ?></td>
						    <td><?php echo $donnees2['montant']; ?></td>
						 </tr>
						
						

						<?php
					}
                                        echo '</table>';
                                       
                                        echo ' <center><a href="pdf.php?date='.$_POST['mois'].' ">Télécharger la page</a></center>';
				}
			?>
			 
			
                       
                </div>
	</div>

  



</body>

</html>