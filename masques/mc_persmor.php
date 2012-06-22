<?php
		session_start();
require_once('../config/config.php');
	$niveau_visa = $mcr;
	$page = "persmor";
	$objet = 0;
	include('../include/securite.php');
	include('../include/fonctions.php');
	require_once('../Connections/alienorweblibre.php');
	$photo="";
	$identifiant="";
	$index_documentation="";

(isset($_GET['noFiche'])) ? $noFiche = intval($_GET['noFiche']) : $noFiche = 0 ;
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_personne = "SELECT * FROM personne WHERE INDEX_PERSONNE = ".$noFiche."";
$personne = mysql_query($query_personne, $alienorweblibre) or die(mysql_error());
$row_personne = mysql_fetch_assoc($personne);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="fr">
<head>
<title>Formulaire de consulation : Personne morale</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="pragma" content="no-cache">
<link href="../style/style_awl.css" rel="stylesheet" type="text/css" media="screen">
<link href="../style/style_awl_print.css" rel="stylesheet" type="text/css" media="print">
</head>
<body>
<?php include('../include/navigation.php'); ?>
<div id="haut">
    <h2>Formulaire de consultation Personne morale </h2>
</div>
<div id="s-menu">
    <div id="menu"><a href="#IDENTIFICATION">Identification</a> <span class="invisible">|</span> <a href="#ADRESSE">Adresse</a> <span class="invisible">|</span> <a href="#DOCUMENTATION">Documentation</a> <span class="invisible">|</span> <a href="#INFORMATIQUE">Gestion&nbsp;informatique</a></div>
</div>
<div class="spacer"> </div>
<div id="formulaireIMG">
    <div><a name="IDENTIFICATION"></a></div>
    <p class="titre">IDENTIFICATION</p>
    <table cellpadding="3" cellspacing="0" class="centpcent">
        <tr>
            <td class="tddesignation">Type de personne :</td>
            <td class="tddonnees"><?php echo $row_personne['TYPE_PERSONNE']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Nom&nbsp;(Autre appelation)&nbsp;:</td>
            <td class="tddonnees"><?php echo $row_personne['ETAT_CIVIL']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">&Eacute;tat : </td>
            <td class="tddonnees"><?php echo $row_personne['SPHERE_INFLUENCE']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Genre :</td>
            <td class="tddonnees"><?php echo $row_personne['GENRE']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation"> </td>
            <td class="tddonnees"></td>
        </tr>
    </table>
    <div><a name="ADRESSE"></a></div>
    <p class="titre">ADRESSE</p>
    <table cellpadding="3" cellspacing="0" class="centpcent">
        <tr>
            <td class="tddesignation">Site internet :</td>
            <td class="tddonnees"><a href="<?php echo $row_personne['SITE_INTERNET']; ?>" target="_blank"><?php echo $row_personne['SITE_INTERNET']; ?></a></td>
        </tr>
        <tr>
            <td class="tddesignation">Ad&egrave;le :</td>
            <td class="tddonnees"><a href="mailto:<?php echo $row_personne['ADELE']; ?>"><?php echo $row_personne['ADELE']; ?></a></td>
        </tr>
    </table>
    <div><a name="DOCUMENTATION"></a></div>
    <p class="titre">DOCUMENTATION</p>
    <table cellpadding="3" cellspacing="0" class="centpcent">
        <tr>
            <td class="tddonnees"><span class="tdtitre">Bibliographies :</span><br>
                <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_docum = "SELECT IDENTIFIANT, documentation.INDEX_DOCUMENTATION FROM documentation,per_doc WHERE per_doc.INDEX_PERSONNE =".$noFiche." AND documentation.INDEX_DOCUMENTATION = per_doc.INDEX_DOCUMENTATION AND per_doc.QUALIFIANT = 'BIBLIOGRAPHIE' ORDER BY INDEX_PER_DOC ASC";
