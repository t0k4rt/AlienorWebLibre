<?php
	$dateAncAppt="";
	$dateGal="";
	$identifiant="";
	
	require_once('../config/config.php');
	$niveau_visa = $mcr;
	$page = "finventaire";
	include('../include/securite.php');
	include('../include/fonctions.php');
function maxDate($tableauDate) {
	global $iMax;
	$iMax = 0;
	$dateCherche = split("/",$tableauDate);
	if (!ereg("-",$dateCherche[0]))
	{
		$dateMax = date(preg_replace('/^(.{2}).(.{2}).(.{4})$/','$3-$2-$1', $dateCherche[0]));
	} else {
		$dateMax = $dateCherche[0];
	}
	// echo("\$dateCherche[0] ".$dateCherche[0]."<br>\n");
	for ($i=1; $i < count($dateCherche); $i++)
	{
		if (!ereg("-",$dateCherche[0]))
		{
			$dateCherche[$i] = date(preg_replace('/^(.{2}).(.{2}).(.{4})$/','$3-$2-$1', $dateCherche[$i]));
		} else {
			$dateCherche[$i] = $dateCherche[$i];
		}
		if ($dateCherche[$i] >= $dateMax)
		{
			// echo ("<b>Superieur</b><br>\n");
			$dateMax = $dateCherche[$i];
			$iMax = $iMax + 1;
		}
	}
	return $iMax;
}
require_once('../Connections/alienorweblibre.php');
(isset($_POST['chx_selection'])) ? $selection = $_POST['chx_selection'] : $selection = "" ;
$tabselection = split('/',$selection);
(isset($_POST['date'])) ? $date = $_POST['date'] : $date = date(d.".".m.".".Y) ;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
	<html lang="fr">
	<head>
	<title>Inventaire en date du <?php print $date; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<meta http-equiv="pragma" content="no-cache">
	<link href="../style/style_awl.css" rel="stylesheet" type="text/css" media="screen">
	<link href="../style/style_awl_print.css" rel="stylesheet" type="text/css" media="print">
	</head>
	<body>
