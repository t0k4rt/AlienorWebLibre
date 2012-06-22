<?php
	session_start();
	require_once('../config/config.php');
	$niveau_visa = $mcr;
	include('../include/securite.php');
	$page = "gestion";
	$objet = 0;
	include('../include/fonctions.php');
	require_once('../Connections/alienorweblibre.php');
	
(isset($_GET['noFiche'])) ? $noFiche = intval($_GET['noFiche']) : $noFiche = 0 ;
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_gestion = "SELECT * FROM gestion WHERE INDEX_GESTION = ".$noFiche."";
$gestion = mysql_query($query_gestion, $alienorweblibre) or die(mysql_error());
$row_gestion = mysql_fetch_assoc($gestion);
/* recherche de l'entet de lobjet */
$query_objet = "SELECT DENOMINATION, TITRE, APPELLATION, TAXONOMIE, NUMERO_INVENTAIRE, obj_ges.INDEX_OBJET FROM objet, obj_ges WHERE obj_ges.INDEX_GESTION=".$noFiche." AND obj_ges.INDEX_OBJET = objet.INDEX_OBJET";
$objet = mysql_query($query_objet, $alienorweblibre) or die(mysql_error());
$row_objet = mysql_fetch_assoc($objet);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="fr">
<head>
<title>Alienor Web : Mise &agrave; jour Gestion</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="pragma" content="no-cache">
<link href="../style/style_awl.css" rel="stylesheet" type="text/css" media="screen">
<link href="../style/style_awl_print.css" rel="stylesheet" type="text/css" media="print">
</head>
<body>
<?php include('../include/navigation.php'); ?>
<div id="haut">
    <h2>Formulaire de consultation Gestion </h2>
</div>
<div id="objet">
	<table align="center" cellpadding="3" cellspacing="0" class="centpcent">
		<tr>
			<td colspan="3" class="tdtitre"> Objet </td>
		</tr>
		<tr>
			 <td class="tddesignation">Num&eacute;ro d'inventaire :</td>
			 <td class="tddonnees"><?php echo $row_objet['NUMERO_INVENTAIRE']; ?></td>
		     <td rowspan="5" align="center" valign="middle" class="tddonnees">&nbsp;</td>
		</tr>
		<tr>
			 <td class="tddesignation">Titre :</td>
			 <td class="tddonnees"><?php echo $row_objet['TITRE']; ?></td>
        </tr>
		<tr>
			 <td class="tddesignation">D&eacute;nomination :</td>
			 <td class="tddonnees"><?php echo $row_objet['DENOMINATION']; ?></td>
        </tr>
		<tr>
			 <td class="tddesignation">Appellation :</td>
			 <td class="tddonnees"><?php echo $row_objet['APPELLATION']; ?></td>
        </tr>
		<tr>
			 <td class="tddesignation">Taxonomie :</td>
			 <td class="tddonnees"><?php echo $row_objet['TAXONOMIE']; ?></td>
        </tr>
	</table>
</div>
<div class="spacer"> </div>
<div id="formulaire"> <?php do { 
		if ( $row_gestion['VALEUR'] != ""){?>
        <p class="titre">VALORISATION</p>
        <table cellpadding="3" cellspacing="0" class="centpcent">
            <tr>
                <td class="tddesignation">Valeur :</td>
                <td class="tddonnees"><?php echo $row_gestion['VALEUR']; ?></td>
            </tr>
            <tr>
                <td class="tddesignation">Expertis&eacute;(e) par :</td>
                <td class="tddonnees"><?php echo $row_gestion['EXPERT']; ?></td>
            </tr>
            <tr>
                <td class="tddesignation">Date :</td>
                <td class="tddonnees"><?php echo reverseDate($row_gestion['DATE_VALEUR']); ?></td>
            </tr>
            <tr>
              <td class="tddesignation">Commentaires :</td>
              <td class="tddonnees"><?php echo reverseDate($row_gestion['COMMENTAIRES']); ?></td>
            </tr>
        </table>
    <?php }
	if ( $row_gestion['EMPLACEMENT'] != ""){?>
    <p class="titre">EMPLACEMENT</p>
        <table cellpadding="3" cellspacing="0" class="centpcent">
            <tr>
                <td class="tddesignation">Emplacement : </td>
                <td class="tddonnees"><?php echo $row_gestion['EMPLACEMENT']; ?></td>
            </tr>
            <tr>
                <td class="tddesignation">Date :</td>
                <td class="tddonnees"><?php echo reverseDate($row_gestion['DATE_EMPLACEMENT']); ?></td>
            </tr>
            <tr>
              <td class="tddesignation">Commentaires :</td>
              <td class="tddonnees"><?php echo reverseDate($row_gestion['COMMENTAIRES']); ?></td>
            </tr>
        </table>
    <?php }
	if ( $row_gestion['ETAT_CONSERVATION'] != ""){?>
    <p class="titre">&Eacute;TAT DE CONSERVATION</p>
        <table cellpadding="3" cellspacing="0" class="centpcent">
            <tr>
                <td class="tddesignation">&Eacute;tat</td>
                <td class="tddonnees"><?php echo $row_gestion['ETAT_CONSERVATION']; ?></td>
            </tr>
            <tr>
                <td class="tddesignation">Date :</td>
                <td class="tddonnees"><?php echo reverseDate($row_gestion['DATE_CONSERVATION']); ?></td>
            </tr>
            <tr>
              <td class="tddesignation">Commentaires :</td>
              <td class="tddonnees"><?php echo reverseDate($row_gestion['COMMENTAIRES']); ?></td>
            </tr>
        </table>
        <?php } ?>
    <div><a name="INFORMATIQUE"></a></div>
        <p class="titre">GESTION INFORMATIQUE</p>
        <table cellpadding="3" cellspacing="0" class="centpcent">
            <tr>
                <td class="tddesignation">Num&eacute;ro de fiche :</td>
                <td class="tddonnees"><?php echo $noFiche; ?></td>
            </tr>
            <tr>
                <td class="tddesignation">Identifiant national :</td>
                <td class="tddonnees"><?php echo $row_gestion['IDENTIFIANT_NATIONAL']; ?></td>
            </tr>
            <tr>
                <td class="tddesignation">Copyright :</td>
                <td class="tddonnees"><?php echo $row_gestion['COPYRIGHT']; ?></td>
            </tr>
            <tr>
                <td class="tddesignation">Fiche cr&eacute;&eacute;e par :</td>
                <td class="tddonnees"><?php echo $row_gestion['FICHE_CREEE_PAR']; ?> <span class="tddesignation">le : </span><?php echo reverseDate($row_gestion['FICHE_CREEE_LE']); ?> </td>
            </tr>
            <tr>
                <td class="tddesignation">Code mus&eacute;e: </td>
                <td class="tddonnees"><?php echo $row_gestion['CODEMUSEE']; ?></td>
            </tr>
        </table>
        <?php } while ($row_gestion = mysql_fetch_assoc($gestion)); ?>
		<a name="FIN_FORMULAIRE"></a></div>
</body>
</html>
<?php mysql_free_result($gestion); ?>