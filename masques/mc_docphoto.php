<?php
	session_start();
	require_once('../config/config.php');
	$valeurFichier = "";
	$niveau_visa = $mcr;
	isset($_GET['duplication'])?$duplication = $_GET['duplication']:$duplication = 0;
	$page = "docphoto";
	$objet = 0;

	include('../include/securite.php');
	include('../include/fonctions.php');
	require_once('../Connections/alienorweblibre.php');

(isset($_GET['noFiche'])) ? $noFiche = intval($_GET['noFiche']) : $noFiche = 0 ;
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_docum = "SELECT * FROM documentation WHERE INDEX_DOCUMENTATION = ".$noFiche."";
$docum = mysql_query($query_docum, $alienorweblibre) or die(mysql_error());
$row_docum = mysql_fetch_assoc($docum);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="fr">
<head>
<title>Formulaire de consultation : Photographie</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="pragma" content="no-cache">
<link href="../style/style_awl.css" rel="stylesheet" type="text/css" media="screen">
<link href="../style/style_awl_print.css" rel="stylesheet" type="text/css" media="print">
</head>
<body>
<div id="navigationDoc">
<?php include('../include/navigation.php'); ?>
</div>
<div id="hautDoc">
    <h2>Masque  de visualisation d&#8217;une photographie</h2>
</div>
<div id="s-menuDoc">
    <div id="menuDoc"><a href="#GENERALE">G&eacute;n&eacute;rale</a> <span class="invisible">|</span> <a href="#SUPPORT">Support</a> <span class="invisible">|</span> <a href="#PHOTO">Photographie</a> <span class="invisible">|</span> <a href="#INFORMATIQUE">Gestion&nbsp;informatique</a></div>
</div>
<div class="spacer"> </div>
<!-- ----------------------------- -->
<!-- debut traitement de l'image   -->
<!-- ----------------------------- -->
<div id="imagesDoc">
				<?php
				if ($duplication == 0 && $row_docum['FICHIER'] != ""){
					isset($_POST['FICHIER']) ? $valeurFichier = $_POST['FICHIER'] : $valeurFichier = $row_docum['FICHIER'];
					isset($_POST['FICHIER']) ? $valeurFichierTmp = $_POST['FICHIER'] : $valeurFichierTmp = $row_docum['FICHIER'];
				}else{
					$valeurFichierTmp = "visuel_de_remplacement.jpg";
				}
				?>
	<a href="<?php echo '../include/images.php?SRC='.$valeurFichierTmp.'&amp;LARG=980&amp;HAUT=700'; ?>" target="_blank"><img src="<?php echo "../include/images.php?SRC=".$valeurFichierTmp."&amp;LARG=300&amp;HAUT=300";?>" border="0" alt="visuel"></a></div>
