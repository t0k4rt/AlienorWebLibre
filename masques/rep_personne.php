<?php
	session_start();
	require_once("../config/config.php");
	$niveau_visa=$mcr;
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
				// traitement des champs lieux
				if ($key == 'LIEU_NAISSANCE' || $key == 'LIEU_DECES' || $key == 'LIEU_TRAVAIL' || $key == 'LIEU_RESIDENCE' || $key == 'GALERIE') {
					mysql_select_db($database_alienorweblibre, $alienorweblibre);
					$query_auteur = "SELECT per_lie.INDEX_PERSONNE FROM lieu,per_lie WHERE per_lie.INDEX_LIEU = lieu.INDEX_LIEU AND lieu.SITE LIKE '".$val."' AND per_lie.QUALIFIANT = '".$key."' ORDER BY INDEX_PER_LIE ASC";
					// echo("$query_auteur =".$query_auteur."<br>");
					$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
					$row_auteur = mysql_fetch_assoc($auteur);
						do {
							$noindex = $row_auteur['INDEX_PERSONNE'];
							if ($premier)
							{
								$requete = $requete." INDEX_PERSONNE = '".$noindex."' ";
								$premier = false;
							}
							else
							{
							 	$requete = $requete." ".$operateur." INDEX_PERSONNE ='".$noindex."' ";
							}
						} while ($row_auteur = mysql_fetch_assoc($auteur));					
					
					
				} else {
				// traitement des champs objets
				($premier) ? $requete = $requete." ".$key." LIKE '".$val."' " : $requete = $requete." ".$operateur." ".$key." LIKE '".$val."' ";
				$premier = false;
				}
			}
		}	
	}
}

/* Requète */
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_personne = "SELECT INDEX_PERSONNE, ETAT_CIVIL, NOM_MARITAL, GENRE FROM personne ";
if ($vide == 0) {
	$query_personne .= $requete." ORDER BY INDEX_PERSONNE ASC";
}
/* echo ('Requête = '.$query_personne.'<br>'); */
$personne = mysql_query($query_personne, $alienorweblibre) or die(mysql_error());
$row_personne = mysql_fetch_assoc($personne);
$totalRows_personne = mysql_num_rows($personne);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="fr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Formulaire de r&eacute;ponse : Personne</title>
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
<h2>R&eacute;sultat d'une recherche avec le masque personne</h2>
</div>
<?php if ($totalRows_personne == 0) { ?>
<p class="centre"><b>Il n'y a pas de r&eacute;ponse &agrave; votre requ&ecirc;te</b></p>
<p class="centre"><b><?php echo $msg ?></b></p>
<p class="centre"><b><a href="javascript:window.history.go(-1);">Retour</a></b></p>
<?php } else { ?>
<form name="coche" action="rep_personne.php">
    <input type="button" name="allcase"  value="Cocher tout" onClick="this.value=check(document.Selection.selCheck)">
</form>
<div align="center">
    <form name="Selection" action="rep_personne.php">
        <table width="90%" style="border: 1px solid #666666" cellpadding="3">
            <tr>
                <th scope="col" width="4%" valign="middle">&nbsp;</th>
                <th scope="col" width="4%" valign="middle">&nbsp;</th>
                <th scope="col" width="23%">&Eacute;tat civil </th>
                <th scope="col" width="23%">Nom marital </th>
                <th scope="col" width="23%">Genre</th>
            </tr>
            <?php
		$c = 0;
		do { 
			($c%2) ? $color = "L1" :  $color = "L2";
			$c++;
		?>
                <tr>
                    <td align="center" valign="middle" class="<?php echo $color; ?>">
                        <input name="selCheck" type="checkbox" value="<?php echo $row_personne['INDEX_PERSONNE']; ?>">
                    </td>
                    <td align="center" valign="middle" class="<?php echo $color; ?>"><a href="../masques/mc_<?php echo $page ?>.php?noFiche=<?php echo $row_personne['INDEX_PERSONNE'] ?>&amp;page=<?php echo $page?>" target="_blank"><img src="../images/notice.gif" alt="Voir la fiche num&eacute;ro <?php echo $row_personne['INDEX_PERSONNE'] ?>" width="13" height="16"></a></td>
                    <td class="<?php echo $color; ?>"><?php echo $row_personne['ETAT_CIVIL'] ?></td>
                    <td class="<?php echo $color; ?>"><?php echo $row_personne['NOM_MARITAL'] ?></td>
                    <td class="<?php echo $color; ?>"><?php echo $row_personne['GENRE'] ?></td>
                </tr>
                <?php } while ($row_personne = mysql_fetch_assoc($personne)); ?>
        </table>
    </form>
</div>
<?php } ?>
</body>
</html>
<?php
mysql_free_result($personne);
?>