$docum = mysql_query($query_docum, $alienorweblibre) or die(mysql_error());
$row_docum = mysql_fetch_assoc($docum);
$totalRows_docum = mysql_num_rows($docum);
$i = 0 ;
	do {
		if ($i !=0 ) {
			echo "<br>";
		}
		?> <span class="tddesignation">R&eacute;f&eacute;rence :</span> <?php
		echo $row_docum['IDENTIFIANT'];?> <?php if ($row_docum['INDEX_DOCUMENTATION'] != "") { ?> <a href="mc_documentation.php?noFiche=<?php echo $row_docum['INDEX_DOCUMENTATION'] ?>" target="_blank"><img src="../images/changer_base.gif"  alt="Voir la bibliographie" width="50" height="20" border="0" style="vertical-align:middle"></a> <?php } $i++;
		} while ($row_docum = mysql_fetch_assoc($docum)); ?> <br>
                <span class="tddesignation">N&deg; de page :</span> <?php echo $row_personne['BIBLIOGRAPHIE_PARAM']; ?> </td>
        </tr>
        <tr>
            <td class="tddonnees"><span class="tdtitre">Photographies :</span><br>
                <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_docum = "SELECT IDENTIFIANT, documentation.INDEX_DOCUMENTATION, FICHIER FROM documentation,per_doc WHERE per_doc.INDEX_PERSONNE =".$noFiche." AND documentation.INDEX_DOCUMENTATION = per_doc.INDEX_DOCUMENTATION AND per_doc.QUALIFIANT = 'PHOTOGRAPHIE' ORDER BY INDEX_PER_DOC ASC";
$docum = mysql_query($query_docum, $alienorweblibre) or die(mysql_error());
$row_docum = mysql_fetch_assoc($docum);
$totalRows_docum = mysql_num_rows($docum);
$i = 0 ;
	do {
		if ($i !=0 ) {
			echo "<br>";
		}?> <span class="tddesignation">N&deg; INV. Nat. :</span> <?php
		echo $row_docum['IDENTIFIANT'];?> <?php if ($row_docum['INDEX_DOCUMENTATION'] != "") { ?> <a href="mc_documentation.php?noFiche=<?php echo $row_docum['INDEX_DOCUMENTATION'] ?>" target="_blank"><img src="../images/changer_base.gif"  alt="Voir la photgraphie" width="50" height="20" border="0" style="vertical-align:middle"></a> <?php
		// fabrication des tableaux d'images
			if ($row_docum['FICHIER'] != ""){
				if ( $i == 0){
					$photo = $row_docum['FICHIER'];
					$identifiant = $row_docum['IDENTIFIANT'];
					$index_documentation = $row_docum['INDEX_DOCUMENTATION'];
				}else{
					$photo = $photo."/".$row_docum['FICHIER'];
					$identifiant = $identifiant."/".$row_docum['IDENTIFIANT'];
					$index_documentation = $index_documentation."/".$row_docum['INDEX_DOCUMENTATION'];
				}
			}; //$row_docum['FICHIER'] != ""
		 } $i++;
		} while ($row_docum = mysql_fetch_assoc($docum)); ?> <br>
                <span class="tddesignation">Rep&eacute;rage :</span> <?php echo $row_personne['PHOTOGRAPHIE_PARAM']; ?></td>
        </tr>
        <tr>
            <td class="tddonnees"><span class="tdtitre">Expositions :</span><br>
                <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_docum = "SELECT IDENTIFIANT, documentation.INDEX_DOCUMENTATION FROM documentation,per_doc WHERE per_doc.INDEX_PERSONNE =".$noFiche." AND documentation.INDEX_DOCUMENTATION = per_doc.INDEX_DOCUMENTATION AND per_doc.QUALIFIANT = 'EXPOSITION' ORDER BY INDEX_PER_DOC ASC";
$docum = mysql_query($query_docum, $alienorweblibre) or die(mysql_error());
$row_docum = mysql_fetch_assoc($docum);
$totalRows_docum = mysql_num_rows($docum);
$i = 0 ;
	do {
		if ($i !=0 ) {
			echo "<br>";
		}?> <span class="tddesignation">R&eacute;f&eacute;rence :</span> <?php
		echo $row_docum['IDENTIFIANT'];?> <?php if ($row_docum['INDEX_DOCUMENTATION'] != "") { ?> <a href="mc_documentation.php?noFiche=<?php echo $row_docum['INDEX_DOCUMENTATION'] ?>" target="_blank"><img src="../images/changer_base.gif"  alt="Voir l&#8217;exposition" width="50" height="20" border="0" style="vertical-align:middle"></a> <?php } $i++;
		} while ($row_docum = mysql_fetch_assoc($docum)); ?> <br>
                <span class="tddesignation">N&deg; dans le catalogue : </span> <?php echo $row_personne['EXPOSITION_PARAM']; ?> </td>
        </tr>
        <tr>
            <td class="tddonnees"><span class="tdtitre">Vid&eacute;os :</span><br>
                <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_docum = "SELECT IDENTIFIANT, documentation.INDEX_DOCUMENTATION FROM documentation,per_doc WHERE per_doc.INDEX_PERSONNE =".$noFiche." AND documentation.INDEX_DOCUMENTATION = per_doc.INDEX_DOCUMENTATION AND per_doc.QUALIFIANT = 'VIDEO' ORDER BY INDEX_PER_DOC ASC";
