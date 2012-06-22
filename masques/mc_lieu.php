<?php
	session_start();
	require_once('../config/config.php');
	$niveau_visa = $mcr;
	$page = "lieu";
	$objet = 0;
	$photo="";
	$index_documentation="";
	$identifiant="";
	include('../include/securite.php');
	include('../include/fonctions.php');
	require_once('../Connections/alienorweblibre.php');
	
(isset($_GET['noFiche'])) ? $noFiche = intval($_GET['noFiche']) : $noFiche = 0;
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_lieux = "SELECT * FROM lieu WHERE INDEX_LIEU = ".$noFiche."";
$lieux = mysql_query($query_lieux, $alienorweblibre) or die(mysql_error());
$row_lieux = mysql_fetch_assoc($lieux);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="fr">
<head>
<title>Formulaire de consultation : Lieux</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="pragma" content="no-cache">
<link href="../style/style_awl.css" rel="stylesheet" type="text/css" media="screen">
<link href="../style/style_awl_print.css" rel="stylesheet" type="text/css" media="print">
</head>
<body>
<?php include('../include/navigation.php'); ?>
<div id="haut">
    <h2>Formulaire de consultation lieux </h2>
</div>
<div id="s-menu">
    <div id="menu"><a href="#IDENTIFICATION">Identification</a> <span class="invisible">|</span> <a href="#ADRESSE">Adresse</a> <span class="invisible">|</span> <a href="#DOCUMENTATION">Documentation</a> <span class="invisible">|</span> <a href="#INFORMATIQUE">Gestion&nbsp;informatique</a></div>
