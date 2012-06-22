<?php
	session_start();
	require_once('../config/config.php');
	$niveau_visa = $mcr;
	include('../include/securite.php');
	include('../include/fonctions.php');
	require_once('../Connections/alienorweblibre.php');
	$page = "archeo";
	$isobjet =1;
	$photo="";
	$index_documentation="";
	(isset($_GET['noFiche'])) ? $noFiche = intval($_GET['noFiche']) : $noFiche = 0 ;

	mysql_select_db($database_alienorweblibre, $alienorweblibre);
	$query_objets = "SELECT * FROM objet WHERE INDEX_OBJET = ".$noFiche."";
	$objets = mysql_query($query_objets, $alienorweblibre) or die(mysql_error());
	$row_objets = mysql_fetch_assoc($objets);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="fr">
<head>
<title>Formulaire de consultation : Arch&eacute;ologie</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="pragma" content="no-cache">
<link href="../style/style_awl.css" rel="stylesheet" type="text/css" media="screen">
<link href="../style/style_awl_print.css" rel="stylesheet" type="text/css" media="print">
</head>
<body>
<?php include('../include/navigation.php'); ?>
<div id="haut">
    <h2>Formulaire de consultation Arch&eacute;ologie </h2>
</div>
<div id="s-menu">
    <div id="menu"><a href="#IDENTIFICATION">D&eacute;signation</a> <span class="invisible">|</span> <a href="#DECOUVERTE">Provenance&nbsp;g&eacute;ographique</a> <span class="invisible">|</span> <a href="#DESCRIPTION">Description</a> <span class="invisible">|</span> <a href="#EXECUTION">Donn&eacute;es&nbsp;sur &nbsp;l'execution</a> <span class="invisible">|</span> <a href="#UTILISATION">Donn&eacute;es&nbsp;sur&nbsp;l'utilisation</a> <span class="invisible">|</span> <a href="#ADMINISTRATION">Information&nbsp;administrative</a> <span class="invisible">|</span> <a href="#objet_rapport">Objets&nbsp;li&eacute;s</a> <span class="invisible">|</span> <a href="#GESTIONpos">Gestion</a> <span class="invisible">|</span> <a href="#DOCUMENTATION">Documentation</a> <span class="invisible">|</span> <a href="#INFORMATIQUE">Gestion&nbsp;informatique</a></div>
