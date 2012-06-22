<?php
	$attib="";
	$photo="";
	$identifiant="";
	
	require_once('../config/config.php');
	$niveau_visa = $mcr;
	$page = "nt_oeuvrescpl";
	include('../include/securite.php');
	include('../include/fonctions.php');
	require_once('../Connections/alienorweblibre.php');
	(isset($_POST['chx_selection'])) ? $selection = $_POST['chx_selection'] : $selection = "" ;
	$tabselection = split('/',$selection);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
	<html lang="fr">
	<head>
		<title>Notice d&#8217;&#339;uvre compl&egrave;te</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<meta http-equiv="pragma" content="no-cache">
		<link href="../style/style_awl.css" rel="stylesheet" type="text/css" media="screen">
		<link href="../style/style_awl_print.css" rel="stylesheet" type="text/css" media="print">
	</head>
	<body>
		<?php
			$page =1;
			$valeur = 0;
			foreach($tabselection as $noFiche){
				$valeur = $valeur + 1;
				mysql_select_db($database_alienorweblibre, $alienorweblibre);
				$query_objets = "SELECT * FROM objet WHERE INDEX_OBJET = ".$noFiche."";
				$objets = mysql_query($query_objets, $alienorweblibre) or die(mysql_error());
				$row_objets = mysql_fetch_assoc($objets);
				?>
				<table style="border:solid #CCCCCC 1px;margin:20px;"><!--class="pleineLargueur" -->
					<tr>
						<td class="col_unQuart" style="white-space:nowrap;padding:5px;">
							<p><strong>N&deg; d&#8217;inventaire&nbsp;:</strong></p>
						</td>
						<td class="col_troisQuart" style="padding:5px;"><p><?php echo $row_objets['NUMERO_INVENTAIRE']; ?></p></td>
					</tr>
					<tr>
					  <td class="col_unQuart" style="white-space:nowrap;padding:5px;"><span class="souligne">D&eacute;nomination</span>&nbsp;:</td>
					  <td class="col_troisQuart" style="padding:5px;"><?php echo $row_objets['DENOMINATION']; ?></td>
				  </tr>
	<?php
		mysql_select_db($database_alienorweblibre, $alienorweblibre);
		$query_lieu = "SELECT lieu.INDEX_LIEU, SITE FROM lieu,obj_lie WHERE obj_lie.INDEX_OBJET =".$noFiche." AND lieu.INDEX_LIEU = obj_lie.INDEX_LIEU AND obj_lie.QUALIFIANT = 'LIEUX_DECOUVERTE' ORDER BY INDEX_OBJ_LIE ASC";
		$lieu = mysql_query($query_lieu, $alienorweblibre) or die(mysql_error());
		$row_lieu = mysql_fetch_assoc($lieu);
		$totalRows_lieu = mysql_num_rows($lieu);
		$i = 0 ;
		if($totalRows_lieu != 0){
	?>
					<tr>
						<td class="col_unQuart" style="white-space:nowrap;padding:5px;"><span class="souligne">Lieu&nbsp;de&nbsp;d&eacute;couverte</span>&nbsp;:</td>
						<td class="col_troisQuart" style="padding:5px;">
	<?php
						do {
							if ($i != 0) {
								echo ("<br />");
							}
							echo $row_lieu['SITE'];
							$i++;
						} while ($row_lieu = mysql_fetch_assoc($lieu));
	?>
						</td>
					</tr>
					
	<?php	}
		mysql_select_db($database_alienorweblibre, $alienorweblibre);
		$query_auteur = "SELECT personne.INDEX_PERSONNE, ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET =".$noFiche." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'SERVICE_GESTIONNAIRE' ORDER BY INDEX_OBJ_PER ASC";
		$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
		$row_auteur = mysql_fetch_assoc($auteur);
		$totalRows_auteur = mysql_num_rows($auteur);
		$i = 0;
		if($totalRows_auteur != 0){ ?>
					<tr>
						<td class="col_unQuart"  style="white-space:nowrap;padding:5px;"><span class="souligne">Service&nbsp;gestionnaire</span>&nbsp;:</td>
						<td class="col_troisQuart" style="padding:5px;">
	<?php
						do {
							if ($i != 0) {
								echo ("<br />\n");
							}
							echo $row_auteur['ETAT_CIVIL'];
							$i++;
						} while ($row_auteur = mysql_fetch_assoc($auteur));
	?>
						</td>
					</tr>
	<?php } ?>
			</table>
		<?php if(($valeur % 1) == 0)$page = $page + 1; ?>
		<?php } // fin du foreach ?>
 		<p class="copyright">Fiche obtenue sur AlienorWeb Libre, Pour plus d’informations sur AlienorWeb Libre : www.inter-regions-musees.org</p>
	</body>
</html>