</div>
<div class="spacer"> </div>
<div id="formulaireIMG">
    <div><a name="IDENTIFICATION"></a></div>
    <p class="titre">IDENTIFICATION</p>
    <?php do { ?>
    <table cellpadding="3" cellspacing="0" class="centpcent">
        <tr>
            <td class="tddesignation">Nom du lieu ou du site (identifiant) :</td>
            <td class="tddonnees"><?php echo $row_lieux['SITE']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Type de lieu ou de site :</td>
            <td class="tddonnees"><?php echo $row_lieux['TYPE_SITE']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">N&deg; de site SDA :</td>
            <td class="tddonnees"><?php echo nl2br($row_lieux['NUMERO_SDA']); ?></td>
        </tr>
        <tr>
            <td class="tddesignation">M&eacute;thode de collecte :</td>
            <td class="tddonnees"><?php echo nl2br($row_lieux['METHODE_COLLECTE']); ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Pr&eacute;cision sur le site :</td>
            <td class="tddonnees"><?php echo nl2br($row_lieux['PRECISION_SITE']); ?></td>
        </tr>
        <tr>
            <td class="tddesignation">P&eacute;riode d&#8217;activit&eacute; :</td>
            <td class="tddonnees"><?php echo $row_lieux['TXT_PERIODE_ACTIVITE']; ?> <?php echo reverseDate($row_lieux['DEB_PERIODE_ACTIVITE']); ?> et <?php echo reverseDate($row_lieux['FIN_PERIODE_ACTIVITE']); ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Commentaires :</td>
            <td class="tddonnees"><?php echo nl2br($row_lieux['COMMENTAIRES']); ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Occupant :</td>
            <td class="tddonnees"><?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_auteur = "SELECT personne.INDEX_PERSONNE, ETAT_CIVIL FROM personne,lie_per WHERE lie_per.INDEX_LIEU =".$noFiche." AND personne.INDEX_PERSONNE = lie_per.INDEX_PERSONNE AND lie_per.QUALIFIANT = 'OCCUPANT' ORDER BY INDEX_LIE_PER ASC";
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
	} while ($row_auteur = mysql_fetch_assoc($auteur)); ?> <?php echo $row_lieux['OCCUPANT_TXTDATE1']; ?> <?php echo reverseDate($row_lieux['OCCUPANT_DEBDATE1']); ?> <span class="tddesignation">et</span> <?php echo reverseDate($row_lieux['OCCUPANT_FINDATE1']); ?>
        </td>
        
        </tr>
        
    </table>
    <div><a name="ADRESSE"></a></div>
    <p class="titre">ADRESSE</p>
    <table cellpadding="3" cellspacing="0" class="centpcent">
        <tr>
            <td class="tddesignation">Adresse :</td>
            <td class="tddonnees"><?php echo nl2br($row_lieux['ADRESSE']); ?></td>
        </tr>
        <tr>
            <td class="tddesignation">T&eacute;l&eacute;phone :</td>
            <td><?php echo $row_lieux['TEL']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Fax :</td>
            <td><?php echo $row_lieux['FAX']; ?></td>
        </tr>
    </table>
    <div><a name="DOCUMENTATION"></a></div>
    <p class="titre">DOCUMENTATION</p>
    <table cellpadding="3" cellspacing="0" class="centpcent">
        <tr>
            <td class="tddonnees"><span class="tdtitre">Bibliographies :</span><br>
                <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_docum = "SELECT IDENTIFIANT, documentation.INDEX_DOCUMENTATION FROM documentation,lie_doc WHERE lie_doc.INDEX_LIEU =".$noFiche." AND documentation.INDEX_DOCUMENTATION = lie_doc.INDEX_DOCUMENTATION AND lie_doc.QUALIFIANT = 'BIBLIOGRAPHIE' ORDER BY INDEX_LIE_DOC ASC";
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
                <span class="tddesignation">N&deg; de page :</span> <?php echo $row_lieux['BIBLIOGRAPHIE_PARAM']; ?> </td>
        </tr>
        <tr>
            <td class="tddonnees"><span class="tdtitre">Photographies :</span><br>
                <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_docum = "SELECT IDENTIFIANT, documentation.INDEX_DOCUMENTATION, FICHIER FROM documentation,lie_doc WHERE lie_doc.INDEX_LIEU =".$noFiche." AND documentation.INDEX_DOCUMENTATION = lie_doc.INDEX_DOCUMENTATION AND lie_doc.QUALIFIANT = 'PHOTOGRAPHIE' ORDER BY INDEX_LIE_DOC ASC";
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
                <span class="tddesignation">Rep&eacute;rage :</span> <?php echo $row_lieux['PHOTOGRAPHIE_PARAM']; ?></td>
        </tr>
        <tr>
            <td class="tddonnees"><span class="tdtitre">Expositions :</span><br>
                <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_docum = "SELECT IDENTIFIANT, documentation.INDEX_DOCUMENTATION FROM documentation,lie_doc WHERE lie_doc.INDEX_LIEU =".$noFiche." AND documentation.INDEX_DOCUMENTATION = lie_doc.INDEX_DOCUMENTATION AND lie_doc.QUALIFIANT = 'EXPOSITION' ORDER BY INDEX_LIE_DOC ASC";
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
                <span class="tddesignation">N&deg; dans le catalogue : </span> <?php echo $row_lieux['EXPOSITION_PARAM']; ?> </td>
        </tr>
        <tr>
            <td class="tddonnees"><span class="tdtitre">Vid&eacute;os :</span><br>
                <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_docum = "SELECT IDENTIFIANT, documentation.INDEX_DOCUMENTATION FROM documentation,lie_doc WHERE lie_doc.INDEX_LIEU =".$noFiche." AND documentation.INDEX_DOCUMENTATION = lie_doc.INDEX_DOCUMENTATION AND lie_doc.QUALIFIANT = 'VIDEO' ORDER BY INDEX_LIE_DOC ASC";
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
                <span class="tddesignation">Rep&egrave;re :</span> <?php echo $row_lieux['VIDEO_PARAM']; ?> </td>
        </tr>
        <tr>
            <td class="tddonnees"><span class="tdtitre">C&eacute;d&eacute;roms : </span><br>
                <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_docum = "SELECT IDENTIFIANT, documentation.INDEX_DOCUMENTATION FROM documentation,lie_doc WHERE lie_doc.INDEX_LIEU =".$noFiche." AND documentation.INDEX_DOCUMENTATION = lie_doc.INDEX_DOCUMENTATION AND lie_doc.QUALIFIANT = 'CEDEROM' ORDER BY INDEX_LIE_DOC ASC";
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
                <span class="tddesignation">Nom du fichier :</span> <?php echo $row_lieux['CEDEROM_PARAM']; ?> </td>
        </tr>
        <tr>
            <td class="tddonnees"> <span class="tdtitre">Sites Internets :</span><br>
                <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_docum = "SELECT IDENTIFIANT, documentation.INDEX_DOCUMENTATION FROM documentation,lie_doc WHERE lie_doc.INDEX_LIEU =".$noFiche." AND documentation.INDEX_DOCUMENTATION = lie_doc.INDEX_DOCUMENTATION AND lie_doc.QUALIFIANT = 'INTERNET' ORDER BY INDEX_LIE_DOC ASC";
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
                <span class="tddesignation">Lien :</span><?php if(!empty($row_lieux['INTERNET_PARAM'])){ ?><a href="<?php echo $row_lieux['INTERNET_PARAM']; ?> " target="_blank"><?php echo $row_lieux['INTERNET_PARAM']; ?></a><?php } ?></td>
        </tr>
        <tr>
            <td class="tddonnees"><span class="tdtitre">Tapuscrits :</span><br>
                <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_docum = "SELECT IDENTIFIANT, documentation.INDEX_DOCUMENTATION FROM documentation,lie_doc WHERE lie_doc.INDEX_LIEU =".$noFiche." AND documentation.INDEX_DOCUMENTATION = lie_doc.INDEX_DOCUMENTATION AND lie_doc.QUALIFIANT = 'TAPUSCRIT' ORDER BY INDEX_LIE_DOC ASC";
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
                <span class="tddesignation">Commentaires :</span>&nbsp; <?php echo $row_lieux['TAPUSCRIT_PARAM']; ?> </td>
        </tr>
        <tr>
            <td class="tddonnees"> <span class="tdtitre">Manuscrits :</span><br>
                <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_docum = "SELECT IDENTIFIANT, documentation.INDEX_DOCUMENTATION FROM documentation,lie_doc WHERE lie_doc.INDEX_LIEU =".$noFiche." AND documentation.INDEX_DOCUMENTATION = lie_doc.INDEX_DOCUMENTATION AND lie_doc.QUALIFIANT = 'MANUSCRIT' ORDER BY INDEX_LIE_DOC ASC";
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
                <span class="tddesignation">Commentaires :</span>&nbsp; <?php echo $row_lieux['MANUSCRIT_PARAM']; ?> </td>
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
            <td class="tddonnees"><?php echo $row_lieux['IDENTIFIANT_NATIONAL']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Copyright :</td>
            <td class="tddonnees"><?php echo $row_lieux['COPYRIGHT']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Fiche cr&eacute;&eacute;e par :</td>
            <td class="tddonnees"><?php echo $row_lieux['FICHE_CREEE_PAR']; ?> <span class="tddesignation">le : </span><?php echo reverseDate($row_lieux['FICHE_CREEE_LE']); ?> </td>
        </tr>
        <tr>
            <td class="tddesignation">Mise &agrave; jour le :</td>
            <td class="tddonnees"><?php echo reverseDate($row_lieux['MISE_A_JOUR']); ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Niveau de visa :</td>
            <td class="tddonnees"><?php echo $row_lieux['NIVEAU_VISA']; ?></td>
        </tr>
        <tr>
            <td class="tddesignation">Code mus&eacute;e: </td>
            <td class="tddonnees"><?php echo $row_lieux['CODEMUSEE']; $codeMusee = $row_lieux['CODEMUSEE'];?></td>
        </tr>
    </table>
    <?php } while ($row_lieux = mysql_fetch_assoc($lieux)); ?>
    <div><a name="FIN_FORMULAIRE"></a></div>
</div>
<?php 	include('../include/bande_img.php'); ?>
</body>
</html>
<?php
mysql_free_result($lieux);
?>