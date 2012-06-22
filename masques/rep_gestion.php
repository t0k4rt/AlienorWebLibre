<?php
	session_start();
	require_once('../config/config.php');
	$niveau_visa=$mcr;
	require_once('../include/securite.php');
	require_once('../Connections/alienorweblibre.php');
	$msg = "";
	$vide = "1";
	
/* Récupération des noms des champs et des valeurs passer par la méthode post */
if(isset($_POST)) {
	// si pas de paramètres, pas de contrainte dans la requête
	(!empty($_POST)) ? $requete = " WHERE " : $requete = "";
	isset($_POST['page']) ? $page = $_POST['page'] : $page = "";
	$premier = true;
	$operateur = "OR";
	$valEmplacement="";
	$valValeur="";
	$valEtat="";

	foreach($_POST as $key=>$val) {
		// echo $key." => ".$val."  => Vide = ".$vide."<br>"."\n";
		if ($val != "" && $val != "--" && $key != 'valider_x' && $key != 'valider_y' && $key != 'operateur' && $key!= 'page') {
		
			// Séparation des valeurs
			$tableau = explode("/",$val);
			$vide = 0;			
			for ($i = 0; $i < count($tableau); $i++) {
				$val = str_replace("*","%",$tableau[$i]);
			$val = addslashes($val);	
				($premier) ? $requete = $requete." ".$key." LIKE '".$val."' " : $requete = $requete." ".$operateur." ".$key." LIKE '".$val."' ";
				switch($key){
					case 'EMPLACEMENT' :
						($valEmplacement=="") ? $valEmplacement = $val : $valEmplacement = $valEmplacement." / ".$val;
						break;
					case 'VALEUR' :
						($valValeur=="") ? $valValeur = $val : $valValeur = $valValeur." / ".$val;
						break;
					case 'ETAT_CONSERVATION' :
						($valEtat=="") ? $valEtat = $val : $valEtat = $valEtat." / ".$val;
						break;
				}
				$premier = false;
			}
		}
	}
	/* Requète Gestion */
	mysql_select_db($database_alienorweblibre, $alienorweblibre);
	$query_gestion = "SELECT INDEX_GESTION FROM gestion ";
	if ($vide == 0) {
		$query_gestion .= $requete." ORDER BY INDEX_GESTION ASC";
	}
	 //echo ('Requête = '.$query_gestion.'<br>');
	$gestion = mysql_query($query_gestion, $alienorweblibre) or die(mysql_error());
	$row_gestion = mysql_fetch_assoc($gestion);
	$totalRows_gestion = mysql_num_rows($gestion);
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="fr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Formulaire de r&eacute;ponse : Gestion</title>
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
<h2>R&eacute;sultat d'une recherche avec le masque gestion</h2>
</div>

<?php if ($totalRows_gestion == 0) { ?>
<p class="centre"><b>Il n'y a pas de r&eacute;ponse &agrave; votre requ&ecirc;te</b></p>
<p class="centre"><b><?php echo $msg?></b></p>
<p class="centre"><b><a href="javascript:window.history.go(-1);">Retour</a></b></p>
<?php } else { ?>
<form name="coche" action="rep_gestion.php">
    <input type="button" name="allcase"  value="Cocher tout" onClick="this.value=check(document.Selection.selCheck)">
</form>
<div align="center">
	<?php if ($valEmplacement != "") { ?>
		<p><strong>Recherche des objets présent dans les emplacements suivant : <?php echo $valEmplacement; ?></strong></p><br>
	<?php } if ($valValeur != "") { ?>
		<p><strong>Recherche des objets ayant les valeurs suivantes : <?php echo $valValeur; ?></strong></p><br>
	<?php } if ($valEtat != "") { ?>
		<p><strong>Recherche des objets ayant l'état suivant : <?php echo $valEtat; ?></strong></p><br>
	<?php } ?>
	<form name="Selection" action="rep_gestion.php">
        <table width="90%" style="border: 1px solid #666666" cellpadding="3">
            <tr>
                <th scope="col" width="4%" valign="middle">&nbsp;</th>
                <th scope="col" width="4%" valign="middle">&nbsp;</th>
                <th scope="col" width="23%">N&deg; d'inventaire</th>
                <th scope="col" width="23%">D&eacute;nomination</th>
                <th scope="col" width="23%">Titre</th>
            </tr>
            <?php
			$c = 0;
			do { 
				($c%2) ? $color = "L1" :  $color = "L2";
				$c++;
			?>
                <tr>
                    <td align="center" valign="middle" class="<?php echo $color; ?>">
                        <input name="selCheck" type="checkbox" value="<?php echo $row_gestion['INDEX_GESTION']; ?>">
                    </td>
                    <td align="center" valign="middle" class="<?php echo $color; ?>"><a href="../masques/mc_<?php echo $page?>.php?noFiche=<?php echo $row_gestion['INDEX_GESTION'] ?>&amp;page=<?php echo $page?>" target="_blank"><img src="../images/notice.gif" alt="Voir la fiche num&eacute;ro <?php echo $row_gestion['INDEX_GESTION']; ?>" width="13" height="16"></a></td>
                    <td class="<?php echo $color; ?>"><?php mysql_select_db($database_alienorweblibre, $alienorweblibre);
						$query_objet = "SELECT NUMERO_INVENTAIRE FROM objet,obj_ges WHERE obj_ges.INDEX_GESTION = ".$row_gestion['INDEX_GESTION']." AND objet.INDEX_OBJET = obj_ges.INDEX_OBJET";
						//echo ("Requête = ".$query_objet);
						$objet = mysql_query($query_objet, $alienorweblibre) or die(mysql_error());
						$row_objet = mysql_fetch_assoc($objet);
						$totalRows_objet = mysql_num_rows($objet);
						do {
							echo $row_objet['NUMERO_INVENTAIRE'];
						} while ($row_objet = mysql_fetch_assoc($objet)); ?></td>
                    <td class="<?php echo $color; ?>"><?php
						mysql_select_db($database_alienorweblibre, $alienorweblibre);
						$query_objet = "SELECT DENOMINATION FROM objet,obj_ges WHERE obj_ges.INDEX_GESTION = ".$row_gestion['INDEX_GESTION']." AND objet.INDEX_OBJET = obj_ges.INDEX_OBJET";
						//echo ("Requête = ".$query_objet);
						$objet = mysql_query($query_objet, $alienorweblibre) or die(mysql_error());
						$row_objet = mysql_fetch_assoc($objet);
						$totalRows_objet = mysql_num_rows($objet);
						do {
							echo $row_objet['DENOMINATION'];
						} while ($row_objet = mysql_fetch_assoc($objet)); ?></td>
					<td class="<?php echo $color; ?>"><?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_objet = "SELECT TITRE FROM objet,obj_ges WHERE obj_ges.INDEX_GESTION = ".$row_gestion['INDEX_GESTION']." AND objet.INDEX_OBJET = obj_ges.INDEX_OBJET";
//echo ("Requête = ".$query_objet);
$objet = mysql_query($query_objet, $alienorweblibre) or die(mysql_error());
$row_objet = mysql_fetch_assoc($objet);
$totalRows_objet = mysql_num_rows($objet);
do {
	echo $row_objet['TITRE'];
} while ($row_objet = mysql_fetch_assoc($objet)); ?></td>
                </tr>
                <?php } while ($row_gestion = mysql_fetch_assoc($gestion)); ?>
        </table>
    </form>
</div>
<?php } ?>
</body>
</html>
<?php
mysql_free_result($gestion);
?>