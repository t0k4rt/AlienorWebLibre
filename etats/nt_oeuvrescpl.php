<?php	
/********* Déclaration des variables **********/
	$attib="";
	$photo="";
	$identifiant="";
	
	require_once('../config/config.php');
	$niveau_visa = $mcr;
	$page = "nt_oeuvrescpl";
	include('../include/securite.php');
	include('../include/fonctions.php');
?><?php require_once('../Connections/alienorweblibre.php'); ?><?php
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
	<table class="enteteTableau">
		<tr>
			<td colspan="2" class="titrepage centrer">Notice d&#8217;&#339;uvre compl&egrave;te</td>
		</tr>
		<tr>
			<td class="enteteCol_1">&nbsp;</td>
			<td class="enteteCol_2">&Eacute;dition du <?php echo(date("d.m.Y")); ?></td>
		</tr>
		<tr>
			<td class="enteteCol_1">&nbsp;</td>
			<td class="enteteCol_2">Page <?php echo $page ?></td>
		</tr>
	</table>
	<br>
	<table class="bdrEtat">
		<tr>
			<td>
				<table class="tableauConteneurGlob">
					<tr>
						<td class="contenuTexte">
							<table class="pleineLargueur">
								<tr>
									<td colspan="2">
										<p class="texteImportant"><?php echo $row_objets['LOCALISATION']; ?><br>
										<strong>N&deg; d&#8217;inventaire : <?php echo $row_objets['NUMERO_INVENTAIRE']; ?></strong></p>
									</td>
								</tr>
								<tr>
									<td class="col_unQuart">&nbsp;</td>
									<td class="col_troisQuart"><?php
										mysql_select_db($database_alienorweblibre, $alienorweblibre);
										$query_lieu = "SELECT lieu.INDEX_LIEU, SITE FROM lieu,obj_lie WHERE obj_lie.INDEX_OBJET =".$noFiche." AND lieu.INDEX_LIEU = obj_lie.INDEX_LIEU AND obj_lie.QUALIFIANT = 'LIEUX_DECOUVERTE' ORDER BY INDEX_OBJ_LIE ASC";
										$lieu = mysql_query($query_lieu, $alienorweblibre) or die(mysql_error());
										$row_lieu = mysql_fetch_assoc($lieu);
										$totalRows_lieu = mysql_num_rows($lieu);
										$i = 0 ;
										if ($totalRows_lieu != 0) {
											do {
												if ($i != 0) {
													echo ("<br>");
												}
												echo $row_lieu['SITE'];
												$i++;
											} while ($row_lieu = mysql_fetch_assoc($lieu));
										} ?>
										<?php if ($totalRows_lieu == 0) { ?><br>
											<?php
											mysql_select_db($database_alienorweblibre, $alienorweblibre);
											$query_auteur = "SELECT personne.* FROM personne,obj_per WHERE obj_per.INDEX_OBJET =".$noFiche." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'AUTEUR' ORDER BY INDEX_OBJ_PER ASC";
											$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
											$row_auteur = mysql_fetch_assoc($auteur);
											$totalRows_auteur = mysql_num_rows($auteur);
											if ($totalRows_auteur != 0) { ?>
												<span class=""souligne"">Auteur(s)</span> :
												<?php
												$tabAuteurRole = split('[/]',$row_objets['ROLE']);
												$nbtabaut = count($tabAuteurRole[$i]);
												$i = 0;
													do {
														if ($i != 0) {
															echo ("<br>\n");
														}
														echo $row_auteur['ETAT_CIVIL']." ";
														$noPerso = $row_auteur['INDEX_PERSONNE'];
														if ($nbtabaut <= $i && $tabAuteurRole[$i] != "") {
															echo " (";
															echo $tabAuteurRole[$i].") ";
														}
														
														// Traiement "masculin/féminin"
														switch($row_auteur['GENRE']) {
															case "masculin" :
																$nai = "né";
																$dec = "décédé";
																break;
															case "féminin" :
																$nai = "née";
																$dec = "décédée";
																break;
															default :
																$nai = "";
																$dec = "";				
														}
														
														// ****************** début naissance *******************************
														$marquen = false;
														if ($row_auteur['NAISSANCE_DEBDATEDEBUT'] != "0000-00-00") {
															echo $nai." ";
															echo traitementDate($row_auteur['NAISSANCE_TXTDATEDEBUT'],reverseDate($row_auteur['NAISSANCE_DEBDATEDEBUT']),reverseDate($row_auteur['NAISSANCE_FINDATEDEBUT']));
															$marquen = true;
														}
																
														if ($noPerso != 0) {
														mysql_select_db($database_alienorweblibre, $alienorweblibre);
														$query_lieu = "SELECT lieu.INDEX_LIEU, SITE FROM lieu,per_lie WHERE per_lie.INDEX_PERSONNE =".$noPerso." AND lieu.INDEX_LIEU = per_lie.INDEX_LIEU AND per_lie.QUALIFIANT = 'LIEU_NAISSANCE'";
														$lieu = mysql_query($query_lieu, $alienorweblibre) or die(mysql_error());
														$row_lieu = mysql_fetch_assoc($lieu);
														$totalRows_lieu = mysql_num_rows($lieu);
														$u = 0 ;
															do {
																if ($u != 0) {
																	echo ("<br>\n");
																}
																if ($row_lieu['SITE'] != "") {
																	(!$marquen) ? $nai = $nai : $nai = "";
																	echo(" ".$nai." à ");
																}
																echo $row_lieu['SITE'];
																$u++;
															} while ($row_lieu = mysql_fetch_assoc($lieu));
														}
														// ****************** fin naissance *******************************
				
														// ****************** début décès *******************************
														$marqued = false;
														if ($row_auteur['DECES_DEBDATEDEBUT'] != "0000-00-00") {
															echo " ".$dec." ";
															echo traitementDate($row_auteur['DECES_TXTDATEDEBUT'],reverseDate($row_auteur['DECES_DEBDATEDEBUT']),reverseDate($row_auteur['DECES_FINDATEDEBUT']));
															$marqued = true;
														}
														
														if ($noPerso != 0) {		
														mysql_select_db($database_alienorweblibre, $alienorweblibre);
														$query_lieu = "SELECT lieu.INDEX_LIEU, SITE FROM lieu,per_lie WHERE per_lie.INDEX_PERSONNE =".$noPerso." AND lieu.INDEX_LIEU = per_lie.INDEX_LIEU AND per_lie.QUALIFIANT = 'LIEU_DECES'";
														$lieu = mysql_query($query_lieu, $alienorweblibre) or die(mysql_error());
														$row_lieu = mysql_fetch_assoc($lieu);
														$totalRows_lieu = mysql_num_rows($lieu);
														$u = 0 ;
															do {
																if ($u != 0) {
																	echo ("<br>\n");
																}
																if ($row_lieu['SITE'] != "") { 
																	(!$marqued) ? $dec = $dec : $dec = "";
																	echo(" ".$dec." à ");
																}
																echo $row_lieu['SITE'];
																$u++;
															} while ($row_lieu = mysql_fetch_assoc($lieu));
														}
														// ****************** fin décès *******************************
													
													// Boucle auteur
														$i++;
													} while ($row_auteur = mysql_fetch_assoc($auteur));?>
												<?php } ?>
											<?php } ?></td>
								</tr>
								<tr>
									<td class="col_unQuart">&nbsp;</td>
									<td class="col_troisQuart"> <?php
										mysql_select_db($database_alienorweblibre, $alienorweblibre);
										$query_auteur = "SELECT personne.INDEX_PERSONNE,ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET =".$noFiche." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'ATTRIBUTION' ORDER BY INDEX_OBJ_PER ASC";
										$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
										$row_auteur = mysql_fetch_assoc($auteur);
										$totalRows_auteur = mysql_num_rows($auteur);
										$i = 0;
											do { 
												if ($i != 0 ) {
													echo ("<br>");
												}
											?> <span class="tddesignation"><?php ($row_auteur['GENRE'] = "masculin") ? $attrib = "attribué" : $attrib = "attribuée" ;
											echo  $attib; ?>&nbsp;</span> <?php
												if(isset($row_auteur['ETAT_CIVIL'])){
												echo $row_auteur['ETAT_CIVIL'];}
												$i++;
											} while ($row_auteur = mysql_fetch_assoc($auteur)); ?><?php
										mysql_select_db($database_alienorweblibre, $alienorweblibre);
										$query_auteur = "SELECT personne.INDEX_PERSONNE, personne.ETAT_CIVIL, personne.GENRE FROM personne,obj_per WHERE obj_per.INDEX_OBJET =".$noFiche." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'ATTRIBUTEUR' ORDER BY INDEX_OBJ_PER ASC";
										$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
										$row_auteur = mysql_fetch_assoc($auteur);
										$totalRows_auteur = mysql_num_rows($auteur);
										$i = 0;
											do { 
												if ($i != 0) {
													echo ("<br>\n");
												} if ($row_auteur['ETAT_CIVIL'] != "") { echo "par "; }
												echo $row_auteur['ETAT_CIVIL'];
												$i++;
											} while ($row_auteur = mysql_fetch_assoc($auteur));
											if ($row_objets['DEB_DATE_ATTRIBUTION'] != "" && $row_objets['DEB_DATE_ATTRIBUTION'] != "0000-00-00") {
											echo traitementDate($row_objets['TXT_DATE_ATTRIBUTION'],reverseDate($row_objets['DEB_DATE_ATTRIBUTION']),reverseDate($row_objets['FIN_DATE_ATTRIBUTION'])); } ?></td>
								</tr>
								<tr>
									<td class="col_unQuart">&nbsp;</td>
									<td class="col_troisQuart">&nbsp;</td>
								</tr>
								<tr>
									<td colspan="2"><span class="souligne"><strong>IDENTIFICATION</strong></span></td>
								</tr>
								<tr>
									<td class="col_unQuart"><span class="souligne">Discipline</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php echo $row_objets['DISCIPLINE']; ?></td>
								</tr>
								<tr>
									<td class="col_unQuart"><span class="souligne">Domaine</span>&nbsp;:</td>
									<td colspan="2" class="col_troisQuart"><?php echo $row_objets['DOMAINE']; ?></td>
								</tr>
								<?php if ($row_objets['TITRE'] != "") { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Titre</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php echo nl2br($row_objets['TITRE']); ?></td>
								</tr>
								<?php } ?> <?php if ($row_objets['DENOMINATION'] != "") { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">D&eacute;nomination</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php echo $row_objets['DENOMINATION']; ?></td>
								</tr>
								<?php } ?> <?php if ($row_objets['TAXONOMIE'] != "") { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Taxonomie</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php echo $row_objets['TAXONOMIE']; ?></td>
								</tr>
								<?php } ?> <?php if ($row_objets['TYPOLOGIE'] != "") { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Typologie</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php echo $row_objets['TYPOLOGIE']; ?></td>
								</tr>
								<?php } ?> <?php if ($row_objets['APPELLATION'] != "") { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Appellation</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php echo $row_objets['APPELLATION']; ?></td>
								</tr>
								<?php } ?> <?php if ($row_objets['VERNACULAIRE'] != "") { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Appellation&nbsp;vernaculaire</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php echo $row_objets['VERNACULAIRE']; ?></td>
								</tr>
								<?php } ?> <?php if ($row_objets['NB_EXEMPLAIRE'] != "" && $row_objets['NB_EXEMPLAIRE'] != 0) { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Nombre&nbsp;d&#8217;exemplaire</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php echo $row_objets['NB_EXEMPLAIRE']; ?></td>
								</tr>
								<?php } ?>
								<tr>
									<td class="col_unQuart">&nbsp;</td>
									<td class="col_troisQuart">&nbsp;</td>
								</tr>
								<!-- Début de section Données sur la découverte -->
								<tr>
									<td colspan="2"><span class="souligne"><strong>DONN&Eacute;ES SUR LA D&Eacute;COUVERTE</strong></span></td>
								</tr>
								<?php
								mysql_select_db($database_alienorweblibre, $alienorweblibre);
								$query_lieu = "SELECT lieu.INDEX_LIEU, SITE FROM lieu,obj_lie WHERE obj_lie.INDEX_OBJET =".$noFiche." AND lieu.INDEX_LIEU = obj_lie.INDEX_LIEU AND obj_lie.QUALIFIANT = 'LIEUX_DECOUVERTE' ORDER BY INDEX_OBJ_LIE ASC";
								$lieu = mysql_query($query_lieu, $alienorweblibre) or die(mysql_error());
								$row_lieu = mysql_fetch_assoc($lieu);
								$totalRows_lieu = mysql_num_rows($lieu);
								$i = 0 ;
								if ($totalRows_lieu != 0) { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Lieu&nbsp;de&nbsp;d&eacute;couverte</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php
										do {
											if ($i != 0) {
												echo ("<br>");
											}
											echo $row_lieu['SITE'];
											$i++;
										} while ($row_lieu = mysql_fetch_assoc($lieu)); ?></td>
								</tr>
								<?php } ?> <?php if ($row_objets['DEB_DATE_DECOUVERTE'] != "" && $row_objets['DEB_DATE_DECOUVERTE'] != "0000-00-00") { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Date de d&eacute;couverte</span> :</td>
									<td class="col_troisQuart"><?php echo traitementDate($row_objets['TXT_DATE_DECOUVERTE'],reverseDate($row_objets['DEB_DATE_DECOUVERTE']),reverseDate($row_objets['FIN_DATE_DECOUVERTE'])); ?></td>
								</tr>
								<?php } ?> <?php if ($row_objets['PRECISION_DECOUVERTE'] != "") { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Pr&eacute;cision&nbsp;sur&nbsp;la&nbsp;d&eacute;couverte</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php echo $row_objets['PRECISION_DECOUVERTE']; ?></td>
								</tr>
								<?php } ?> <?php
									mysql_select_db($database_alienorweblibre, $alienorweblibre);
									$query_auteur = "SELECT personne.INDEX_PERSONNE, ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET =".$noFiche." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'INVENTEUR' ORDER BY INDEX_OBJ_PER ASC";
									$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
									$row_auteur = mysql_fetch_assoc($auteur);
									$totalRows_auteur = mysql_num_rows($auteur);
									$i = 0;
									if ($totalRows_auteur != 0) { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Inventeur</span>&nbsp;:</td>
									<td class="col_troisQuart"> <?php 
										do {
											if ($i != 0) {
												echo ("<br>\n");
											}
											echo $row_auteur['ETAT_CIVIL'];
											$i++;
										} while ($row_auteur = mysql_fetch_assoc($auteur)); ?></td>
								</tr>
								<?php } 
									mysql_select_db($database_alienorweblibre, $alienorweblibre);
									$query_auteur = "SELECT personne.INDEX_PERSONNE, ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET =".$noFiche." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'COLLECTEUR' ORDER BY INDEX_OBJ_PER ASC";
									$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
									$row_auteur = mysql_fetch_assoc($auteur);
									$totalRows_auteur = mysql_num_rows($auteur);
									$i = 0;
									if ($totalRows_auteur != 0) { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Collecteur</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php
										do {
											if ($i != 0) {
												echo ("<br>\n");
											}
											echo $row_auteur['ETAT_CIVIL'];
											$i++;
										} while ($row_auteur = mysql_fetch_assoc($auteur)); ?></td>
								</tr>
								<?php } ?> <?php if ($row_objets['TYPE_COLLECTE'] != "") { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Type de collecte</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php echo $row_objets['TYPE_COLLECTE']; ?></td>
								</tr>
								<?php } ?>
								<tr>
									<td class="col_unQuart">&nbsp;</td>
									<td class="col_troisQuart">&nbsp;</td>
								</tr>
								<tr>
									<td colspan="2"><span class="souligne"><strong>DESCRIPTION</strong></span></td>
								</tr>
								<?php if ($row_objets['MATIERE'] != "") { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Mati&egrave;re</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php echo $row_objets['MATIERE']; ?></td>
								</tr>
								<?php } ?>
								<?php if ($row_objets['TECHNIQUE'] != "") { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Technique</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php echo $row_objets['TECHNIQUE']; ?></td>
								</tr>
								<?php } ?>
								<?php if ($row_objets['DIMENSIONS_FORMES'] != "") { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Dimensions et formes</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php echo nl2br($row_objets['DIMENSIONS_FORMES']); ?></td>
								</tr>
								<?php } ?> <?php if ($row_objets['ENCOMBREMENT'] != "") { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Encombrement</span> :</td>
									<td class="col_troisQuart"><?php echo $row_objets['ENCOMBREMENT']; ?></td>
								</tr>
								<?php } ?> <?php if ($row_objets['TRANSCRIPTION_INSCRIPTION'] != "") { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Inscriptions</span> :</td>
									<td class="col_troisQuart"><?php echo nl2br($row_objets['TRANSCRIPTION_INSCRIPTION']); ?></td>
								</tr>
								<?php } ?> <?php if ($row_objets['ONOMASTIQUE'] != "") { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Onomastique</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php echo nl2br($row_objets['ONOMASTIQUE']); ?></td>
								</tr>
								<?php } ?> <?php if ($row_objets['REPRESENTATION_DECOR'] != "") { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Repr&eacute;sentations&nbsp;et&nbsp;d&eacute;cors</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php echo $row_objets['REPRESENTATION_DECOR']; ?></td>
								</tr>
								<?php } ?> <?php if ($row_objets['PRECISION_DESCRIPTION'] != "") { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Description</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php echo nl2br($row_objets['PRECISION_DESCRIPTION']); ?></td>
								</tr>
								<?php } ?>
								<?php
								mysql_select_db($database_alienorweblibre, $alienorweblibre);
								$query_auteur = "SELECT personne.INDEX_PERSONNE, ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET =".$noFiche." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'DESCRIPTEUR' ORDER BY INDEX_OBJ_PER ASC";
								$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
								$row_auteur = mysql_fetch_assoc($auteur);
								$totalRows_auteur = mysql_num_rows($auteur);
								$i = 0;
								if ($totalRows_auteur != 0) { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Descripteur</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php
										do {
											if ($i != 0) {
												echo ("<br>\n");
											}
											echo $row_auteur['ETAT_CIVIL'];
											$i++;
										} while ($row_auteur = mysql_fetch_assoc($auteur)); ?></td>
								</tr>
								<?php } ?>
								<?php if ($row_objets['DETERMINATEUR_PARAM'] != "") { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Taxonomie d&eacute;termin&eacute;e</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php echo $row_objets['DETERMINATEUR_PARAM']; ?></td>
								</tr>
								<?php } ?>
								<?php
								mysql_select_db($database_alienorweblibre, $alienorweblibre);
								$query_auteur = "SELECT personne.INDEX_PERSONNE, ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET =".$noFiche." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'DETERMINATEUR' ORDER BY INDEX_OBJ_PER ASC";
								$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
								$row_auteur = mysql_fetch_assoc($auteur);
								$totalRows_auteur = mysql_num_rows($auteur);
								$i = 0;
								if ($totalRows_auteur != 0) { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">D&eacute;terminateur</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php
										do { 
											if ($i != 0) {
												echo ("<br>\n");
											}
											echo $row_auteur['ETAT_CIVIL'];
											$i++;
										} while ($row_auteur = mysql_fetch_assoc($auteur)); ?></td>
								</tr><?php } ?>
								<tr>
									<td class="col_unQuart">&nbsp;</td>
									<td class="col_troisQuart">&nbsp;</td>
								</tr>
								<tr>
									<td colspan="2"><span class="souligne"><strong>DONN&Eacute;ES SUR L&#8217;EX&Eacute;CUTION</strong></span></td>
								</tr>
								<?php
								mysql_select_db($database_alienorweblibre, $alienorweblibre);
								$query_lieu = "SELECT lieu.INDEX_LIEU, SITE FROM lieu,obj_lie WHERE obj_lie.INDEX_OBJET =".$noFiche." AND lieu.INDEX_LIEU = obj_lie.INDEX_LIEU AND obj_lie.QUALIFIANT = 'LIEUX_EXECUTION' ORDER BY INDEX_OBJ_LIE ASC";
								$lieu = mysql_query($query_lieu, $alienorweblibre) or die(mysql_error());
								$row_lieu = mysql_fetch_assoc($lieu);
								$totalRows_lieu = mysql_num_rows($lieu);
								$i = 0 ;
								if ($totalRows_lieu != 0) { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Lieu&nbsp;d&#8217;ex&eacute;cution</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php 
										do {
											if ($i != 0) {
												echo ("<br>\n");
											}
											echo $row_lieu['SITE'];
											$i++;
										} while ($row_lieu = mysql_fetch_assoc($lieu)); ?></td>
								</tr>
								<?php } ?>
								<?php if ($row_objets['DEB_DATE_EXECUTION'] != "" && $row_objets['DEB_DATE_EXECUTION'] != '0000-00-00') { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Date&nbsp;d&#8217;ex&eacute;cution</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php echo traitementDate($row_objets['TXT_DATE_EXECUTION'],reverseDate($row_objets['DEB_DATE_EXECUTION']),reverseDate($row_objets['FIN_DATE_EXECUTION'])); ?></td>
								</tr>
								<?php } ?> <?php if ($row_objets['SIECLE_MILLENAIRE'] != "") { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Si&egrave;cle&nbsp;ou&nbsp;mill&eacute;naire</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php echo $row_objets['SIECLE_MILLENAIRE']; ?></td>
								</tr>
								<?php } ?> <?php if ($row_objets['PRECISION_DATATION'] != "") { ?>
								<tr>
									<td class="col_unQuart"> <span class="souligne">Pr&eacute;cision&nbsp;sur&nbsp;la&nbsp;datation</span> : </td>
									<td class="col_troisQuart"><?php echo nl2br($row_objets['PRECISION_DATATION']); ?></td>
								</tr>
								<?php } ?> <?php if ($row_objets['EPOQUE_STYLE'] != "") { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">&Eacute;poque,&nbsp;style</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php echo $row_objets['EPOQUE_STYLE']; ?></td>
								</tr>
								<?php } ?> <?php if ($row_objets['PRECISION_GENESE'] != "") { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Pr&eacute;cision&nbsp;sur&nbsp;la&nbsp;g&eacute;n&egrave;se</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php echo nl2br($row_objets['PRECISION_GENESE']); ?></td>
								</tr>
								<?php } ?> <?php if ($row_objets['SOURCE_ORALE_ECRITE'] != "") { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Source&nbsp;de&nbsp;la&nbsp;repr&eacute;sentation</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php echo nl2br($row_objets['SOURCE_ORALE_ECRITE']); ?></td>
								</tr>
								<?php } ?> <?php if ($row_objets['DEB_DATE_REPRESENTATION'] != "") { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Date&nbsp;de&nbsp;la&nbsp;repr&eacute;sentation</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php echo traitementDate($row_objets['TXT_DATE_REPRESENTATION'],reverseDate($row_objets['DEB_DATE_REPRESENTATION']),reverseDate($row_objets['FIN_DATE_REPRESENTATION']));?></td>
								</tr>
								<?php } ?> <?php if ($row_objets['DEB_DATE_ORIGINAL_COPIE'] != "" && $row_objets['DEB_DATE_ORIGINAL_COPIE'] != "0000-00-00") { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Datation&nbsp;original&nbsp;copi&eacute;</span> :</td>
									<td class="col_troisQuart"><?php echo traitementDate($row_objets['TXT_DATE_ORIGINAL_COPIE'],reverseDate($row_objets['DEB_DATE_ORIGINAL_COPIE']),reverseDate($row_objets['FIN_DATE_ORIGINAL_COPIE'])); ?></td>
								</tr>
								<?php } ?> <?php if ($row_objets['DATATION_CONTEXTE'] != "") { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Datation du Contexte</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php echo $row_objets['DATATION_CONTEXTE']; ?></td>
								</tr>
								<?php } ?>
								<tr>
									<td class="col_unQuart">&nbsp;</td>
									<td class="col_troisQuart">&nbsp;</td>
								</tr>
								<tr>
									<td colspan="2"><span class="souligne"><strong>DONN&Eacute;ES&nbsp;SUR&nbsp;L&#8217;UTILISATION</strong></span></td>
								</tr>
								<?php
								mysql_select_db($database_alienorweblibre, $alienorweblibre);
								$query_lieu = "SELECT lieu.INDEX_LIEU, SITE FROM lieu,obj_lie WHERE obj_lie.INDEX_OBJET =".$noFiche." AND lieu.INDEX_LIEU = obj_lie.INDEX_LIEU AND obj_lie.QUALIFIANT = 'LIEUX_UTILISATION' ORDER BY INDEX_OBJ_LIE ASC";
								$lieu = mysql_query($query_lieu, $alienorweblibre) or die(mysql_error());
								$row_lieu = mysql_fetch_assoc($lieu);
								$totalRows_lieu = mysql_num_rows($lieu);
								$i = 0 ;
								if ($totalRows_lieu != 0) { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Lieu&nbsp;d&#8217;utilisation</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php
										do {
											if ($i != 0) {
												echo ("<br>\n");
											}
											echo $row_lieu['SITE'];
											$i++;
										} while ($row_lieu = mysql_fetch_assoc($lieu)); ?></td>
								</tr>
								<?php } ?>
								<?php if ($row_objets['DEB_DATE_UTILISATION'] != "" && $row_objets['DEB_DATE_UTILISATION'] != "0000-00-00") { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Date</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php echo traitementDate($row_objets['TXT_DATE_UTILISATION'],reverseDate($row_objets['DEB_DATE_UTILISATION']),reverseDate($row_objets['FIN_DATE_UTILISATION'])); ?></td>
								</tr>
								<?php } ?> <?php if ($row_objets['UTILISATION'] != "") { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Utilisation</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php echo str_replace("/",", ",$row_objets['UTILISATION']); ?></td>
								</tr>
								<?php } ?>
								<?php
								mysql_select_db($database_alienorweblibre, $alienorweblibre);
								$query_auteur = "SELECT personne.INDEX_PERSONNE, ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET =".$noFiche." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'UTILISATEUR' ORDER BY INDEX_OBJ_PER ASC";
								$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
								$row_auteur = mysql_fetch_assoc($auteur);
								$totalRows_auteur = mysql_num_rows($auteur);
								$i = 0;
								if ($totalRows_auteur != 0) { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Utilisateur</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php
										do {
											if ($i != 0) {
												echo ("<br>\n");
											}
											echo $row_auteur['ETAT_CIVIL'];
											$i++;
										} while ($row_auteur = mysql_fetch_assoc($auteur)); ?></td>
								</tr>
								<?php } ?>
								<?php if ($row_objets['PRECISION_UTILISATION'] != "") { ?>
								<tr>
									<td class="col_unQuart">
										<!--<span class="souligne">Pr&eacute;cision sur l&#8217;utilisation</span>&nbsp;:-->
									</td>
									<td class="col_troisQuart"><?php echo nl2br($row_objets['PRECISION_UTILISATION']); ?></td>
								</tr>
								<?php } ?> <?php if ($row_objets['UTILISATION_SECONDE'] != "") { ?>
								<tr>
									<td class="col_unQuart">
										<!--<span class="souligne">Utilisation seconde</span>&nbsp;:-->
									</td>
									<td class="col_troisQuart"><?php echo nl2br($row_objets['UTILISATION_SECONDE']); ?></td>
								</tr>
								<?php } ?>
								<tr>
									<td class="col_unQuart">&nbsp;</td>
									<td class="col_troisQuart">&nbsp;</td>
								</tr>
								<tr>
									<td colspan="2"><span class="souligne"><strong>ADMINISTRATION</strong></span></td>
								</tr>
								<tr>
									<td class="col_unQuart"><span class="souligne">Propri&eacute;taire</span> :</td>
									<td class="col_troisQuart"><?php
										mysql_select_db($database_alienorweblibre, $alienorweblibre);
										$query_auteur = "SELECT personne.INDEX_PERSONNE, ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET =".$noFiche." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'PROPRIETAIRE' ORDER BY INDEX_OBJ_PER ASC";
										$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
										$row_auteur = mysql_fetch_assoc($auteur);
										$totalRows_auteur = mysql_num_rows($auteur);
										$i = 0;
										do {
											if ($i != 0) {
												echo ("<br>\n");
											}
											echo $row_auteur['ETAT_CIVIL'];
											$i++;
										} while ($row_auteur = mysql_fetch_assoc($auteur)); ?></td>
								<tr>
									<td class="col_unQuart"><span class="souligne">Acquisition</span> :</td>
									<td class="col_troisQuart"><?php echo $row_objets['MODE_ACQUISITION']; ?> <?php echo traitementDate($row_objets['PROPRIETAIRE_TXT_DATE_PATRIMONIALE'],reverseDate($row_objets['PROPRIETAIRE_DEB_DATE_PATRIMONIALE']),reverseDate($row_objets['PROPRIETAIRE_FIN_DATE_PATRIMONIALE'])); ?></td>
								</tr>
								 <?php if ($row_objets['DEPOSITAIRE_DEB_DATE_PATRIMONIALE'] != "" && $row_objets['DEPOSITAIRE_DEB_DATE_PATRIMONIALE'] != "0000-00-00") { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">D&eacute;p&ocirc;t</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php echo traitementDate($row_objets['DEPOSITAIRE_TXT_DATE_PATRIMONIALE'],reverseDate($row_objets['DEPOSITAIRE_DEB_DATE_PATRIMONIALE']),reverseDate($row_objets['DEPOSITAIRE_FIN_DATE_PATRIMONIALE'])); ?></td>
								</tr>
								<?php } ?>
								<?php
								mysql_select_db($database_alienorweblibre, $alienorweblibre);
								$query_auteur = "SELECT personne.INDEX_PERSONNE, ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET =".$noFiche." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'ANCIEN_DEPOSITAIRE' ORDER BY INDEX_OBJ_PER ASC";
								$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
								$row_auteur = mysql_fetch_assoc($auteur);
								$totalRows_auteur = mysql_num_rows($auteur);
								$i = 0;
								if ($totalRows_auteur != 0) { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Anciens&nbsp;d&eacute;p&ocirc;ts</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php
										do {
											if ($i != 0) {
												echo ("<br>\n");
											}
											echo $row_auteur['ETAT_CIVIL'];
											$i++;
										} while ($row_auteur = mysql_fetch_assoc($auteur)); ?><br>
										date de d&eacute;p&ocirc;t : <?php echo traitementDate($row_objets['ANCIEN_DEPOSITAIRE_TXT_DATE_PATRIMONIALE'],reverseDate($row_objets['ANCIEN_DEPOSITAIRE_DEB_DATE_PATRIMONIALE']),reverseDate($row_objets['ANCIEN_DEPOSITAIRE_FIN_DATE_PATRIMONIALE'])); ?></td>
								</tr>
								<?php } ?>
								<?php
								mysql_select_db($database_alienorweblibre, $alienorweblibre);
								$query_auteur = "SELECT personne.INDEX_PERSONNE, ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET =".$noFiche." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'ANCIENNE_APPARTENANCE' ORDER BY INDEX_OBJ_PER ASC";
								$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
								$row_auteur = mysql_fetch_assoc($auteur);
								$totalRows_auteur = mysql_num_rows($auteur);
								$i = 0;
								if ($totalRows_auteur != 0) { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Anciennes&nbsp;appartenances</span> :</td>
									<td class="col_troisQuart"><?php
										do {
											if ($i != 0) {
												echo ("<br>\n");
											}
											echo $row_auteur['ETAT_CIVIL'];
											$i++;
										} while ($row_auteur = mysql_fetch_assoc($auteur)); ?><br>
										Date d&#8217;entr&eacute;e dans collection :<?php echo traitementDate($row_objets['ANCIENNE_APPARTENANCE_TXT_DATE_PATRIMONIALE'],reverseDate($row_objets['ANCIENNE_APPARTENANCE_DEB_DATE_PATRIMONIALE']), reverseDate($row_objets['ANCIENNE_APPARTENANCE_FIN_DATE_PATRIMONIALE'])); ?><br>
										Num&eacute;ro de catalogue : <?php echo $row_objets['NUMERO_CATALOGUE']; ?></td>
								</tr>
								<?php } ?>
								<?php
								mysql_select_db($database_alienorweblibre, $alienorweblibre);
								$query_auteur = "SELECT personne.INDEX_PERSONNE, ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET =".$noFiche." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'COMMISSAIRE_PRISEUR' ORDER BY INDEX_OBJ_PER ASC";
								$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
								$row_auteur = mysql_fetch_assoc($auteur);
								$totalRows_auteur = mysql_num_rows($auteur);
								$i = 0;
								if ($totalRows_auteur != 0) { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Commissaire priseur</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php
										do {
											if ($i != 0) {
												echo ("<br>\n");
											}
											echo $row_auteur['ETAT_CIVIL'];
											$i++;
										} while ($row_auteur = mysql_fetch_assoc($auteur)); ?><br>
										<?php if ($row_objets['COMMISSAIRE_PRISEUR_DEB_DATE_PATRIMONIALE'] != "0000-00-00" && $row_objets['COMMISSAIRE_PRISEUR_DEB_DATE_PATRIMONIALE'] != "") { ?>
										Date de la vente : <?php echo traitementDate($row_objets['COMMISSAIRE_PRISEUR_TXT_DATE_PATRIMONIALE'],reverseDate($row_objets['COMMISSAIRE_PRISEUR_DEB_DATE_PATRIMONIALE']),reverseDate($row_objets['COMMISSAIRE_PRISEUR_FIN_DATE_PATRIMONIALE'])); ?><br><?php } ?>
										<?php if ($row_objets['COMMISSAIRE_PRISEUR_NUMERO_CATALOGUE'] != 0) { ?>
										Num&eacute;ro dans le catalogue de la vente : <?php echo $row_objets['COMMISSAIRE_PRISEUR_NUMERO_CATALOGUE']; ?><?php } ?></td>
								</tr>
								<?php } ?>
								<?php
								mysql_select_db($database_alienorweblibre, $alienorweblibre);
								$query_auteur = "SELECT personne.INDEX_PERSONNE, ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET =".$noFiche." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'GALERIE' ORDER BY INDEX_OBJ_PER ASC";
								$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
								$row_auteur = mysql_fetch_assoc($auteur);
								$totalRows_auteur = mysql_num_rows($auteur);
								$i = 0;
								if ($totalRows_auteur != 0) { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Galerie</span> :</td>
									<td class="col_troisQuart"><?php
										do {
											if ($i != 0) {
												echo ("<br>\n");
											}
											echo $row_auteur['ETAT_CIVIL'];
											$i++;
										} while ($row_auteur = mysql_fetch_assoc($auteur)); ?><br>
										<?php if ($row_objets['GALERIE_DEB_DATE_PATRIMONIALE'] != "0000-00-00" && $row_objets['GALERIE_DEB_DATE_PATRIMONIALE'] != "") { ?>
										Date : <?php echo traitementDate($row_objets['GALERIE_TXT_DATE_PATRIMONIALE'],reverseDate($row_objets['GALERIE_DEB_DATE_PATRIMONIALE']),reverseDate($row_objets['GALERIE_FIN_DATE_PATRIMONIALE'])); ?><br><?php } ?>
										<?php if ($row_objets['GALERIE_NUMERO_CATALOGUE'] != "") { ?>
										Num&eacute;ro dans le catalogue : <?php echo $row_objets['GALERIE_NUMERO_CATALOGUE']; ?><?php } ?></td>
								</tr>
								<?php } ?>
								<?php
								mysql_select_db($database_alienorweblibre, $alienorweblibre);
								$query_auteur = "SELECT personne.INDEX_PERSONNE, ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET =".$noFiche." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'ANCIENNE_APPARTENANCE' ORDER BY INDEX_OBJ_PER ASC";
								$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
								$row_auteur = mysql_fetch_assoc($auteur);
								$totalRows_auteur = mysql_num_rows($auteur);
								$i = 0;
								if ($totalRows_auteur != 0) { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Anciennes&nbsp;appartenances</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php
										do {
											if ($i != 0) {
												echo ("<br>\n");
											}
											echo $row_auteur['ETAT_CIVIL'];
											$i++;
										} while ($row_auteur = mysql_fetch_assoc($auteur)); ?><br>
										<?php if ($row_objets['ANCIENNE_APPARTENANCE_DEB_DATE_PATRIMONIALE'] != "0000-00-00" && $row_objets['ANCIENNE_APPARTENANCE_DEB_DATE_PATRIMONIALE'] != "") { ?>
										Date d&#8217;entr&eacute;e dans collection : <?php echo traitementDate($row_objets['ANCIENNE_APPARTENANCE_TXT_DATE_PATRIMONIALE'],reverseDate($row_objets['ANCIENNE_APPARTENANCE_DEB_DATE_PATRIMONIALE']),reverseDate($row_objets['ANCIENNE_APPARTENANCE_FIN_DATE_PATRIMONIALE'])); ?><br><?php } ?>
										<?php if ($row_objets['NUMERO_CATALOGUE'] != 0) { ?>
										Num&eacute;ro de catalogue : <?php echo $row_objets['NUMERO_CATALOGUE']; ?><?php } ?></td>
								</tr>
								<?php } ?>
								<?php
								mysql_select_db($database_alienorweblibre, $alienorweblibre);
								$query_auteur = "SELECT personne.INDEX_PERSONNE, ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET =".$noFiche." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'SERVICE_GESTIONNAIRE' ORDER BY INDEX_OBJ_PER ASC";
								$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
								$row_auteur = mysql_fetch_assoc($auteur);
								$totalRows_auteur = mysql_num_rows($auteur);
								$i = 0;
								if ($totalRows_auteur != 0) { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Service&nbsp;gestionnaire</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php
										do {
											if ($i != 0) {
												echo ("<br>\n");
											}
											echo $row_auteur['ETAT_CIVIL'];
											$i++;
										} while ($row_auteur = mysql_fetch_assoc($auteur)); ?></td>
								</tr>
								<?php } ?> <?php if ($row_objets['PRECISION_ADMINISTRATIVE'] != "") { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Pr&eacute;cision</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php echo nl2br($row_objets['PRECISION_ADMINISTRATIVE']); ?></td>
								</tr>
								<?php } ?>
								<tr>
									<td class="col_unQuart">&nbsp;</td>
									<td class="col_troisQuart">&nbsp;</td>
								</tr>
								<tr>
									<td colspan="2"><span class="souligne"><strong>DOCUMENTATION</strong></span></td>
								</tr>
								<?php if ($row_objets['NUMERO_DOSSIER'] != "") { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Num&eacute;ro&nbsp;de&nbsp;dossier</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php echo $row_objets['NUMERO_DOSSIER']; ?></td>
								</tr>
								<?php } ?>
								<?php
								mysql_select_db($database_alienorweblibre, $alienorweblibre);
								$query_docum = "SELECT IDENTIFIANT, documentation.INDEX_DOCUMENTATION FROM documentation,obj_doc WHERE obj_doc.INDEX_OBJET =".$noFiche." AND documentation.INDEX_DOCUMENTATION = obj_doc.INDEX_DOCUMENTATION AND obj_doc.QUALIFIANT = 'BIBLIOGRAPHIE' ORDER BY INDEX_OBJ_DOC ASC";
								$docum = mysql_query($query_docum, $alienorweblibre) or die(mysql_error());
								$row_docum = mysql_fetch_assoc($docum);
								$totalRows_docum = mysql_num_rows($docum);
								$i = 0 ;
								if ($totalRows_docum != 0) {
								$biblio = $row_objets['BIBLIOGRAPHIE_PARAM']; ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Bibliographie</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php
										do {
											if ($i != 0) {
												echo "<br>\n";
											}
											?>R&eacute;f&eacute;rence : <?php
											echo $row_docum['IDENTIFIANT']." N&deg; de page : ".$biblio;
											$i++;
											} while ($row_docum = mysql_fetch_assoc($docum)); ?></td>
								</tr>
								<?php } ?>
								<?php
								mysql_select_db($database_alienorweblibre, $alienorweblibre);
								$query_docum = "SELECT IDENTIFIANT, documentation.INDEX_DOCUMENTATION, FICHIER FROM documentation,obj_doc WHERE obj_doc.INDEX_OBJET =".$noFiche." AND documentation.INDEX_DOCUMENTATION = obj_doc.INDEX_DOCUMENTATION AND obj_doc.QUALIFIANT = 'PHOTOGRAPHIE' ORDER BY INDEX_OBJ_DOC ASC";
								$docum = mysql_query($query_docum, $alienorweblibre) or die(mysql_error());
								$row_docum = mysql_fetch_assoc($docum);
								$totalRows_docum = mysql_num_rows($docum);
								$i = 0 ;
								$photographie = "";
								$photo = "";
								if ($totalRows_docum != 0) {
								$photographie = $row_objets['PHOTOGRAPHIE_PARAM']; ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Photographies</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php
										do {
											if ($i != 0) {
												echo "<br>\n";
											} ?>N&deg; INV. Nat. : <?php
											echo $row_docum['IDENTIFIANT'];
											if ($photographie[$i] == 1) {
												echo " image de repérage";
											}
											
											// fabrication des tableaux d'images
												if ($row_docum['FICHIER'] != ""){
													if ($i == 0){
														$photo = $row_docum['FICHIER'];
														$identifiant = $row_docum['IDENTIFIANT'];
													}else{
														$photo = $photo."/".$row_docum['FICHIER'];
														$identifiant = $identifiant."/".$row_docum['IDENTIFIANT'];
													}
												}; //$row_docum['FICHIER'] != ""
											$i++;
											} while ($row_docum = mysql_fetch_assoc($docum)); ?></td>
								</tr>
								<?php } ?>
								<?php
								mysql_select_db($database_alienorweblibre, $alienorweblibre);
								$query_docum = "SELECT IDENTIFIANT, documentation.INDEX_DOCUMENTATION FROM documentation,obj_doc WHERE obj_doc.INDEX_OBJET =".$noFiche." AND documentation.INDEX_DOCUMENTATION = obj_doc.INDEX_DOCUMENTATION AND obj_doc.QUALIFIANT = 'EXPOSITION' ORDER BY INDEX_OBJ_DOC ASC";
								$docum = mysql_query($query_docum, $alienorweblibre) or die(mysql_error());
								$row_docum = mysql_fetch_assoc($docum);
								$totalRows_docum = mysql_num_rows($docum);
								$i = 0 ;
								if ($totalRows_docum != 0) {
								$expo = $row_objets['EXPOSITION_PARAM']; ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Expositions</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php
									do {
										if ($i != 0) {
											echo "<br>\n";
										}?>R&eacute;f&eacute;rence : <?php
										echo $row_docum['IDENTIFIANT']." N&deg; dans le catalogue : ".$expo[$i];
										$i++;
										} while ($row_docum = mysql_fetch_assoc($docum)); ?></td>
								</tr>
								<?php } ?>
								<?php
								mysql_select_db($database_alienorweblibre, $alienorweblibre);
								$query_docum = "SELECT IDENTIFIANT, documentation.INDEX_DOCUMENTATION FROM documentation,obj_doc WHERE obj_doc.INDEX_OBJET =".$noFiche." AND documentation.INDEX_DOCUMENTATION = obj_doc.INDEX_DOCUMENTATION AND obj_doc.QUALIFIANT = 'VIDEO' ORDER BY INDEX_OBJ_DOC ASC";
								$docum = mysql_query($query_docum, $alienorweblibre) or die(mysql_error());
								$row_docum = mysql_fetch_assoc($docum);
								$totalRows_docum = mysql_num_rows($docum);
								$i = 0 ;
								if ($totalRows_docum != 0) { 
								$video = $row_objets['VIDEO_PARAM']; ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">R&eacute;f&eacute;rences vid&eacute;o</span> :</td>
									<td class="col_troisQuart"><?php
										do {
											if ($i != 0) {
												echo "<br>\n";
											}?>R&eacute;f&eacute;rence : <?php
											echo $row_docum['IDENTIFIANT']." Repère : ".$video[$i] ;
											$i++;
											} while ($row_docum = mysql_fetch_assoc($docum)); ?></td>
								</tr>
								<?php } ?>
								<?php
								mysql_select_db($database_alienorweblibre, $alienorweblibre);
								$query_docum = "SELECT IDENTIFIANT, documentation.INDEX_DOCUMENTATION FROM documentation,obj_doc WHERE obj_doc.INDEX_OBJET =".$noFiche." AND documentation.INDEX_DOCUMENTATION = obj_doc.INDEX_DOCUMENTATION AND obj_doc.QUALIFIANT = 'CEDEROM' ORDER BY INDEX_OBJ_DOC ASC";
								$docum = mysql_query($query_docum, $alienorweblibre) or die(mysql_error());
								$row_docum = mysql_fetch_assoc($docum);
								$totalRows_docum = mysql_num_rows($docum);
								$i = 0 ;
								if ($totalRows_docum != 0) { 
								$cede = $row_objets['CEDEROM_PARAM']; ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">R&eacute;f&eacute;rences&nbsp;c&eacute;d&eacute;rom</span> :</td>
									<td class="col_troisQuart"><?php
										do {
											if ($i != 0) {
												echo "<br>\n";
											}?>N&deg; INV. Nat. :<?php
											echo $row_docum['IDENTIFIANT']." Nom du fichier : ".$cede[$i];
											$i++;
											} while ($row_docum = mysql_fetch_assoc($docum)); ?></td>
								</tr>
								<?php } ?>
								<tr>
									<td class="col_unQuart">&nbsp;</td>
									<td class="col_troisQuart">&nbsp;</td>
								</tr>
								<tr>
									<td colspan="2"><span class="souligne"><strong>GESTION</strong></span></td>
								</tr>
								<?php
								mysql_select_db($database_alienorweblibre, $alienorweblibre);
								$query_docum = "SELECT VALEUR, gestion.INDEX_GESTION FROM gestion,obj_ges WHERE obj_ges.INDEX_OBJET =".$noFiche." AND gestion.INDEX_GESTION = obj_ges.INDEX_GESTION";
								$docum = mysql_query($query_docum, $alienorweblibre) or die(mysql_error());
								$row_docum = mysql_fetch_assoc($docum);
								$totalRows_docum = mysql_num_rows($docum);
								$i = 0;
								if ($totalRows_docum != 0) { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Prix d'achat</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php
										do {
											if ($i != 0) {
												echo "<br>";
											}
											echo $row_docum['VALEUR'];
											$i++;
											} while ($row_docum = mysql_fetch_assoc($docum)); ?></td>
								</tr>
								<?php } ?>
								<?php
								mysql_select_db($database_alienorweblibre, $alienorweblibre);
								$query_docum = "SELECT ETAT_CONSERVATION, gestion.INDEX_GESTION FROM gestion,obj_ges WHERE obj_ges.INDEX_OBJET =".$noFiche." AND gestion.INDEX_GESTION = obj_ges.INDEX_GESTION";
								$docum = mysql_query($query_docum, $alienorweblibre) or die(mysql_error());
								$row_docum = mysql_fetch_assoc($docum);
								$totalRows_docum = mysql_num_rows($docum);
								$i = 0;
								if ($totalRows_docum != 0) { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Etat</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php
										do {
											if ($i != 0) {
												echo "<br>";
											}
											echo $row_docum['ETAT_CONSERVATION'];
											$i++;
											} while ($row_docum = mysql_fetch_assoc($docum)); ?></td>
								</tr>
								<?php } ?>
								<?php
								mysql_select_db($database_alienorweblibre, $alienorweblibre);
								$query_docum = "SELECT EMPLACEMENT, gestion.INDEX_GESTION FROM gestion,obj_ges WHERE obj_ges.INDEX_OBJET =".$noFiche." AND gestion.INDEX_GESTION = obj_ges.INDEX_GESTION";
								$docum = mysql_query($query_docum, $alienorweblibre) or die(mysql_error());
								$row_docum = mysql_fetch_assoc($docum);
								$totalRows_docum = mysql_num_rows($docum);
								$i = 0;
								if ($totalRows_docum != 0) { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Emplacement</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php
										do {
											if ($i != 0) {
												echo "<br>";
											}
											echo $row_docum['EMPLACEMENT'];
											$i++;
											} while ($row_docum = mysql_fetch_assoc($docum)); ?></td>
								</tr>
								<?php } ?>
								<?php if ($row_objets['ACCESSOIRE_PRESENTATION'] != "") { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Accessoires&nbsp;de&nbsp;pr&eacute;sentation</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php echo nl2br($row_objets['ACCESSOIRE_PRESENTATION']); ?></td>
								</tr>
								<?php } ?>
								<?php
								mysql_select_db($database_alienorweblibre, $alienorweblibre);
								$query_docum = "SELECT IDENTIFIANT, documentation.INDEX_DOCUMENTATION FROM documentation,obj_doc WHERE obj_doc.INDEX_OBJET =".$noFiche." AND documentation.INDEX_DOCUMENTATION = obj_doc.INDEX_DOCUMENTATION AND obj_doc.QUALIFIANT = 'MANUSCRIT' ORDER BY INDEX_OBJ_DOC ASC";
								$docum = mysql_query($query_docum, $alienorweblibre) or die(mysql_error());
								$row_docum = mysql_fetch_assoc($docum);
								$totalRows_docum = mysql_num_rows($docum);
								$i = 0;
								if ($totalRows_docum != 0) { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Documentation&nbsp;manuscrite</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php
										do {
											if ($i != 0) {
												echo "<br>\n";
											}?>R&eacute;f&eacute;rence : <?php
											echo $row_docum['IDENTIFIANT'];
											$i++;
											} while ($row_docum = mysql_fetch_assoc($docum)); ?><br>
											Commentaires : <?php echo $row_objets['MANUSCRIT_PARAM']; ?></td>
								</tr>
								<?php } ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Code&nbsp;mus&eacute;e</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php echo $row_objets['CODEMUSEE']; ?></td>
								</tr>
								<tr>
									<td class="col_unQuart"><span class="souligne">Copyright</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php echo $row_objets['COPYRIGHT']; ?></td>
								</tr>
								<tr>
									<td class="col_unQuart">&nbsp;</td>
									<td class="col_troisQuart">&nbsp;</td>
								</tr>
								<tr>
									<td colspan="2"><p class="centrer">Fiche cr&eacute;&eacute;e par : <?php echo $row_objets['FICHE_CREEE_PAR']; ?> le : <?php echo reverseDate($row_objets['FICHE_CREEE_LE']); ?> et modifi&eacute;e le : <?php echo reverseDate($row_objets['MISE_A_JOUR']); ?></p></td>
								</tr>
							</table>
						</td>
						<td class="pourVignPhoto"><?php
							//echo $photo;
							$tabPhoto = split('/',$photo);
							$tabIdentifiant = split('/',$identifiant);
							$cpt = 0;
							foreach ($tabPhoto as $fichier){
									if ($fichier != ""){
								?> <br>
							<a href="<?php echo '../include/images.php?SRC='.$fichier.'&amp;LARG=980&amp;HAUT=700'; ?>" target="_blank"><img src="<?php echo "../include/images.php?SRC=".$fichier."&amp;LARG=150&amp;HAUT=150"; ?>" border="0"></a><br />
							<?php
									echo $tabIdentifiant[$cpt]."<br><br>\n";
									$cpt++;
								};
							} ?></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<p class="copyright centrer pageEnd">Fiche obtenue par AlienorWeb Libre <br>
	Pour plus d&#8217;informations sur AlienorWeb Libre : <a href="http://www.inter-regions-musees.org" target="_blank">www.inter-regions-musees.org</a>.</p>
	<?php If (($valeur % 1) == 0) {
		$page = $page + 1;
		};
	?>
 <?php } // fin du foreach ?>
</body>
</html>