$docum = mysql_query($query_docum, $alienorweblibre) or die(mysql_error());
$row_docum = mysql_fetch_assoc($docum);
$totalRows_docum = mysql_num_rows($docum);
$i = 0 ;
	do {
		if ($i !=0 ) {
			echo "<br>";
		}?> <span class="tddesignation">R&eacute;f&eacute;rence :</span> <?php
		echo $row_docum['IDENTIFIANT'];?> <?php if ($row_docum['INDEX_DOCUMENTATION'] != "") { ?> <a href="mc_documentation.php?noFiche=<?php echo $row_docum['INDEX_DOCUMENTATION'] ?>" target="_blank"><img src="../images/changer_base.gif"  alt="Voir la vid&eacute;o" width="50" height="20" border="0" style="vertical-align:middle"></a> <?php } $i++;
		} while ($row_docum = mysql_fetch_assoc($docum)); ?> <br>
                <span class="tddesignation">Rep&egrave;re :</span> <?php echo $row_personne['VIDEO_PARAM']; ?> </td>
        </tr>
        <tr>
            <td class="tddonnees"><span class="tdtitre">C&eacute;d&eacute;roms : </span><br>
                <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_docum = "SELECT IDENTIFIANT, documentation.INDEX_DOCUMENTATION FROM documentation,per_doc WHERE per_doc.INDEX_PERSONNE =".$noFiche." AND documentation.INDEX_DOCUMENTATION = per_doc.INDEX_DOCUMENTATION AND per_doc.QUALIFIANT = 'CEDEROM' ORDER BY INDEX_PER_DOC ASC";
$docum = mysql_query($query_docum, $alienorweblibre) or die(mysql_error());
$row_docum = mysql_fetch_assoc($docum);
$totalRows_docum = mysql_num_rows($docum);
$i = 0 ;
	do {
		if ($i !=0 ) {
			echo "<br>";
		}?> <span class="tddesignation">N&deg; INV. Nat. :</span> <?php
		echo $row_docum['IDENTIFIANT'];?> <?php if ($row_docum['INDEX_DOCUMENTATION'] != "") { ?> <a href="mc_documentation.php?noFiche=<?php echo $row_docum['INDEX_DOCUMENTATION'] ?>" target="_blank"><img src="../images/changer_base.gif"  alt="Voir le c&eacute;d&eacute;rom" width="50" height="20" border="0" style="vertical-align:middle"></a> <?php } $i++;
		} while ($row_docum = mysql_fetch_assoc($docum)); ?> <br>
                <span class="tddesignation">Nom du fichier :</span> <?php echo $row_personne['CEDEROM_PARAM']; ?> </td>
        </tr>
        <tr>
            <td class="tddonnees"> <span class="tdtitre">Sites Internets :</span><br>
                <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_docum = "SELECT IDENTIFIANT, documentation.INDEX_DOCUMENTATION FROM documentation,per_doc WHERE per_doc.INDEX_PERSONNE =".$noFiche." AND documentation.INDEX_DOCUMENTATION = per_doc.INDEX_DOCUMENTATION AND per_doc.QUALIFIANT = 'INTERNET' ORDER BY INDEX_PER_DOC ASC";
$docum = mysql_query($query_docum, $alienorweblibre) or die(mysql_error());
$row_docum = mysql_fetch_assoc($docum);
$totalRows_docum = mysql_num_rows($docum);
$i = 0 ;
	do {
		if ($i !=0 ) {
			echo "<br>";
		}?> <span class="tddesignation">R&eacute;f&eacute;rence : </span> <?php
		echo $row_docum['IDENTIFIANT'];?> <?php if ($row_docum['INDEX_DOCUMENTATION'] != "") { ?> <a href="mc_documentation.php?noFiche=<?php echo $row_docum['INDEX_DOCUMENTATION'] ?>" target="_blank"><img src="../images/changer_base.gif"  alt="Voir le site internet" width="50" height="20" border="0" style="vertical-align:middle"></a> <?php } $i++;
		} while ($row_docum = mysql_fetch_assoc($docum)); ?> <br>
                <span class="tddesignation">Lien :</span> <?php if(!empty($row_personne['INTERNET_PARAM'])){ ?><a href="<?php echo $row_personne['INTERNET_PARAM']; ?>" target="_Blank"><?php echo $row_personne['INTERNET_PARAM']; ?></a><?php } ?></td>
        </tr>
        <tr>
            <td class="tddonnees"><span class="tdtitre">Tapuscrits :</span><br>
                <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_docum = "SELECT IDENTIFIANT, documentation.INDEX_DOCUMENTATION FROM documentation,per_doc WHERE per_doc.INDEX_PERSONNE =".$noFiche." AND documentation.INDEX_DOCUMENTATION = per_doc.INDEX_DOCUMENTATION AND per_doc.QUALIFIANT = 'TAPUSCRIT' ORDER BY INDEX_PER_DOC ASC";