<?php
$page = 1;
$valeur = 0 ;?>
	<table class="enteteTableau">
		<tr>
			<td colspan="2" class="titrepage" align="center">Inventaire</td>
		</tr>
		<tr>
			<td class="enteteCol_1">&nbsp;</td>
			<td class="enteteCol_2">&Eacute;dition du <?php echo(date("d.m.Y")); ?></td>
		</tr>
		<tr>
			<td class="enteteCol_1">&nbsp;</td>
			<td class="enteteCol_2">Page <?php echo $page; ?></td>
		</tr>
	</table>
	<br>
	<p class="dateInventaire">Inscription &agrave; l&#8217;inventaire le : <?php echo $date ?></p>
	<?php
	foreach($tabselection as $noFiche){
	$valeur = $valeur + 1;
	mysql_select_db($database_alienorweblibre, $alienorweblibre);
	$query_objets = "SELECT * FROM objet WHERE INDEX_OBJET = ".$noFiche."";
	$objets = mysql_query($query_objets, $alienorweblibre) or die(mysql_error());
	$row_objets = mysql_fetch_assoc($objets);
	?>
	<table class="bdrEtat">
		<tr>
			<td>
				<table class="tableauConteneurGlob">
					<tr>
						<td class="contenuTexte">
							<table class="pleineLargueur">
								<tr>
									<td class="col_unQuart"><span class="souligne">N&deg;&nbsp;d&#8217;inventaire</span>&nbsp;:</td>
									<td class="col_troisQuart"><b><?php echo $row_objets['NUMERO_INVENTAIRE']; ?></b></td>
								</tr>
								<tr>
									<td class="col_unQuart"><span class="souligne">Mode&nbsp;d'acquisition</span>&nbsp;:</td>
									<td class="col_troisQuart"><b><?php echo $row_objets['MODE_ACQUISITION']; ?></b>
										<?php
										if ($row_objets['PROPRIETAIRE_DEB_DATE_PATRIMONIALE'] != "" && $row_objets['PROPRIETAIRE_DEB_DATE_PATRIMONIALE'] != "0000-00-00") {
											echo traitementDate($row_objets['PROPRIETAIRE_TXT_DATE_PATRIMONIALE'],reverseDate($row_objets['PROPRIETAIRE_DEB_DATE_PATRIMONIALE']),reverseDate($row_objets['PROPRIETAIRE_FIN_DATE_PATRIMONIALE']));
										} ?>										</td>
								</tr>
								<tr>
									<td class="col_unQuart"><span class="souligne">Donateur,&nbsp;testateur,&nbsp;vendeur</span>&nbsp;:</td>
									<td class="col_troisQuart">
									<?php
									mysql_select_db($database_alienorweblibre, $alienorweblibre);
									$query_auteur = "SELECT ANCIENNE_APPARTENANCE_TXT_DATE_PATRIMONIALE, ANCIENNE_APPARTENANCE_DEB_DATE_PATRIMONIALE, ANCIENNE_APPARTENANCE_FIN_DATE_PATRIMONIALE, COMMISSAIRE_PRISEUR_TXT_DATE_PATRIMONIALE, COMMISSAIRE_PRISEUR_DEB_DATE_PATRIMONIALE, COMMISSAIRE_PRISEUR_FIN_DATE_PATRIMONIALE, GALERIE_TXT_DATE_PATRIMONIALE, GALERIE_DEB_DATE_PATRIMONIALE, GALERIE_FIN_DATE_PATRIMONIALE FROM objet WHERE INDEX_OBJET =".$noFiche."";
									$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
									$row_auteur = mysql_fetch_assoc($auteur);
									$totalRows_auteur = mysql_num_rows($auteur);
									if ($totalRows_auteur != 0) {
										do {
											$dateAncApptTxt = $row_auteur['ANCIENNE_APPARTENANCE_TXT_DATE_PATRIMONIALE'];
											$dateAncAppt = $row_auteur['ANCIENNE_APPARTENANCE_DEB_DATE_PATRIMONIALE'];
											$dateAncApptFin = $row_auteur['ANCIENNE_APPARTENANCE_FIN_DATE_PATRIMONIALE'];
											$dateComPriTxt = $row_auteur['COMMISSAIRE_PRISEUR_TXT_DATE_PATRIMONIALE'];
											$dateComPri = $row_auteur['COMMISSAIRE_PRISEUR_DEB_DATE_PATRIMONIALE'];
											$dateComPriFin = $row_auteur['COMMISSAIRE_PRISEUR_FIN_DATE_PATRIMONIALE'];
											$dateGalTxt = $row_auteur['GALERIE_TXT_DATE_PATRIMONIALE'];
											$dateGal = $row_auteur['GALERIE_DEB_DATE_PATRIMONIALE'];
											$dateGalFin = $row_auteur['GALERIE_FIN_DATE_PATRIMONIALE'];
										} while ($row_auteur = mysql_fetch_assoc($auteur));
										$AncApptTxt = split("/",$dateAncApptTxt);
										$AncAppt = split("/",$dateAncAppt);
										$AncApptFin = split("/",$dateAncApptFin);
										$ComPriTxt = split("/",$dateComPriTxt);
										$ComPri = split("/",$dateComPri);
										$ComPriFin = split("/",$dateComPriFin);
										$GalTxt = split("/",$dateGalTxt);
										$Gal = split("/",$dateGal);
										$GalFin = split("/",$dateGalFin);
									}
									?>
									<?php
									mysql_select_db($database_alienorweblibre, $alienorweblibre);
									$query_auteur = "SELECT personne.INDEX_PERSONNE, ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET =".$noFiche." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'ANCIENNE_APPARTENANCE' ORDER BY INDEX_OBJ_PER ASC";
									$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
									$row_auteur = mysql_fetch_assoc($auteur);
									$totalRows_auteur = mysql_num_rows($auteur);
									$i = 0;
									maxDate($dateAncAppt);
									// echo ("imax = ".$iMax."<br>\n");
									if ($totalRows_auteur != 0) {
										do {
											if ($i == $iMax)
											{
												echo $row_auteur['ETAT_CIVIL'];
												echo " ".traitementDate($AncApptTxt[$i],reverseDate($AncAppt[$i]),reverseDate($AncApptFin[$i]));
											}
											$i++;
										} while ($row_auteur = mysql_fetch_assoc($auteur));
										echo("<br>\n");
									}
									
/*									mysql_select_db($database_alienorweblibre, $alienorweblibre);
									$query_auteur = "SELECT personne.INDEX_PERSONNE, ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET =".$noFiche." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'ANCIENNE_APPARTENANCE' ORDER BY INDEX_OBJ_PER ASC";
									$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
									$row_auteur = mysql_fetch_assoc($auteur);
									$totalRows_auteur = mysql_num_rows($auteur);
									$i = 0;
									if ($totalRows_auteur != 0) {
										do {
											if ($i != 0) {
												echo ("<br>\n");
											}
											echo $row_auteur['ETAT_CIVIL'];
											mysql_select_db($database_alienorweblibre, $alienorweblibre);
	$query_lieu = "SELECT lieu.INDEX_LIEU, SITE FROM lieu,per_lie WHERE per_lie.INDEX_PERSONNE =".$row_auteur['INDEX_PERSONNE']." AND lieu.INDEX_LIEU = per_lie.INDEX_LIEU AND per_lie.QUALIFIANT = 'LIEU_RESIDENCE' ORDER BY INDEX_PER_LIE ASC";
											$lieu = mysql_query($query_lieu, $alienorweblibre) or die(mysql_error());
											$row_lieu = mysql_fetch_assoc($lieu);
											$totalRows_lieu = mysql_num_rows($lieu);
											$i = 0 ;
											echo " ";
												do {
													echo $row_lieu['SITE'];
													$i++;
												} while ($row_lieu = mysql_fetch_assoc($lieu));
											$i++;
										} while ($row_auteur = mysql_fetch_assoc($auteur));
										echo ("<br>\n");
									}*/
									
									mysql_select_db($database_alienorweblibre, $alienorweblibre);
									$query_auteur = "SELECT personne.INDEX_PERSONNE, ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET =".$noFiche." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'COMMISSAIRE_PRISEUR' ORDER BY INDEX_OBJ_PER ASC";
									$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
									$row_auteur = mysql_fetch_assoc($auteur);
									$totalRows_auteur = mysql_num_rows($auteur);
									$i = 0;
									maxDate($dateAncAppt);
									// echo ("imax = ".$iMax."<br>\n");
									if ($totalRows_auteur != 0) {
										do {
											if ($i == $iMax)
											{
												echo $row_auteur['ETAT_CIVIL'];
												echo " ".traitementDate($ComPriTxt[$i],reverseDate($ComPri[$i]),reverseDate($ComPriFin[$i]));
											}
											$i++;
										} while ($row_auteur = mysql_fetch_assoc($auteur));
										echo("<br>\n");
									}
									
									mysql_select_db($database_alienorweblibre, $alienorweblibre);
									$query_auteur = "SELECT personne.INDEX_PERSONNE, ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET =".$noFiche." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'GALERIE' ORDER BY INDEX_OBJ_PER ASC";
									$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
									$row_auteur = mysql_fetch_assoc($auteur);
									$totalRows_auteur = mysql_num_rows($auteur);
									$i = 0;
									maxDate($dateGal);
									// echo ("imax = ".$iMax."<br>\n");
									if ($totalRows_auteur != 0) {
										do {
											if ($i == $iMax)
											{
												echo $row_auteur['ETAT_CIVIL'];
												echo " ".traitementDate($GalTxt[$i],reverseDate($Gal[$i]),reverseDate($GalFin[$i]));
											}
											$i++;
										} while ($row_auteur = mysql_fetch_assoc($auteur));
										echo("<br>\n");
									} ?></td>
								<tr>
									<td class="col_unQuart"><span class="souligne">Avis&nbsp;des&nbsp;instances&nbsp;scientifiques</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php echo nl2br($row_objets['PRECISION_ADMINISTRATIVE']); ?></td>
								</tr>
								<tr>
									<td class="col_unQuart"><span class="souligne">Prix d'achat</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php
										mysql_select_db($database_alienorweblibre, $alienorweblibre);
										$query_valeur = "SELECT gestion.VALEUR, gestion.DATE_VALEUR, gestion.INDEX_GESTION FROM gestion,obj_ges WHERE obj_ges.INDEX_OBJET =".$noFiche." AND gestion.INDEX_GESTION = obj_ges.INDEX_GESTION ORDER BY gestion.DATE_VALEUR DESC";
										$valeur = mysql_query($query_valeur, $alienorweblibre) or die(mysql_error());
										$row_valeur = mysql_fetch_assoc($valeur);
										$totalRows_valeur = mysql_num_rows($valeur);
										if ($totalRows_valeur != 0) {
											while ($row_valeur['VALEUR'] != "") {
												echo($row_valeur['VALEUR']);
												?> (<?php 
												echo reverseDate($row_valeur['DATE_VALEUR']);?>) ; <?php
												$row_valeur = mysql_fetch_assoc($valeur);
											} ;
										}
										?>									</td>
								</tr>
								<tr>
									<td class="col_unQuart"><span class="souligne">D&eacute;signation du bien</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php echo nl2br($row_objets['TITRE']); ?>
									<?php 
									if ($row_objets['TITRE'] != "" && $row_objets['DENOMINATION'] != "")
									{
										echo " ; ";
									}
									echo nl2br($row_objets['DENOMINATION']);
									?></td>
								</tr>
								<?php // if($row_objets['TYPE_INSCRIPTION'] != "") { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Marques et inscriptions</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php echo nl2br($row_objets['TYPE_INSCRIPTION']); ?>
									<?php
									if ($row_objets['TRANSCRIPTION_INSCRIPTION'] !="")
									{
										echo nl2br($row_objets['TRANSCRIPTION_INSCRIPTION']);
									}
									?></td>
								</tr>
								<?php //} ?>
								<?php // if($row_objets['PRECISION_DESCRIPTION'] != "") { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Description</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php echo nl2br($row_objets['PRECISION_DESCRIPTION']); ?></td>
								</tr>
								<?php //} ?>
								<?php //if ($row_objets['MATIERE'] != "") { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Mati&egrave;re</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php echo $row_objets['MATIERE']; ?></td>
								</tr>
								<?php //} ?>
								<?php //if ($row_objets['TECHNIQUE'] != "") { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Technique&nbsp;de&nbsp;r&eacute;alisation</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php echo $row_objets['TECHNIQUE']; ?></td>
								</tr>
								<?php //} ?>
								<?php //if ($row_objets['DIMENSIONS_FORMES'] != "") { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Pr&eacute;cision gen&egrave;se</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php echo nl2br($row_objets['PRECISION_GENESE']); ?></td>
								</tr>
								<?php //} ?>
								<?php //if ($row_objets['DIMENSIONS_FORMES'] != "") { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Mesures</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php
									if ($row_objets['DIMENSIONS_FORMES'] != "")
									{
										echo nl2br($row_objets['DIMENSIONS_FORMES']);
										echo(" (La mesure par défaut est le cm sauf en archéologie où les mesures sont exprimées en mm)");
									}?></td>
								</tr>
								<?php //} ?>
								<?php
								$tabRole = $row_objets['ROLE'];
								$role = split("/",$tabRole);
								mysql_select_db($database_alienorweblibre, $alienorweblibre);
								$query_auteur = "SELECT personne.INDEX_PERSONNE, ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET =".$noFiche." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'AUTEUR' ORDER BY INDEX_OBJ_PER ASC";
								$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
								$row_auteur = mysql_fetch_assoc($auteur);
								$totalRows_auteur = mysql_num_rows($auteur);
								$i = 0;
								if ($totalRows_auteur != 0) { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Auteur(s)</span> :</td>
									<td class="col_troisQuart">
									<?php
										do {
											if ($i != 0) {
												echo ("<br>\n");
											}
											echo $row_auteur['ETAT_CIVIL'];
											echo " (".$role[$i].")";
											$i++;
										} while ($row_auteur = mysql_fetch_assoc($auteur));
									?>									</td>
								</tr>
								<?php } ?>
								<?php //if ($row_objets['EPOQUE_STYLE'] != "") { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">&Eacute;poque,&nbsp;date de r&eacute;colte </span>&nbsp;:</td>
									<td class="col_troisQuart"><?php echo $row_objets['EPOQUE_STYLE']; ?></td>
								</tr>
								<?php //} ?>
								<?php //if ($row_objets['UTILISATION'] != "") { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Fonction d&#8217;usage </span>&nbsp;:</td>
									<td class="col_troisQuart"><?php echo $row_objets['UTILISATION']; ?></td>
								</tr>
								<?php //} ?>
								<?php //if ($row_objets['SIECLE_MILLENAIRE'] != "") { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Datation</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php echo $row_objets['SIECLE_MILLENAIRE']; ?>
									<?php
									if ($row_objets['SIECLE_MILLENAIRE'] != "" && $row_objets['DEB_DATE_EXECUTION'] != "") {
										echo " ; ";
									}
									if ($row_objets['DEB_DATE_EXECUTION'] != "")
									{
										traitementDate($row_objets['TXT_DATE_EXECUTION'],reverseDate($row_objets['DEB_DATE_EXECUTION']),reverseDate($row_objets['FIN_DATE_EXECUTION']));
									}
									?></td>
								</tr>
								<?php //} ?>
								<?php
								mysql_select_db($database_alienorweblibre, $alienorweblibre);
								$query_lieu = "SELECT lieu.INDEX_LIEU, SITE FROM lieu,obj_lie WHERE obj_lie.INDEX_OBJET =".$noFiche." AND lieu.INDEX_LIEU = obj_lie.INDEX_LIEU AND obj_lie.QUALIFIANT = 'LIEUX_EXECUTION' ORDER BY INDEX_OBJ_LIE ASC";
								$lieu = mysql_query($query_lieu, $alienorweblibre) or die(mysql_error());
								$row_lieu = mysql_fetch_assoc($lieu);
								$totalRows_lieu = mysql_num_rows($lieu);
								$i = 0 ;
								if ($totalRows_lieu != 0) { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Ex&eacute;cution</span>&nbsp;:</td>
									<td class="col_troisQuart">
									<?php
										do {
											if ($i != 0) {
												echo ("<br>");
											}
											echo $row_lieu['SITE'];
											$i++;
										} while ($row_lieu = mysql_fetch_assoc($lieu));
									?>									</td>
								</tr>
								<?php } ?>
								<?php
								mysql_select_db($database_alienorweblibre, $alienorweblibre);
								$query_lieu = "SELECT lieu.INDEX_LIEU, SITE FROM lieu,obj_lie WHERE obj_lie.INDEX_OBJET =".$noFiche." AND lieu.INDEX_LIEU = obj_lie.INDEX_LIEU AND obj_lie.QUALIFIANT = 'LIEUX_DECOUVERTE' ORDER BY INDEX_OBJ_LIE ASC";
								$lieu = mysql_query($query_lieu, $alienorweblibre) or die(mysql_error());
								$row_lieu = mysql_fetch_assoc($lieu);
								$totalRows_lieu = mysql_num_rows($lieu);
								$i = 0 ;
								if ($totalRows_lieu != 0) { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Provenance G&eacute;ographique</span>&nbsp;:</td>
									<td class="col_troisQuart">
									<?php
										do {
											if ($i != 0) {
												echo ("<br>\n");
											}
											echo $row_lieu['SITE'];
											$i++;
										} while ($row_lieu = mysql_fetch_assoc($lieu));
									?>									</td>
								</tr>
								<?php } ?>
								<?php /*
								mysql_select_db($database_alienorweblibre, $alienorweblibre);
								$query_docum = "SELECT EMPLACEMENT, gestion.INDEX_GESTION FROM gestion,obj_ges WHERE obj_ges.INDEX_OBJET =".$noFiche." AND gestion.INDEX_GESTION = obj_ges.INDEX_GESTION";
								$docum = mysql_query($query_docum, $alienorweblibre) or die(mysql_error());
								$row_docum = mysql_fetch_assoc($docum);
								$totalRows_docum = mysql_num_rows($docum);
								$i = 0;
								if ($totalRows_docum != 0) { */ ?>
								<!--<tr>-->
									<!--<td class="col_unQuart"><span class="souligne">Emplacement</span>&nbsp;:</td>-->
									<!--<td class="col_troisQuart">--><?php /*
										do {
											if ($i != 0) {
												echo "<br>\n";
											}
											echo $row_docum['EMPLACEMENT'];
											$i++;
											} while ($row_docum = mysql_fetch_assoc($docum)); */?><!--</td>-->
								<!--</tr>-->
								<?php //} ?>
								<?php //if ($row_objets['NUMERO_DOSSIER'] != "") { ?>
								<tr>
									<td class="col_unQuart"><span class="souligne">Num&eacute;ro&nbsp;de&nbsp;dossier</span>&nbsp;:</td>
									<td class="col_troisQuart"><?php echo $row_objets['NUMERO_DOSSIER']; ?></td>
								</tr>
								<?php //} ?>
								<tr>
									<td colspan="2"><p class="copyright centrer">&copy; <?php echo $row_objets['COPYRIGHT']; ?></p></td>
								</tr>
							</table>
						</td>
						<td class="pourVignPhoto">
							<?php
							$photo ="";
							mysql_select_db($database_alienorweblibre, $alienorweblibre);
							$query_docum = "SELECT IDENTIFIANT, documentation.INDEX_DOCUMENTATION, FICHIER FROM documentation,obj_doc WHERE obj_doc.INDEX_OBJET =".$noFiche." AND documentation.INDEX_DOCUMENTATION = obj_doc.INDEX_DOCUMENTATION AND obj_doc.QUALIFIANT = 'PHOTOGRAPHIE'";
							$docum = mysql_query($query_docum, $alienorweblibre) or die(mysql_error());
							$row_docum = mysql_fetch_assoc($docum);
							$totalRows_docum = mysql_num_rows($docum);
							$i = 0 ;
							if ($totalRows_docum != 0) {
								$photographie = $row_objets['PHOTOGRAPHIE_PARAM'];
								do {
									// fabrication des tableaux d'images
									if ($row_docum['FICHIER'] != "" && $photographie[$i] == 1){
										if ($i == 0){
											$photo = $row_docum['FICHIER'];
											$identifiant = $row_docum['IDENTIFIANT'];
										}else{
											$photo = $photo."/".$row_docum['FICHIER'];
											$identifiant = $identifiant."/".$row_docum['IDENTIFIANT'];
										}
									} //$row_docum['FICHIER'] != ""
								$i++;
								} while ($row_docum = mysql_fetch_assoc($docum));
							}
							$tabPhoto = "";
							$tabPhoto = split('/',$photo);
							$tabIdentifiant = split('/',$identifiant);
							$cpt = 0;
							foreach ($tabPhoto as $fichier){
								if ($fichier != "") { ?> <br>
									<a href="<?php echo '../include/images.php?SRC='.$fichier.'&amp;LARG=980&amp;HAUT=700'; ?>" target="_blank"><img src="<?php echo "../include/images.php?SRC=".$fichier."&amp;LARG=150&amp;HAUT=150"; ?>" alt="illustration repr&eacute;sentative de l'oeuvre" border="0"></a><br>
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
<br>
<?php if (($valeur % 3) == 0){ ?>

<table class="enteteTableau pageEnd">
    <tr>
        <td class="enteteCol_1 centrer">Fiche obtenue par AlienorWebLibre.<br>
Pour plus d&#8217;informations : <a href="http://www.inter-regions-musees.org">inter-regions-musees.org</a>.</td>
        <td class="enteteCol_2">Page <?php echo $page; ?></td>
    </tr>
</table>
<?php
	$page = $page + 1;
}
?>

<?php } // fin du foreach ?>
</body>
</html>
