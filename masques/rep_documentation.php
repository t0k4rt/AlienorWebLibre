<?php
session_start();
	require_once('../config/config.php');
$niveau_visa = $mcr;
require_once('../include/securite.php');
require_once('../Connections/alienorweblibre.php');
$msg = "";
$vide = "1";
/* Récupération des noms des champs et des valeurs passer par la méthode post */
if(isset($_POST)) {
	
	// si pas de paramètres, pas de contrainte dans la requête
	(!empty($_POST)) ? $requete = " WHERE " : $requete = "";
	$page = $_POST['page'];
	$premier = true;
	$operateur = "OR";
	
	foreach($_POST as $key=>$val) {
		//echo $key." => ".$val."  => Vide = ".$vide."<br>"."\n";
		if ($val != "" && $val != "--" && $key != 'valider_x' && $key != 'valider_y' && $key != 'operateur' && $key!= 'page') {
		
		// Séparation des valeurs
		$tableau = explode("/",$val);
		$vide = 0;
		for ($i=0; $i < count($tableau); $i++) {
			$val = str_replace("*","%",$tableau[$i]);
			$val = addslashes($val);	
			// traitement des champs personnes
				if ($key == 'AUTEUR' || $key == 'EDITEUR' || $key == 'PHOTOGRAPHE' || $key == 'WEBMESTRE') {
					mysql_select_db($database_alienorweblibre, $alienorweblibre);
					$query_auteur = "SELECT doc_per.INDEX_DOCUMENTATION FROM personne,doc_per WHERE doc_per.INDEX_PERSONNE = personne.INDEX_PERSONNE AND personne.ETAT_CIVIL LIKE '".$val."' AND doc_per.QUALIFIANT = '".$key."' ORDER BY INDEX_DOC_PER ASC";
					// echo("$query_auteur =".$query_auteur."<br>");
					$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
					$row_auteur = mysql_fetch_assoc($auteur);
						do {
							$noindex = $row_auteur['INDEX_DOCUMENTATION'];
							if($premier){
								$requete = $requete." INDEX_DOCUMENTATION = '".$noindex."' ";
								$premier = false;
							}else{	
								$requete = $requete." ".$operateur." INDEX_DOCUMENTATION = '".$noindex."' ";
							}
						} while ($row_auteur = mysql_fetch_assoc($auteur));					
					
				} else {
					// traitement des champs lieux
					if ($key == 'LIEU_EDITION' || $key == 'LIEU_PRISE_VUE') {
						mysql_select_db($database_alienorweblibre, $alienorweblibre);
						$query_auteur = "SELECT doc_lie.INDEX_DOCUMENTATION FROM lieu,doc_lie WHERE doc_lie.INDEX_LIEU = lieu.INDEX_LIEU AND lieu.SITE LIKE '".$val."' AND doc_lie.QUALIFIANT = '".$key."' ORDER BY INDEX_DOC_LIE ASC";
						// echo("$query_auteur =".$query_auteur."<br>");
						$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
						$row_auteur = mysql_fetch_assoc($auteur);
							do {
								$noindex = $row_auteur['INDEX_DOCUMENTATION'];
								if ($premier){
									$requete = $requete." INDEX_DOCUMENTATION = '".$noindex."' " ;
									$premier = false;
								}else{
									$requete = $requete." ".$operateur." INDEX_DOCUMENTATION ='".$noindex."' ";
								}
							} while ($row_auteur = mysql_fetch_assoc($auteur));					
					} else {
					// traitement des champs docums
					($premier) ? $requete = $requete." ".$key." LIKE '".$val."' " : $requete = $requete." ".$operateur." ".$key." LIKE '".$val."' ";
					$premier = false;
					}
				}
			}
		}	
	}
}