$docum = mysql_query($query_docum, $alienorweblibre) or die(mysql_error());
$row_docum = mysql_fetch_assoc($docum);
$totalRows_docum = mysql_num_rows($docum);
$i = 0 ;
	do {
		if ($i !=0 ) {
			echo "<br>";
		}?> <span class="tddesignation">R&eacute;f&eacute;rence :</span>&nbsp; <?php
		echo $row_docum['IDENTIFIANT'];?> <?php if ($row_docum['INDEX_DOCUMENTATION'] != "") { ?> <a href="mc_documentation.php?noFiche=<?php echo $row_docum['INDEX_DOCUMENTATION'] ?>" target="_blank"><img src="../images/changer_base.gif"  alt="Voir le tapuscrit" width="50" height="20" border="0" style="vertical-align:middle"></a> <?php } $i++;
		} while ($row_docum = mysql_fetch_assoc($docum)); ?> <br>
                <span class="tddesignation">Commentaires :</span>&nbsp; <?php echo $row_personne['TAPUSCRIT_PARAM']; ?> </td>
        </tr>
        <tr>
            <td class="tddonnees"> <span class="tdtitre">Manuscrits :</span><br>
                <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_docum = "SELECT IDENTIFIANT, documentation.INDEX_DOCUMENTATION FROM documentation,per_doc WHERE per_doc.INDEX_PERSONNE =".$noFiche." AND documentation.INDEX_DOCUMENTATION = per_doc.INDEX_DOCUMENTATION AND per_doc.QUALIFIANT = 'MANUSCRIT' ORDER BY INDEX_PER_DOC ASC";
$docum = mysql_query($query_docum, $alienorweblibre) or die(mysql_error());
$row_docum = mysql_fetch_assoc($docum);
$totalRows_docum = mysql_num_rows($docum);
$i = 0 ;
	do {
		if ($i !=0 ) {
			echo "<br>";
		}?> <span class="tddesignation">R&eacute;f&eacute;rence :</span> <?php
		echo $row_docum['IDENTIFIANT'];?> <?php if ($row_docum['INDEX_DOCUMENTATION'] != "") { ?> <a href="mc_documentation.php?noFiche=<?php echo $row_docum['INDEX_DOCUMENTATION'] ?>" target="_blank"><img src="../images/changer_base.gif"  alt="Voir le manuscrit" width="50" height="20" border="0" style="vertical-align:middle"></a> <?php } $i++;
		} while ($row_docum = mysql_fetch_assoc($docum)); ?> <br>
                <span class="tddesignation">Commentaires :</span>&nbsp; <?php echo $row_personne['MANUSCRIT_PARAM']; ?> </td>
        </tr>
    </table>
    <div><a name="INFORMATIQUE"></a></div>
    <p class="titre">GESTION INFORMATIQUE</p>
    <table cellpadding="3" cellspacing="0" class="centpcent">
        <tr>
            <td class="tddesignation">Num&eacute;ro de fiche :</td>
            <td class="tddonnees"><?php echo $row_personne['INDEX_PERSONNE']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Identifiant national :</td>
            <td class="tddonnees"><?php echo $row_personne['IDENTIFIANT_NATIONAL']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Copyright :</td>
            <td class="tddonnees"><?php echo $row_personne['COPYRIGHT']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Fiche cr&eacute;&eacute;e par :</td>
            <td class="tddonnees"><?php echo $row_personne['FICHE_CREEE_PAR']; ?> le : <?php echo reverseDate($row_personne['FICHE_CREEE_LE']); ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Mise &agrave; jour le :</td>
            <td class="tddonnees"><?php echo reverseDate($row_personne['MISE_A_JOUR']); ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Niveau de visa :</td>
            <td class="tddonnees"><?php echo $row_personne['NIVEAU_VISA']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Code Mus&eacute;e :</td>
            <td class="tddonnees"><?php echo $row_personne['CODEMUSEE']; $codeMusee = $row_personne['CODEMUSEE'];?></td>
        </tr>
    </table>
</div>
<?php 	include('../include/bande_img.php'); ?>
</body>
</html>
<?php
mysql_free_result($personne);
?>