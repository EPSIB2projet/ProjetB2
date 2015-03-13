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
                    Validation des frais par visiteur<br />
                    <form action="" method="post">
                      <label for="nom">Choisir le visiteur : </label>
                      <select name="visiteur">
				<?php
                                
                                include('include/config.php'); 
                                
				$reponse = $bdd->query('SELECT nom,prenom,id FROM visiteur');
				while ($donnees = $reponse->fetch())
					{
						echo '<option value="'.$donnees['id'].'">'.$donnees['nom'].' '.$donnees['prenom'].'</option>';
					}

				?>
				
			</select>
                      <br />
                      <label for="nom">Mois : </label>
                      <select name="mois">
				<?php
                                
                                include('include/config.php'); 
                                
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
				
			</select><br />
                      <input type="submit" name="envoie" value="Envoyer"/>
                    </form>
                   <?php
                    if(isset($_POST['envoie'])) 
                    {
                        include('include/config.php');
                        $reponse_count = $bdd->query('SELECT COUNT(*) as NB FROM lignefraisforfait WHERE mois = "'.$_POST['mois'].'" AND idVisiteur = "'.$_POST['visiteur'].'" ');
			$donnees_count = $reponse_count->fetch();

			if($donnees_count['NB'] > 0)
			{
				echo '<br /><h2>Frais au forfait</h2>';
                                
				$reponse_etp = $bdd->query('SELECT * FROM lignefraisforfait WHERE mois = "'.$_POST['mois'].'" AND idVisiteur = "'.$_POST['visiteur'].'" AND idFraisForfait = "ETP" ');
                                $etp = $reponse_etp->fetch();
                                
                                $reponse_km = $bdd->query('SELECT * FROM lignefraisforfait WHERE mois = "'.$_POST['mois'].'" AND idVisiteur = "'.$_POST['visiteur'].'" AND idFraisForfait = "KM" ');
                                $km = $reponse_km->fetch();
                                
                                $reponse_nui = $bdd->query('SELECT * FROM lignefraisforfait WHERE mois = "'.$_POST['mois'].'" AND idVisiteur = "'.$_POST['visiteur'].'" AND idFraisForfait = "NUI" ');
                                $nui = $reponse_nui->fetch();
                                
                                $reponse_rep = $bdd->query('SELECT * FROM lignefraisforfait WHERE mois = "'.$_POST['mois'].'" AND idVisiteur = "'.$_POST['visiteur'].'" AND idFraisForfait = "REP" ');
                                $rep = $reponse_rep->fetch();
                                 
                                echo '<form action="" method="post">';
				echo '<table style="width:100%">
                                        <tr>
                                            <td>Forfait étape</td>
                                            <td>Frais kilométrique</td>		
                                            <td>Nuité hotel</td>
                                            <td>Repas Restaurant</td>
                                            <td>Situation</td>
                                        </tr>
                                        <tr>';
					
                                        echo "<td><input value='".$etp["quantite"]."' size='5'/></td>";
                                        echo "<td><input value='".$km["quantite"]."' size='5'/></td>";
                                        echo "<td><input value='".$nui["quantite"]."' size='5'/></td>";
                                        echo "<td><input value='".$rep["quantite"]."' size='5'/></td>";
                                ?>
                               <td>
                                   <select name=situation>
                                       <option>Enregistré</option> 
                                       <option>Validé</option>
                                       <option>Remboursé</option>
                                  </select>
                               </td>
				<?php
				echo '</table><br/>';
                                 
			}
                  
                        
                    }
                   ?>     
                               
                               <?php
			if(isset($_POST['envoie']))
				{
					echo '<table style="width:100%">
						  <tr>
						    <td>Date</td>
						    <td>Libellé</td>		
						    <td>Montant</td>
                                                    <td>Situation</td>
						  
						  </tr>
						  ';
				$reponse = $bdd->query('SELECT * FROM lignefraishorsforfait WHERE mois = '.$_POST['mois'].' AND idVisiteur = "'.$_POST['visiteur'].'" ');
				

				while ($donnees2 = $reponse->fetch())
					{
						?>
						
						 <tr>
                                                  
						    <td><input name="date_hf" value="<?php echo $donnees2['date']; ?>" /></td>
						    <td><input name="libelle" size="5" value="<?php echo $donnees2['libelle']; ?>" /></td>
						    <td><input name="montant" size="6" value="<?php echo $donnees2['montant']; ?>" /></td>
                                               
                                                    <td>
                                                        <select  name="situation2">
                                                            <option>Enregistré</option> 
                                                            <option>Validé</option>
                                                            <option>Remboursé</option>
                                                       </select>
                                                    </td>
						 </tr>
						<?php
					}
                                        echo '</table><br/>';
                                        echo 'Nombre de justificatifs <input value="0" type="text" name="justificatif" /><br />';
                                        echo '<input type="submit" name="valider" value="Valider" />';
                                        echo '</form>';
				}
			?>
                                                 
                                                <?php
                                                if(isset($_POST['valider'])) 
                                                    {
                                                    
                                                    echo $_POST['situation2'];
                                                        echo 'ok';
                                                    }
                                                ?>
                </div>
	</div>
</body>

</html>