</div>
<div class="spacer"> </div>
<div id="formulaireIMG">
    <div><a name="IDENTIFICATION"></a></div>
    <p class="titre">D&Eacute;SIGNATION</p>
    <?php do { ?>
    <table cellpadding="3" cellspacing="0" class="centpcent">
        <tr>
            <td class="tddesignation">Discipline :</td>
            <td class="tddonnees"><?php echo $row_objets['DISCIPLINE']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Domaine :</td>
            <td class="tddonnees"><?php echo $row_objets['DOMAINE']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Num&eacute;ro&nbsp;d&#8217;inventaire&nbsp;:</td>
            <td class="tddonnees"><?php echo $row_objets['NUMERO_INVENTAIRE']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">D&eacute;nomination :</td>
            <td class="tddonnees"><?php echo $row_objets['DENOMINATION']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Typologie :</td>
            <td class="tddonnees"><?php echo $row_objets['TYPOLOGIE']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Titre :</td>
            <td class="tddonnees"><?php echo nl2br($row_objets['TITRE']); ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Appellation :</td>
            <td class="tddonnees"><?php echo $row_objets['APPELLATION']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Appellation&nbsp;vernaculaire&nbsp;:</td>
            <td class="tddonnees"><?php echo $row_objets['VERNACULAIRE']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Nombre&nbsp;d&#8217;exemplaires&nbsp;:</td>
            <td class="tddonnees"><?php echo $row_objets['NB_EXEMPLAIRE']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Taxonomie&nbsp;:</td>
            <td class="tddonnees"><?php echo $row_objets['TAXONOMIE']; ?></td>
        </tr>
    </table>
    <div><a name="DECOUVERTE"></a></div>
    <p class="titre">PROVENANCE G&Eacute;OGRAPHIQUE</p>
    <table cellpadding="3" cellspacing="0" class="centpcent">
        <tr>
            <td class="tddesignation">Lieux&nbsp;de&nbsp;d&eacute;couverte&nbsp;:</td>
            <td class="tddonnees"> <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_lieu = "SELECT lieu.INDEX_LIEU, SITE FROM lieu,obj_lie WHERE obj_lie.INDEX_OBJET =".$noFiche." AND lieu.INDEX_LIEU = obj_lie.INDEX_LIEU AND obj_lie.QUALIFIANT = 'LIEUX_DECOUVERTE' ORDER BY INDEX_OBJ_LIE ASC";
$lieu = mysql_query($query_lieu, $alienorweblibre) or die(mysql_error());
$row_lieu = mysql_fetch_assoc($lieu);
$totalRows_lieu = mysql_num_rows($lieu);
$i = 0 ;
	do {
		if ($i !=0 ) {
			echo ("<br>");
		}
		echo $row_lieu['SITE']; ?> <?php if ($row_lieu['INDEX_LIEU'] != "") { ?> <a href="mc_lieu.php?noFiche=<?php echo $row_lieu['INDEX_LIEU']; ?>" target="_blank"><img src="../images/changer_base.gif" alt="D&eacute;tails sur le G&icirc;te" width="50" height="20" border="0" style="vertical-align:middle"></a> <?php }
		$i++;
	} while ($row_lieu = mysql_fetch_assoc($lieu)); ?>
        <tr>
            <td class="tddesignation">Type&nbsp;de&nbsp;fouille :</td>
            <td class="tddonnees"><?php echo $row_objets['TYPE_COLLECTE']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Date de d&eacute;couverte :</td>
            <td class="tddonnees"><?php echo $row_objets['TXT_DATE_DECOUVERTE']; ?>&nbsp;<?php echo reverseDate($row_objets['DEB_DATE_DECOUVERTE']); ?>&nbsp;et&nbsp;<?php echo reverseDate($row_objets['FIN_DATE_DECOUVERTE']); ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Inventeur&nbsp;:</td>
            <td class="tddonnees"> <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_auteur = "SELECT personne.INDEX_PERSONNE, ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET =".$noFiche." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'INVENTEUR' ORDER BY INDEX_OBJ_PER ASC";
$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
$row_auteur = mysql_fetch_assoc($auteur);
$totalRows_auteur = mysql_num_rows($auteur);
$i = 0;
	do {
		if ($i !=0 ) {
			echo ("<br>");
		}
		echo $row_auteur['ETAT_CIVIL']; ?> <?php if ($row_auteur['INDEX_PERSONNE'] != "") { ?> <a href="mc_personne.php?noFiche=<?php echo $row_auteur['INDEX_PERSONNE']; ?>" target="_blank"><img src="../images/changer_base.gif" alt="D&eacute;tails sur le collecteur" width="50" height="20" border="0" style="vertical-align:middle"></a> <?php }
		$i++;
	} while ($row_auteur = mysql_fetch_assoc($auteur)); ?> </td>
        </tr>
    </table>
    <div><a name="DESCRIPTION"></a></div>
    <p class="titre">DESCRIPTION</p>
    <table cellpadding="3" cellspacing="0" class="centpcent">
        <tr>
            <td class="tddesignation">Mati&eacute;re :</td>
            <td class="tddonnees"><?php echo $row_objets['MATIERE']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Technique :</td>
            <td class="tddonnees"><?php echo $row_objets['TECHNIQUE']; ?></td>
        </tr>
        <tr>
            <td height="26" class="tddesignation">Encombrement :</td>
            <td class="tddonnees"><?php echo $row_objets['ENCOMBREMENT']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Dimensions et forme :</td>
            <td class="tddonnees"><?php echo nl2br($row_objets['DIMENSIONS_FORMES']); ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Type d&#8217;inscription :</td>
            <td class="tddonnees"><?php echo $row_objets['TYPE_INSCRIPTION']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Transcription&nbsp;des&nbsp;inscriptions&nbsp;:</td>
            <td class="tddonnees"><?php echo nl2br($row_objets['TRANSCRIPTION_INSCRIPTION']); ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Onomastique :</td>
            <td class="tddonnees"><?php echo nl2br($row_objets['ONOMASTIQUE']); ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Repr&eacute;sentation et d&eacute;cor :</td>
            <td class="tddonnees"><?php echo $row_objets['REPRESENTATION_DECOR']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Description :</td>
            <td class="tddonnees"><?php echo nl2br($row_objets['PRECISION_DESCRIPTION']); ?></td>
        </tr>
    </table>
    <div><a name="EXECUTION"></a></div>
    <p class="titre">DONN&Eacute;ES SUR L&#8217;EX&Eacute;CUTION</p>
    <table cellpadding="3" cellspacing="0" class="centpcent">
        <tr>
            <td class="tddonnees"> <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_auteur = "SELECT personne.INDEX_PERSONNE, ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET =".$noFiche." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'AUTEUR' ORDER BY INDEX_OBJ_PER ASC";
$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
$row_auteur = mysql_fetch_assoc($auteur);
$totalRows_auteur = mysql_num_rows($auteur);
$i = 0;
	do { 
		if ($i !=0 ) {
			echo ("<br>");
		}
	?> <span class="tddesignation">Auteur : </span> <?php
		echo $row_auteur['ETAT_CIVIL']; ?> <?php if ($row_auteur['INDEX_PERSONNE'] != "") { ?> <a href="mc_personne.php?noFiche=<?php echo $row_auteur['INDEX_PERSONNE']; ?>" target="_blank"><img src="../images/changer_base.gif" alt="D&eacute;tails sur l'auteur" width="50" height="20" border="0" style="vertical-align:middle"></a> <?php }
		$i++;
	} while ($row_auteur = mysql_fetch_assoc($auteur)); ?> <br>
                <span class="tddesignation">R&ocirc;le de l'auteur :</span> <?php echo $row_objets['ROLE']; ?> </td>
        </tr>
    </table>
    <table cellpadding="3" cellspacing="0" class="centpcent">
        <tr>
            <td class="tddesignation">Lieu d&#8217;ex&eacute;cution : </td>
            <td class="tddonnees"> <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_lieu = "SELECT lieu.INDEX_LIEU, SITE FROM lieu,obj_lie WHERE obj_lie.INDEX_OBJET =".$noFiche." AND lieu.INDEX_LIEU = obj_lie.INDEX_LIEU AND obj_lie.QUALIFIANT = 'LIEUX_EXECUTION' ORDER BY INDEX_OBJ_LIE ASC";
$lieu = mysql_query($query_lieu, $alienorweblibre) or die(mysql_error());
$row_lieu = mysql_fetch_assoc($lieu);
$totalRows_lieu = mysql_num_rows($lieu);
$i = 0 ;
	do {
		if ($i !=0 ) {
			echo ("<br>");
		}
		echo $row_lieu['SITE']; ?> <?php if ($row_lieu['INDEX_LIEU'] != "") { ?> <a href="mc_lieu.php?noFiche=<?php echo $row_lieu['INDEX_LIEU']; ?>" target="_blank"><img src="../images/changer_base.gif" alt="D&eacute;tails sur le lieu d'ex&eacute;cution" width="50" height="20" border="0" style="vertical-align:middle"></a> <?php }
		$i++;
	} while ($row_lieu = mysql_fetch_assoc($lieu)); ?> </td>
        </tr>
        <tr>
            <td class="tddesignation">Pr&eacute;cision sur la gen&egrave;se :</td>
            <td class="tddonnees"><?php echo nl2br($row_objets['PRECISION_GENESE']); ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Date de l&#8217;ex&eacute;cution :</td>
            <td class="tddonnees"><?php echo $row_objets['TXT_DATE_EXECUTION']; ?> &nbsp;<?php echo reverseDate($row_objets['DEB_DATE_EXECUTION']); ?>&nbsp;et&nbsp;<?php echo reverseDate($row_objets['FIN_DATE_EXECUTION']); ?></td>
        </tr>
        <tr>
            <td height="22" class="tddesignation">Si&egrave;cle ou mill&eacute;naire :</td>
            <td class="tddonnees"><?php echo $row_objets['SIECLE_MILLENAIRE']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Style :</td>
            <td class="tddonnees"><?php echo $row_objets['EPOQUE_STYLE']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Pr&eacute;cision sur la datation :</td>
            <td class="tddonnees"><?php echo nl2br($row_objets['PRECISION_DATATION']); ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Sources&nbsp;de&nbsp;la&nbsp;repr&eacute;sentation&nbsp;:</td>
            <td class="tddonnees"><?php echo nl2br($row_objets['SOURCE_ORALE_ECRITE']); ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Date de repr&eacute;sentation :</td>
            <td class="tddonnees"><?php echo $row_objets['TXT_DATE_REPRESENTATION']; ?>&nbsp;<?php echo reverseDate($row_objets['DEB_DATE_REPRESENTATION']); ?>&nbsp;et&nbsp;<?php echo reverseDate($row_objets['FIN_DATE_REPRESENTATION']); ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Datation original copi&eacute; :</td>
            <td class="tddonnees"><?php echo $row_objets['TXT_DATE_ORIGINAL_COPIE']; ?>&nbsp;<?php echo reverseDate($row_objets['DEB_DATE_ORIGINAL_COPIE']); ?>&nbsp;et&nbsp;<?php echo reverseDate($row_objets['FIN_DATE_ORIGINAL_COPIE']); ?></td>
        </tr>
    </table>
    <div><a name="UTILISATION"></a></div>
    <p class="titre">DONN&Eacute;ES&nbsp;SUR&nbsp;L&#8217;UTILISATION</p>
    <table cellpadding="3" cellspacing="0" class="centpcent">
        <tr>
            <td class="tddesignation">Utilisation : </td>
            <td class="tddonnees"><?php echo $row_objets['UTILISATION']; ?> </td>
        </tr>
        <tr>
            <td class="tddesignation">Utilisateur :</td>
            <td class="tddonnees"> <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_auteur = "SELECT personne.INDEX_PERSONNE, ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET =".$noFiche." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'UTILISATEUR' ORDER BY INDEX_OBJ_PER ASC";
$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
$row_auteur = mysql_fetch_assoc($auteur);
$totalRows_auteur = mysql_num_rows($auteur);
$i = 0;
	do {
		if ($i !=0 ) {
			echo ("<br>");
		}
		echo $row_auteur['ETAT_CIVIL']; ?> <?php if ($row_auteur['INDEX_PERSONNE'] != "") { ?> <a href="mc_personne.php?noFiche=<?php echo $row_auteur['INDEX_PERSONNE']; ?>" target="_blank"><img src="../images/changer_base.gif" alt="D&eacute;tails sur l'utilisateur" width="50" height="20" border="0" style="vertical-align:middle"></a> <?php }
		$i++;
	} while ($row_auteur = mysql_fetch_assoc($auteur)); ?> </td>
        </tr>
        <tr>
            <td class="tddesignation">Pr&eacute;cision sur l&#8217;utilisation :</td>
            <td class="tddonnees"><?php echo nl2br($row_objets['PRECISION_UTILISATION']); ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Pr&eacute;cision&nbsp;sur&nbsp;l&#8217;utilisation&nbsp;seconde&nbsp;:</td>
            <td class="tddonnees"><?php echo nl2br($row_objets['UTILISATION_SECONDE']); ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Date de l&#8217;utilisation :</td>
            <td class="tddonnees"><?php echo $row_objets['TXT_DATE_UTILISATION']; ?>&nbsp;<?php echo reverseDate($row_objets['DEB_DATE_UTILISATION']); ?>&nbsp;et&nbsp;<?php echo reverseDate($row_objets['FIN_DATE_UTILISATION']); ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Lieu d&#8217;utilisation :</td>
            <td class="tddonnees"> <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_lieu = "SELECT lieu.INDEX_LIEU, SITE FROM lieu,obj_lie WHERE obj_lie.INDEX_OBJET =".$noFiche." AND lieu.INDEX_LIEU = obj_lie.INDEX_LIEU AND obj_lie.QUALIFIANT = 'LIEUX_UTILISATION' ORDER BY INDEX_OBJ_LIE ASC";
$lieu = mysql_query($query_lieu, $alienorweblibre) or die(mysql_error());
$row_lieu = mysql_fetch_assoc($lieu);
$totalRows_lieu = mysql_num_rows($lieu);
$i = 0 ;
	do {
		if ($i !=0 ) {
			echo ("<br>");
		}
		echo $row_lieu['SITE']; ?> <?php if ($row_lieu['INDEX_LIEU'] != "") { ?> <a href="mc_lieu.php?noFiche=<?php echo $row_lieu['INDEX_LIEU']; ?>" target="_blank"><img src="../images/changer_base.gif" alt="D&eacute;tails sur le lieu d'utilisation" width="50" height="20" border="0" style="vertical-align:middle"></a> <?php }
		$i++;
	} while ($row_lieu = mysql_fetch_assoc($lieu)); ?> </td>
        </tr>
    </table>
    <div><a name="ADMINISTRATION"></a></div>
    <p class="titre">INFORMATIONS ADMINISTRATIVES</p>
    <table cellpadding="3" cellspacing="0" class="centpcent">
        <tr>
            <td class="tddesignation">Localisation :</td>
            <td class="tddonnees"><?php echo $row_objets['LOCALISATION']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Propri&eacute;taire :</td>
            <td class="tddonnees"> <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_auteur = "SELECT personne.INDEX_PERSONNE, ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET =".$noFiche." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'PROPRIETAIRE' ORDER BY INDEX_OBJ_PER ASC";
$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
$row_auteur = mysql_fetch_assoc($auteur);
$totalRows_auteur = mysql_num_rows($auteur);
$i = 0;
	do {
		if ($i !=0 ) {
			echo ("<br>");
		}
		echo $row_auteur['ETAT_CIVIL']; ?> <?php if ($row_auteur['INDEX_PERSONNE'] != "") { ?> <a href="mc_personne.php?noFiche=<?php echo $row_auteur['INDEX_PERSONNE']; ?>" target="_blank"><img src="../images/changer_base.gif" alt="D&eacute;tails sur le collecteur" width="50" height="20" border="0" style="vertical-align:middle"></a> <?php }
		$i++;
	} while ($row_auteur = mysql_fetch_assoc($auteur)); ?> </td>
        </tr>
        <tr>
            <td class="tddesignation">Date d&#8217;acquisition :</td>
            <td class="tddonnees"><?php echo $row_objets['PROPRIETAIRE_TXT_DATE_PATRIMONIALE']; ?>&nbsp;<?php echo reverseDate($row_objets['PROPRIETAIRE_DEB_DATE_PATRIMONIALE']); ?>&nbsp;et&nbsp;<?php echo reverseDate($row_objets['PROPRIETAIRE_FIN_DATE_PATRIMONIALE']); ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Service gestionnaire :</td>
            <td class="tddonnees"> <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_auteur = "SELECT personne.INDEX_PERSONNE, ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET =".$noFiche." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'SERVICE_GESTIONNAIRE' ORDER BY INDEX_OBJ_PER ASC";
$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
$row_auteur = mysql_fetch_assoc($auteur);
$totalRows_auteur = mysql_num_rows($auteur);
$i = 0;
	do {
		if ($i !=0 ) {
			echo ("<br>");
		}
		echo $row_auteur['ETAT_CIVIL']; ?> <?php if ($row_auteur['INDEX_PERSONNE'] != "") { ?> <a href="mc_personne.php?noFiche=<?php echo $row_auteur['INDEX_PERSONNE']; ?>" target="_blank"><img src="../images/changer_base.gif" alt="D&eacute;tails sur le collecteur" width="50" height="20" border="0" style="vertical-align:middle"></a> <?php }
		$i++;
	} while ($row_auteur = mysql_fetch_assoc($auteur)); ?> </td>
        </tr>
        <tr>
            <td class="tddesignation">Mode d&#8217;acquisition :</td>
            <td class="tddonnees"><?php echo $row_objets['MODE_ACQUISITION']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Type de propri&eacute;t&eacute; :</td>
            <td class="tddonnees"><?php echo $row_objets['TYPE_PROPRIETE']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Lot :</td>
            <td class="tddonnees"><?php echo $row_objets['LOT']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Num&eacute;ro :</td>
            <td class="tddonnees"><?php echo $row_objets['NUMERO']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Pr&eacute;cision administrative : </td>
            <td class="tddonnees"><?php echo nl2br($row_objets['PRECISION_ADMINISTRATIVE']);; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">D&eacute;positaire : </td>
            <td class="tddonnees"> <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_auteur = "SELECT personne.INDEX_PERSONNE, ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET =".$noFiche." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'DEPOSITAIRE' ORDER BY INDEX_OBJ_PER ASC";
$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
$row_auteur = mysql_fetch_assoc($auteur);
$totalRows_auteur = mysql_num_rows($auteur);
$i = 0;
	do {
		if ($i !=0 ) {
			echo ("<br>");
		}
		echo $row_auteur['ETAT_CIVIL']; ?> <?php if ($row_auteur['INDEX_PERSONNE'] != "") { ?> <a href="mc_personne.php?noFiche=<?php echo $row_auteur['INDEX_PERSONNE']; ?>" target="_blank"><img src="../images/changer_base.gif" alt="D&eacute;tails sur le collecteur" width="50" height="20" border="0" style="vertical-align:middle"></a> <?php }
		$i++;
	} while ($row_auteur = mysql_fetch_assoc($auteur)); ?> </td>
        </tr>
        <tr>
            <td class="tddesignation">Date de d&eacute;p&ocirc;t :</td>
            <td class="tddonnees"><?php echo $row_objets['DEPOSITAIRE_TXT_DATE_PATRIMONIALE']; ?>&nbsp;<?php echo reverseDate($row_objets['DEPOSITAIRE_DEB_DATE_PATRIMONIALE']); ?>&nbsp;et&nbsp;<?php echo reverseDate($row_objets['DEPOSITAIRE_FIN_DATE_PATRIMONIALE']); ?> </td>
        </tr>
        <tr>
            <td colspan="2" class="tdtitre"><br>
                Historique de l'objet</td>
        </tr>
        <tr>
            <td class="tddesignation">Ancienne appartenance :</td>
            <td class="tddonnees"> <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_auteur = "SELECT personne.INDEX_PERSONNE, ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET =".$noFiche." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'ANCIENNE_APPARTENANCE' ORDER BY INDEX_OBJ_PER ASC";
$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
$row_auteur = mysql_fetch_assoc($auteur);
$totalRows_auteur = mysql_num_rows($auteur);
$i = 0;
	do {
		if ($i !=0 ) {
			echo ("<br>");
		}
		echo $row_auteur['ETAT_CIVIL']; ?> <?php if ($row_auteur['INDEX_PERSONNE'] != "") { ?> <a href="mc_personne.php?noFiche=<?php echo $row_auteur['INDEX_PERSONNE']; ?>" target="_blank"><img src="../images/changer_base.gif" alt="D&eacute;tails sur le collecteur" width="50" height="20" border="0" style="vertical-align:middle"></a> <?php }
		$i++;
	} while ($row_auteur = mysql_fetch_assoc($auteur)); ?> <br>
                <span class="tddesignation">Date d&#8217;entr&eacute;e dans collection :</span>&nbsp;<?php echo $row_objets['ANCIENNE_APPARTENANCE_TXT_DATE_PATRIMONIALE']; ?>&nbsp;<?php echo reverseDate($row_objets['ANCIENNE_APPARTENANCE_DEB_DATE_PATRIMONIALE']); ?>&nbsp;et&nbsp;<?php echo reverseDate($row_objets['ANCIENNE_APPARTENANCE_FIN_DATE_PATRIMONIALE']); ?> <br>
                <span class="tddesignation">Num&eacute;ro de catalogue :</span> <?php echo $row_objets['NUMERO_CATALOGUE']; ?> </td>
        </tr>
        <tr>
            <td class="tddesignation">Commissaire priseur :</td>
            <td class="tddonnees"> <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_auteur = "SELECT personne.INDEX_PERSONNE, ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET =".$noFiche." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'COMMISSAIRE_PRISEUR' ORDER BY INDEX_OBJ_PER ASC";
$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
$row_auteur = mysql_fetch_assoc($auteur);
$totalRows_auteur = mysql_num_rows($auteur);
$i = 0;
	do {
		if ($i !=0 ) {
			echo ("<br>");
		}
		echo $row_auteur['ETAT_CIVIL']; ?> <?php if ($row_auteur['INDEX_PERSONNE'] != "") { ?> <a href="mc_personne.php?noFiche=<?php echo $row_auteur['INDEX_PERSONNE']; ?>" target="_blank"><img src="../images/changer_base.gif" alt="D&eacute;tails sur le collecteur" width="50" height="20" border="0" style="vertical-align:middle"></a> <?php }
		$i++;
	} while ($row_auteur = mysql_fetch_assoc($auteur)); ?> <br>
                <span class="tddesignation">Date de la vente :</span> <?php echo $row_objets['COMMISSAIRE_PRISEUR_TXT_DATE_PATRIMONIALE']; ?>&nbsp;<?php echo reverseDate($row_objets['COMMISSAIRE_PRISEUR_DEB_DATE_PATRIMONIALE']); ?>&nbsp;et&nbsp;<?php echo reverseDate($row_objets['COMMISSAIRE_PRISEUR_FIN_DATE_PATRIMONIALE']); ?><br>
                <span class="tddesignation">Num&eacute;ro dans le catalogue de la vente :</span> <?php echo $row_objets['COMMISSAIRE_PRISEUR_NUMERO_CATALOGUE']; ?> </td>
        </tr>
        <tr>
            <td class="tddesignation">Galerie :</td>
            <td class="tddonnees"> <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_auteur = "SELECT personne.INDEX_PERSONNE, ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET =".$noFiche." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'GALERIE' ORDER BY INDEX_OBJ_PER ASC";
$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
$row_auteur = mysql_fetch_assoc($auteur);
$totalRows_auteur = mysql_num_rows($auteur);
$i = 0;
	do {
		if ($i !=0 ) {
			echo ("<br>");
		}
		echo $row_auteur['ETAT_CIVIL']; ?> <?php if ($row_auteur['INDEX_PERSONNE'] != "") { ?> <a href="mc_personne.php?noFiche=<?php echo $row_auteur['INDEX_PERSONNE']; ?>" target="_blank"><img src="../images/changer_base.gif" alt="D&eacute;tails sur le collecteur" width="50" height="20" border="0" style="vertical-align:middle"></a> <?php }
		$i++;
	} while ($row_auteur = mysql_fetch_assoc($auteur)); ?> <br>
                <span class="tddesignation">Date :</span> <?php echo $row_objets['GALERIE_TXT_DATE_PATRIMONIALE']; ?>&nbsp;<?php echo reverseDate($row_objets['GALERIE_DEB_DATE_PATRIMONIALE']); ?>&nbsp;et&nbsp;<?php echo reverseDate($row_objets['GALERIE_FIN_DATE_PATRIMONIALE']); ?> <br>
                <span class="tddesignation">Num&eacute;ro dans le catalogue :</span> <?php echo $row_objets['GALERIE_NUMERO_CATALOGUE']; ?> </td>
        </tr>
        <tr>
            <td class="tddesignation">Ancien d&eacute;positaire : </td>
            <td class="tddonnees"> <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_auteur = "SELECT personne.INDEX_PERSONNE, ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET =".$noFiche." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'ANCIEN_DEPOSITAIRE' ORDER BY INDEX_OBJ_PER ASC";
$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
$row_auteur = mysql_fetch_assoc($auteur);
$totalRows_auteur = mysql_num_rows($auteur);
$i = 0;
	do {
		if ($i !=0 ) {
			echo ("<br>");
		}
		echo $row_auteur['ETAT_CIVIL']; ?> <?php if ($row_auteur['INDEX_PERSONNE'] != "") { ?> <a href="mc_personne.php?noFiche=<?php echo $row_auteur['INDEX_PERSONNE']; ?>" target="_blank"><img src="../images/changer_base.gif" alt="D&eacute;tails sur le collecteur" width="50" height="20" border="0" style="vertical-align:middle"></a> <?php }
		$i++;
	} while ($row_auteur = mysql_fetch_assoc($auteur)); ?> <br>
                <span class="tddesignation">date de d&eacute;p&ocirc;t :</span> <?php echo $row_objets['ANCIEN_DEPOSITAIRE_TXT_DATE_PATRIMONIALE']; ?>&nbsp;<?php echo reverseDate($row_objets['ANCIEN_DEPOSITAIRE_DEB_DATE_PATRIMONIALE']); ?>&nbsp;et&nbsp;<?php echo reverseDate($row_objets['ANCIEN_DEPOSITAIRE_FIN_DATE_PATRIMONIALE']); ?> </td>
        </tr>
    </table>
    <div><a name="DOCUMENTATION"></a></div>
    <p class="titre">DOCUMENTATION</p>
    <table cellpadding="3" cellspacing="0" class="centpcent">
        <tr>
            <td class="tddonnees"><span class="tdtitre">Bibliographies :</span><br>
                <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_docum = "SELECT IDENTIFIANT, documentation.INDEX_DOCUMENTATION FROM documentation,obj_doc WHERE obj_doc.INDEX_OBJET =".$noFiche." AND documentation.INDEX_DOCUMENTATION = obj_doc.INDEX_DOCUMENTATION AND obj_doc.QUALIFIANT = 'BIBLIOGRAPHIE' ORDER BY INDEX_OBJ_DOC ASC";
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
                <span class="tddesignation">N&deg; de page :</span> <?php echo $row_objets['BIBLIOGRAPHIE_PARAM']; ?> </td>
        </tr>
        <tr>
            <td class="tddonnees"><span class="tdtitre">Photographies :</span><br>
                <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_docum = "SELECT IDENTIFIANT, documentation.INDEX_DOCUMENTATION, FICHIER FROM documentation,obj_doc WHERE obj_doc.INDEX_OBJET =".$noFiche." AND documentation.INDEX_DOCUMENTATION = obj_doc.INDEX_DOCUMENTATION AND obj_doc.QUALIFIANT = 'PHOTOGRAPHIE' ORDER BY INDEX_OBJ_DOC ASC";
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
                <span class="tddesignation">Rep&eacute;rage :</span> <?php echo $row_objets['PHOTOGRAPHIE_PARAM']; ?></td>
        </tr>
        <tr>
            <td class="tddonnees"><span class="tdtitre">Expositions :</span><br>
                <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_docum = "SELECT IDENTIFIANT, documentation.INDEX_DOCUMENTATION FROM documentation,obj_doc WHERE obj_doc.INDEX_OBJET =".$noFiche." AND documentation.INDEX_DOCUMENTATION = obj_doc.INDEX_DOCUMENTATION AND obj_doc.QUALIFIANT = 'EXPOSITION' ORDER BY INDEX_OBJ_DOC ASC";
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
                <span class="tddesignation">N&deg; dans le catalogue : </span> <?php echo $row_objets['EXPOSITION_PARAM']; ?> </td>
        </tr>
        <tr>
            <td class="tddonnees"><span class="tdtitre">Vid&eacute;os :</span><br>
                <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_docum = "SELECT IDENTIFIANT, documentation.INDEX_DOCUMENTATION FROM documentation,obj_doc WHERE obj_doc.INDEX_OBJET =".$noFiche." AND documentation.INDEX_DOCUMENTATION = obj_doc.INDEX_DOCUMENTATION AND obj_doc.QUALIFIANT = 'VIDEO' ORDER BY INDEX_OBJ_DOC ASC";
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
                <span class="tddesignation">Rep&egrave;re :</span> <?php echo $row_objets['VIDEO_PARAM']; ?> </td>
        </tr>
        <tr>
            <td class="tddonnees"><span class="tdtitre">C&eacute;d&eacute;roms : </span><br>
                <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_docum = "SELECT IDENTIFIANT, documentation.INDEX_DOCUMENTATION FROM documentation,obj_doc WHERE obj_doc.INDEX_OBJET =".$noFiche." AND documentation.INDEX_DOCUMENTATION = obj_doc.INDEX_DOCUMENTATION AND obj_doc.QUALIFIANT = 'CEDEROM' ORDER BY INDEX_OBJ_DOC ASC";
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
                <span class="tddesignation">Nom du fichier :</span> <?php echo $row_objets['CEDEROM_PARAM']; ?> </td>
        </tr>
        <tr>
            <td class="tddonnees"> <span class="tdtitre">Sites Internets :</span><br>
                <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_docum = "SELECT IDENTIFIANT, documentation.INDEX_DOCUMENTATION FROM documentation,obj_doc WHERE obj_doc.INDEX_OBJET =".$noFiche." AND documentation.INDEX_DOCUMENTATION = obj_doc.INDEX_DOCUMENTATION AND obj_doc.QUALIFIANT = 'INTERNET' ORDER BY INDEX_OBJ_DOC ASC";
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
                <span class="tddesignation">Lien :</span><?php if(!empty($row_objets['INTERNET_PARAM'])){?><a href="<?php echo $row_objets['INTERNET_PARAM']; ?>" target="_blank"><?php echo $row_objets['INTERNET_PARAM']; ?></a><?php } ?></td>
        </tr>
        <tr>
            <td class="tddonnees"><span class="tdtitre">Tapuscrits :</span><br>
                <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_docum = "SELECT IDENTIFIANT, documentation.INDEX_DOCUMENTATION FROM documentation,obj_doc WHERE obj_doc.INDEX_OBJET =".$noFiche." AND documentation.INDEX_DOCUMENTATION = obj_doc.INDEX_DOCUMENTATION AND obj_doc.QUALIFIANT = 'TAPUSCRIT' ORDER BY INDEX_OBJ_DOC ASC";
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
                <span class="tddesignation">Commentaires :</span>&nbsp; <?php echo $row_objets['TAPUSCRIT_PARAM']; ?> </td>
        </tr>
        <tr>
            <td class="tddonnees"> <span class="tdtitre">Manuscrits :</span><br>
                <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_docum = "SELECT IDENTIFIANT, documentation.INDEX_DOCUMENTATION FROM documentation,obj_doc WHERE obj_doc.INDEX_OBJET =".$noFiche." AND documentation.INDEX_DOCUMENTATION = obj_doc.INDEX_DOCUMENTATION AND obj_doc.QUALIFIANT = 'MANUSCRIT' ORDER BY INDEX_OBJ_DOC ASC";
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
                <span class="tddesignation">Commentaires :</span>&nbsp; <?php echo $row_objets['MANUSCRIT_PARAM']; ?> </td>
        </tr>
        <tr>
            <td class="tddonnees"> <span class="tdtitre"><a name="objet_rapport"></a>Objets en rapport :</span><br>
               <?php
				$tableau = explode("/",$row_objets['LIEN_INTRAOBJET']);	
				for ($i=0; $i < count($tableau); $i++) {
					$identifiant = $tableau[$i];
					/* Recherche si l'objet existe déjà */
					mysql_select_db($database_alienorweblibre, $alienorweblibre);
					$query_rapport = "SELECT INDEX_OBJET FROM objet WHERE IDENTIFIANT_NATIONAL = '".$identifiant."'";
					/* echo ("Recherche => ligne 619<br>".$query_rapport."<br>"); */
					$rapport = mysql_query($query_rapport, $alienorweblibre) or die(mysql_error());
					$row_rapport = mysql_fetch_assoc($rapport);
					$totalRows_rapport = mysql_num_rows($rapport);			
					do {
						$objet_rapport = intval($row_rapport['INDEX_OBJET']);
					} while ($row_rapport = mysql_fetch_assoc($rapport));
					if ($rapport != "") {
						echo($identifiant) ; 
							if ($objet_rapport != 0) {?>
								 <a href="mc_<?php echo($page)?>.php?noFiche=<?php echo($objet_rapport)?>&page=<?php echo($page); ?>" target="_blank"><img src="../images/changer_base.gif"  alt="Voir les fiches li&eacute;s" width="50" height="20" border="0" style="vertical-align:middle"></a><br>
                			<?php	} 
					}	
				} ?> </td>
        </tr>
    </table>
    <div><a name="GESTIONpos"></a></div>
    <p class="titre">GESTION</p>
    <table cellpadding="3" cellspacing="0" class="centpcent">
        <tr>
            <td class="tddonnees"><span class="tddesignation">Accessoire de pr&eacute;sentation :</span> <?php echo nl2br($row_objets['ACCESSOIRE_PRESENTATION']); ?> </td>
        </tr>
        <tr>
            <td class="tddonnees"> <span class="tddesignation">Num&eacute;ro de dossier :</span> <?php echo $row_objets['NUMERO_DOSSIER']; ?> </td>
        </tr>
        <tr>
 			<td class="tddonnees">
              <form action="mc_objet_gestion.php" method="post" name="gestion" target="_blank" id="gestion">
              	<span class="tddesignation">Toutes les fiches gestion 
               	<input name="INDEX_OBJET" type="hidden" id="INDEX_OBJET" value="<?php echo $row_objets['INDEX_OBJET']; ?>">
                <a href="javascript:document.gestion.submit()"><img src="../images/changer_base.gif" alt="D&eacute;tails sur la fiche de gestion" width="50" height="20" border="0" style="vertical-align:middle"></a>
				</span>
              </form>
			</td>
		</tr>
    </table>
    <div><a name="INFORMATIQUE"></a></div>
    <p class="titre">GESTION INFORMATIQUE</p>
    <table cellpadding="3" cellspacing="0" class="centpcent" >
        <tr>
            <td class="tddesignation">Num&eacute;ro de fiche :</td>
            <td class="tddonnees"><?php echo $noFiche; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Identifiant national :</td>
            <td class="tddonnees"><?php echo $row_objets['IDENTIFIANT_NATIONAL']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Copyright :</td>
            <td class="tddonnees"><?php echo $row_objets['COPYRIGHT']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Fiche cr&eacute;&eacute;e par :</td>
            <td class="tddonnees"><?php echo $row_objets['FICHE_CREEE_PAR']; ?> <span class="tddesignation">le : </span><?php echo reverseDate($row_objets['FICHE_CREEE_LE']); ?> </td>
        </tr>
        <tr>
            <td class="tddesignation">Mise &agrave; jour le :</td>
            <td class="tddonnees"><?php echo reverseDate($row_objets['MISE_A_JOUR']); ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Niveau de visa :</td>
            <td class="tddonnees"><?php echo $row_objets['NIVEAU_VISA']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Code mus&eacute;e: </td>
            <td class="tddonnees"><?php echo $row_objets['CODEMUSEE']; ?></td>
        </tr>
    </table>
    <?php } while ($row_objets = mysql_fetch_assoc($objets)); ?>
    <div><a name="FIN_FORMULAIRE"></a></div>
</div>
<?php 	include('../include/bande_img.php'); ?>
</body>
</html>
<?php
mysql_free_result($objets);
?>