<!-- ----------------------------- -->
<!--   fin traitement de l'image   -->
<!-- ----------------------------- -->
<div id="formulaireDoc">
    <div><a name="IDENTIFICATION"></a></div>
    <div><a name="GENERALE"></a></div>
    <p class="titre">G&Eacute;N&Eacute;RALE OU COMMUNE</p>
    <?php do { ?>
    <table cellpadding="3" cellspacing="0" class="centpcent">
        <tr>
            <td class="tddesignation">Type de document :</td>
            <td class="tddonnees"><?php echo $row_docum['TYPE_DOCUMENT']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Identifiant :</td>
            <td class="tddonnees"><?php echo $row_docum['IDENTIFIANT']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">P&eacute;riode concern&eacute;e par le document :</td>
            <td class="tddonnees"><?php echo $row_docum['PERIODE_CONCERNE']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Collection :</td>
            <td class="tddonnees"><?php echo $row_docum['COLLECTION']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Mots cl&eacute;s :</td>
            <td class="tddonnees"><?php echo $row_docum['MOTS_CLES']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Localisation :</td>
            <td class="tddonnees"><?php echo $row_docum['LOCALISATION_DOCUMENT']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Accessibilit&eacute; :</td>
            <td class="tddonnees"><?php echo $row_docum['ACCESSIBILITE']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Descriptions techniques :</td>
            <td class="tddonnees"><?php echo $row_docum['DESCRIPTION_TECHNIQUE']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Commentaires techniques  :</td>
            <td class="tddonnees"><?php echo $row_docum['COMMENTAIRE_TECHNIQUE']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Type de droit :</td>
            <td class="tddonnees"><?php echo $row_docum['TYPE_DROIT']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Commentaires :</td>
            <td class="tddonnees"><?php echo $row_docum['NOTE_LIBRE']; ?></td>
        </tr>
    </table>
    <div><a name="SUPPORT"></a></div>
    <p class="titre">SUPPORT</p>
    <table cellpadding="3" cellspacing="0" class="centpcent">
        <tr>
            <td class="tddesignation">Num&eacute;ro du support :</td>
            <td class="tddonnees"><?php echo $row_docum['NUMERO_SUPPORT']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Pr&eacute;cision ou adresse sur le support :</td>
            <td class="tddonnees"><?php echo $row_docum['PRECISION_SUPPORT']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation"> </td>
            <td class="tddonnees"></td>
        </tr>
    </table>
    <div><a name="PHOTO"></a></div>
    <p class="titre">PHOTOGRAPHIE</p>
    <table cellpadding="3" cellspacing="0" class="centpcent">
        <tr>
            <td class="tddesignation">Photographe :</td>
            <td class="tddonnees"><?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_auteur = "SELECT personne.INDEX_PERSONNE, ETAT_CIVIL FROM personne,doc_per WHERE doc_per.INDEX_DOCUMENTATION =".$noFiche." AND personne.INDEX_PERSONNE = doc_per.INDEX_PERSONNE AND doc_per.QUALIFIANT = 'PHOTOGRAPHE' ORDER BY INDEX_DOC_PER ASC";
$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
$row_auteur = mysql_fetch_assoc($auteur);
$totalRows_auteur = mysql_num_rows($auteur);
$i = 0;
	do { 
		if ($i !=0 ) {
			echo ("<br>");
		}
	?><?php
		echo $row_auteur['ETAT_CIVIL']; ?> <?php if ($row_auteur['INDEX_PERSONNE'] != "") { ?> <a href="mc_personne.php?noFiche=<?php echo $row_auteur['INDEX_PERSONNE']; ?>" target="_blank"><img src="../images/changer_base.gif" alt="D&eacute;tails sur l'auteur" width="50" height="20" border="0" style="vertical-align:middle"></a> <?php }
		$i++;
	} while ($row_auteur = mysql_fetch_assoc($auteur)); ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Lieu de prise de vue :</td>
            <td class="tddonnees"><?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_lieu = "SELECT lieu.INDEX_LIEU, SITE FROM lieu,doc_lie WHERE doc_lie.INDEX_DOCUMENTATION =".$noFiche." AND lieu.INDEX_LIEU = doc_lie.INDEX_LIEU AND doc_lie.QUALIFIANT = 'LIEU_PRISE_VUE' ORDER BY INDEX_DOC_LIE ASC";
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
        </td>
        
        </tr>
        
        <tr>
            <td class="tddesignation">Date de Prise de Vue :</td>
            <td class="tddonnees"><?php echo $row_docum['TXT_DATE_PRISE_VUE']; ?> <?php echo reverseDate($row_docum['DEB_DATE_PRISE_VUE']); ?> et <?php echo reverseDate($row_docum['FIN_DATE_PRISE_VUE']); ?> </td>
        </tr>
        <tr>
            <td class="tddesignation">Num&eacute;ro d&#8217;inventaire du document dans le mus&eacute;e :</td>
            <td class="tddonnees"><?php echo $row_docum['NUMERO_INVENTAIRE_INTERNE']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">L&eacute;gende :</td>
            <td class="tddonnees"><?php echo $row_docum['LEGENDE']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Copyright de la photo :</td>
            <td class="tddonnees"><?php echo $row_docum['COPYRIGHT_PHOTO']; ?></td>
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
            <td class="tddonnees"><?php echo $row_docum['IDENTIFIANT_NATIONAL']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Copyright :</td>
            <td class="tddonnees"><?php echo $row_docum['COPYRIGHT']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Fiche cr&eacute;&eacute;e par :</td>
            <td class="tddonnees"><?php echo $row_docum['FICHE_CREEE_PAR']; ?> <span class="tddesignation">le : </span><?php echo reverseDate($row_docum['FICHE_CREEE_LE']); ?> </td>
        </tr>
        <tr>
            <td class="tddesignation">Mise &agrave; jour le :</td>
            <td class="tddonnees"><?php echo reverseDate($row_docum['MISE_A_JOUR']); ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Niveau de visa :</td>
            <td class="tddonnees"><?php echo $row_docum['NIVEAU_VISA']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Code mus&eacute;e: </td>
            <td class="tddonnees"><?php echo $row_docum['CODEMUSEE']; ?></td>
        </tr>
    </table>
    <?php } while ($row_docum = mysql_fetch_assoc($docum)); ?>
    <div><a name="FIN_FORMULAIRE"></a></div>
</div>
</body>
</html>
<?php
mysql_free_result($docum);
?>