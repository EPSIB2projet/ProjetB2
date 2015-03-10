<?php
/**
 * HTML2PDF Librairy - example
 *
 * HTML => PDF convertor
 * distributed under the LGPL License
 *
 * @author      Laurent MINGUET <webmaster@html2pdf.fr>
 *
 * isset($_GET['vuehtml']) is not mandatory
 * it allow to display the result in the HTML format
 */

ob_start();
?>
<style type="text/css">
<!--
    table.page_header {width: 100%; border: none; background-color: #DDDDFF; border-bottom: solid 1mm #AAAADD; padding: 2mm }
    table.page_footer {width: 100%; border: none; background-color: #DDDDFF; border-top: solid 1mm #AAAADD; padding: 2mm}
    h1 {color: #000033}
    h2 {color: #000055}
    h3 {color: #000077}

    div.niveau
    {
        padding-left: 5mm;
    }
-->
</style>


    <page backtop="7mm" backbottom="7mm" backleft="10mm" backright="10mm"> 
        <page_header> 
       
        </page_header> 
        <page_footer> 
            
        </page_footer> 
       
            <img src="images/logo.jpg"><br />
             ETAT DE FRAIS ENGAGE<br />
             A retourner accompagné des justificatifs au plus tard le 10 du mois qui suit l'engagement des frais<br /><br />
        
        <?php

        include('include/config.php');

        echo $_GET['date'];
        
        $reponse = $bdd->query('SELECT * FROM `lignefraisforfait`, fraisforfait WHERE fraisforfait.id = lignefraisforfait.idfraisforfait AND mois = "'.$_GET['date'].'" AND id = "KM" ');
        $requete_km = $reponse ->fetch();

        $reponse2 = $bdd->query('SELECT * FROM `lignefraisforfait`, fraisforfait WHERE fraisforfait.id = lignefraisforfait.idfraisforfait AND mois = "'.$_GET['date'].'"  AND id = "NUI" ');
        $requete_nui = $reponse2 ->fetch(); 

        $reponse3 = $bdd->query('SELECT * FROM `lignefraisforfait`, fraisforfait WHERE fraisforfait.id = lignefraisforfait.idfraisforfait
        AND mois = "'.$_GET['date'].'"  AND id = "REP" ');
        $requete_rep = $reponse3 ->fetch();      
        ?>
        
        <?php 
        $padding_left = 50;
        $padding_right = 50;
        ?>
        
     <table border="1" style=" border: solid 1px black;">
         <tr>
          <td style="padding-left:<?php echo $padding_left; ?>;padding-right:<?php echo $padding_right; ?>">Frais Forfaitaires</td>
          <td style="padding-left:<?php echo $padding_left; ?>;padding-right:<?php echo $padding_right; ?>">Quantité</td>		
          <td style="padding-left:<?php echo $padding_left; ?>;padding-right:<?php echo $padding_right; ?>">Montant unitaire</td>
          <td style="padding-left:<?php echo $padding_left; ?>;padding-right:<?php echo $padding_right; ?>">Total</td>
        </tr>
        <tr>
          <td  style="padding-left:<?php echo $padding_left; ?>;padding-right:<?php echo $padding_right; ?>">Nuitée</td>
          <td  style="padding-left:<?php echo $padding_left; ?>;padding-right:<?php echo $padding_right; ?>"><?php echo $requete_nui['quantite']; ?></td>		
          <td style="padding-left:<?php echo $padding_left; ?>;padding-right:<?php echo $padding_right; ?>"> <?php echo $requete_nui['montant']; ?></td>
          <td style="padding-left:<?php echo $padding_left; ?>;padding-right:<?php echo $padding_right; ?>"><?php $total = $requete_nui['quantite'] * $requete_nui['montant']; echo $total.' €'; ?></td>
        </tr>

        <tr>
          <td style="padding-left:<?php echo $padding_left; ?>;padding-right:<?php echo $padding_right; ?>">Repas midi</td>
           <td style="padding-left:<?php echo $padding_left; ?>;padding-right:<?php echo $padding_right; ?>"><?php echo $requete_rep['quantite']; ?></td>		
          <td style="padding-left:<?php echo $padding_left; ?>;padding-right:<?php echo $padding_right; ?>"><?php echo $requete_rep['montant']; ?></td>
          <td style="padding-left:<?php echo $padding_left; ?>;padding-right:<?php echo $padding_right; ?>"><?php $total = $requete_rep['quantite'] * $requete_rep['montant']; echo $total.' €'; ?></td>
        </tr>

        <tr>
          <td style="padding-left:<?php echo $padding_left; ?>;padding-right:<?php echo $padding_right; ?>">Kilométrage</td>
           <td style="padding-left:<?php echo $padding_left; ?>;padding-right:<?php echo $padding_right; ?>"><?php echo $requete_km['quantite']; ?></td>		
          <td style="padding-left:<?php echo $padding_left; ?>;padding-right:<?php echo $padding_right; ?>"><?php echo $requete_km['montant']; ?></td>
          <td style="padding-left:<?php echo $padding_left; ?>;padding-right:<?php echo $padding_right; ?>"><?php $total = $requete_km['quantite'] * $requete_km['montant']; echo $total.' €'; ?></td>
        </tr>
    </table>
        
        
        <br /><br />
        <?php
			
					echo '<table border="1" style="width:1000px">
						  <tr>
						    <td>Date</td>
						    <td>Libellé</td>		
						    <td>Montant</td>
						  
						  </tr>
						  ';
				$reponse = $bdd->query('SELECT * FROM lignefraishorsforfait WHERE mois = "'.$_GET['date'].'" ');
				

				while ($donnees2 = $reponse->fetch())
					{
						?>
						
						 <tr>
						    <td  style="padding-left:<?php echo $padding_left; ?>;padding-right:<?php echo $padding_right; ?>"><?php echo $donnees2['date']; ?></td>
						    <td style="padding-left:<?php echo $padding_left; ?>;padding-right:<?php echo $padding_right; ?>"php echo $donnees2['libelle']; ?></td>
						    <td style="padding-left:<?php echo $padding_left; ?>;padding-right:<?php echo $padding_right; ?>"><?php echo $donnees2['montant']; ?></td>
						 </tr>
						
						

						<?php
					}
				
			?>
			 
			</table>        
   </page> 

   <?php 
        $content = ob_get_clean(); 
         require_once(dirname(__FILE__).'/html2pdf_v4.03/html2pdf.class.php');
        $pdf = new HTML2PDF('P','A4','fr','utf-8', false); 
        $pdf->writeHTML($content); 
        $pdf->Output(); 
   ?>