/* Requète */
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_docum = "SELECT INDEX_DOCUMENTATION, IDENTIFIANT, TITRE_ENSEMBLE, LEGENDE FROM documentation ";
if ($vide == 0) {
	$query_docum .= $requete." ORDER BY INDEX_DOCUMENTATION ASC";
}
/* echo ('Requête = '.$query_docum.'<br>'); */
$docum = mysql_query($query_docum, $alienorweblibre) or die(mysql_error());
$row_docum = mysql_fetch_assoc($docum);
$totalRows_docum = mysql_num_rows($docum);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="fr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Formulaire de r&eacute;ponse : Documentation</title>
<script language="javascript" type="text/javascript">
<!--
var checkflag = "false";
function check(field) {
	if (checkflag == "false") {
		for (i = 0; i < field.length; i++) {
			field[i].checked = true;
		}
		checkflag = "true";
		return "Décocher tout";
	} else {
		for (i = 0; i < field.length; i++) {
			field[i].checked = false; 
		}
		checkflag = "false";
		return "Cocher tout";
	}
}
//-->
</script>
<link href="../style/style_awl.css" rel="stylesheet" type="text/css" media="screen">
<link href="../style/style_awl_print.css" rel="stylesheet" type="text/css" media="print">
<style type="text/css">
<!--
th {
	background-color: #D8D8D8;
	text-align: center;
	font-weight: bold;
}
.L1 {
	background-color: #FAFAFA;
}
.L2 {
	background-color: #F3F3F3;
}
img {
	border: none;
}
-->
</style>
</head>
<body>
<?php
 include('../include/navigation.php');
?>
<div id="haut">
<h2>R&eacute;sultat d'une recherche avec le masque documentation</h2>
</div>

<?php if ($totalRows_docum == 0) { ?>
<br>
<p class="centre"><b>Il n'y a pas de r&eacute;ponse &agrave; votre requ&ecirc;te</b></p>
<p class="centre"><b><?php echo $msg?></b></p>
<p class="centre"><b><a href="javascript:window.history.go(-1);">Retour</a></b></p>
<?php } else { ?>
<form name="coche" action="rep_documentation.php">
    <input type="button" name="allcase"  value="Cocher tout" onClick="this.value=check(document.Selection.selCheck)">
</form>
<div align="center">
    <form name="Selection" action="rep_documentation.php">
        <table width="90%" style="border: 1px solid #666666" cellpadding="3">
            <tr>
                <th scope="col" width="4%" valign="middle">&nbsp;</th>
                <th scope="col" width="4%" valign="middle">&nbsp;</th>
                <th scope="col" width="23%">Identifiant</th>
                <th scope="col" width="23%">Titre</th>
                <th scope="col" width="23%">Auteur</th>
                <th scope="col" width="23%">L&eacute;gende</th>
            </tr>
            <?php
		$c = 0;
		do { 
			($c%2) ? $color = "L1" :  $color = "L2";
			$c++;
		?>
                <tr>
                    <td align="center" valign="middle" class="<?php echo $color; ?>">
                        <input name="selCheck" type="checkbox" value="<?php echo $row_docum['INDEX_DOCUMENTATION']; ?>">
                    </td>
                    <td align="center" valign="middle" class="<?php echo $color; ?>"><a href="../masques/mc_<?php echo $page?>.php?noFiche=<?php echo $row_docum['INDEX_DOCUMENTATION']; ?>&amp;page=<?php echo $page?>" target="_blank"><img src="../images/notice.gif" alt="Voir la fiche num&eacute;ro <?php echo $row_docum['INDEX_DOCUMENTATION']; ?>" width="13" height="16"></a></td>
                    <td class="<?php echo $color; ?>"><?php echo $row_docum['IDENTIFIANT']; ?></td>
                    <td class="<?php echo $color; ?>"><?php echo $row_docum['TITRE_ENSEMBLE']; ?></td>
                    <td class="<?php echo $color; ?>"><?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_auteur = "SELECT ETAT_CIVIL FROM personne,doc_per WHERE doc_per.INDEX_DOCUMENTATION =".intval($row_docum['INDEX_DOCUMENTATION'])." AND personne.INDEX_PERSONNE = doc_per.INDEX_PERSONNE AND doc_per.QUALIFIANT = 'AUTEUR' ORDER BY INDEX_DOC_PER ASC";
$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
$row_auteur = mysql_fetch_assoc($auteur);
$totalRows_auteur = mysql_num_rows($auteur);
$i = 0 ;
	do {
		if ($i !=0 ) {
		echo "/";
		}
		echo $row_auteur['ETAT_CIVIL'];
		$i++;
		} while ($row_auteur = mysql_fetch_assoc($auteur)); ?></td>
                    <td class="<?php echo $color; ?>"><?php echo $row_docum['LEGENDE']; ?></td>
                </tr>
                <?php } while ($row_docum = mysql_fetch_assoc($docum)); ?>
        </table>
    </form>
</div>
<?php } ?>
</body>
</html>
<?php
mysql_free_result($docum);
?>