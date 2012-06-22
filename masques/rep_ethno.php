<?php
	session_start();
	$niveau_visa="";
	include('../include/securite.php');
	require_once('../Connections/alienorweblibre.php');
	$isobjet = 1;
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
				if ($key == 'AUTEUR' || $key == 'UTILISATEUR' || $key == 'COLLECTEUR' || $key == 'INVENTEUR' || $key == 'PROPRIETAIRE' || $key == 'COMMISSAIRE_PRISEUR' || $key == 'GALERIE' || $key == 'DEPOSITAIRE' || $key == 'ATTRIBUTION' || $key == 'ATTRIBUTEUR' || $key == 'SERVICE_GESTIONNAIRE' || $key == 'ANCIENNE_APPARTENANCE' || $key == 'SERVICE_GESTIONNAIRE' || $key == 'ANCIEN_DEPOSITAIRE' || $key == 'DESCRIPTEUR') {
					mysql_select_db($database_alienorweblibre, $alienorweblibre);
					$query_auteur = "SELECT obj_per.INDEX_OBJET FROM personne,obj_per WHERE obj_per.INDEX_PERSONNE = personne.INDEX_PERSONNE AND personne.ETAT_CIVIL LIKE '".$val."' AND obj_per.QUALIFIANT = '".$key."' ORDER BY INDEX_OBJ_PER ASC";
					// echo("query_auteur =".$query_auteur."<br>");
					$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
					$row_auteur = mysql_fetch_assoc($auteur);
							do {
								$noindex = $row_auteur['INDEX_OBJET'];
								if ($premier) {
										$requete = $requete." INDEX_OBJET = '".$noindex."' " ;
										$premier = false;
									}else{
										$requete = $requete." ".$operateur." INDEX_OBJET = '".$noindex."' ";
									}
							} while ($row_auteur = mysql_fetch_assoc($auteur));	
				} else {
					// traitement des champs lieux
					if ($key == 'LIEUX_EXECUTION' || $key == 'LIEUX_UTILISATION' || $key == 'LIEUX_DECOUVERTE') {
						mysql_select_db($database_alienorweblibre, $alienorweblibre);
						$query_auteur = "SELECT obj_lie.INDEX_OBJET FROM lieu,obj_lie WHERE obj_lie.INDEX_LIEU = lieu.INDEX_LIEU AND lieu.SITE LIKE '".$val."' AND obj_lie.QUALIFIANT = '".$key."' ORDER BY INDEX_OBJ_LIE ASC";
						// echo("query_auteur =".$query_auteur."<br>");
						$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
						$row_auteur = mysql_fetch_assoc($auteur);
							do {
								$noindex = $row_auteur['INDEX_OBJET'];
								if ($premier) {
										$requete = $requete." INDEX_OBJET = '".$noindex."' " ;
										$premier = false;
									}else{
										$requete = $requete." ".$operateur." INDEX_OBJET = '".$noindex."' ";
									}
							} while ($row_auteur = mysql_fetch_assoc($auteur));	
							//echo "<br>".$requete;						
						
					} else {
					// traitement des champs objets
					($premier) ? $requete = $requete." ".$key." LIKE '".$val."'" : $requete = $requete." ".$operateur." ".$key." LIKE '".$val."' ";
					$premier = false;
					}
				}
			}
		}	
	}
}

/* Requète */
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_objet = "SELECT INDEX_OBJET, DENOMINATION, NUMERO_INVENTAIRE, LOCALISATION FROM objet ";
if ($vide == 0) {
	$query_objet .= $requete." ORDER BY INDEX_OBJET ASC";
}
//echo ('Requête = '.$query_objet.'<br>');
$objet = mysql_query($query_objet, $alienorweblibre) or die(mysql_error());
$row_objet = mysql_fetch_assoc($objet);
$totalRows_objet = mysql_num_rows($objet);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="fr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Formulaire de r&eacute;ponse objet</title>
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
<h2>R&eacute;sultat d'une recherche avec le masque Ethnologie </h2>
</div>
<?php if ($totalRows_objet == 0) { ?>
<p class="centre"><b>Il n'y a pas de r&eacute;ponse &agrave; votre requ&ecirc;te</b></p>
<p class="centre"><b><?php echo $msg?></b></p>
<p class="centre"><b><a href="javascript:window.history.go(-1);">Retour</a></b></p>
<?php } else { ?>
<form name="coche" action="rep_ethno.php">
    <input type="button" name="allcase"  value="Cocher tout" onClick="this.value=check(document.Selection.sel)">
</form>
<div align="center">
    <form name="Selection" action="rep_ethno.php">
        <table width="90%" style="border: 1px solid #666666" cellpadding="3">
            <tr>
                <th scope="col" width="4%" valign="middle">&nbsp;</th>
                <th scope="col" width="4%" valign="middle">&nbsp;</th>
                <th scope="col" width="23%">Num&eacute;ro inventaire</th>
                <th scope="col" width="23%">D&eacute;nomination</th>
                <th scope="col" width="23%">Collecteur</th>
                <th scope="col" width="23%">Lieu de Collecte </th>
                <th scope="col" width="23%">Auteur</th>
                <th scope="col" width="23%">Localisation</th>
            </tr>
            <?php
		$c = 0;
		do { 
			($c%2) ? $color = "L1" :  $color = "L2";
			$c++;
		?>
                <tr>
                    <td align="center" valign="middle" class="<?php echo $color; ?>"><input type="checkbox" name="sel" value="<?php echo $row_objet['INDEX_OBJET']; ?>"></td>
                    <td align="center" valign="middle" class="<?php echo $color; ?>"><a href="../masques/mc_<?php echo $page ?>.php?noFiche=<?php echo $row_objet['INDEX_OBJET']; ?>&amp;page=<?php echo $page ?>" target="_blank"><img src="../images/notice.gif" alt="Voir la fiche num&eacute;ro <?php echo $row_objet['INDEX_OBJET']; ?>" width="13" height="16"></a></td>
                    <td class="<?php echo $color; ?>"><?php echo htmlentities($row_objet['NUMERO_INVENTAIRE']); ?></td>
                    <td class="<?php echo $color; ?>"><?php echo $row_objet['DENOMINATION']; ?></td>
                    <td class="<?php echo $color; ?>"><?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_collecteur = "SELECT ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET =".intval($row_objet['INDEX_OBJET'])." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'COLLECTEUR' ORDER BY INDEX_OBJ_PER ASC";
$collecteur = mysql_query($query_collecteur, $alienorweblibre) or die(mysql_error());
$row_collecteur = mysql_fetch_assoc($collecteur);
$totalRows_collecteur = mysql_num_rows($collecteur);
$i = 0 ;
	do {
		if ($i !=0 ) {
		echo "/";
		}
		echo $row_collecteur['ETAT_CIVIL'];
		$i++;
		} while ($row_collecteur = mysql_fetch_assoc($collecteur)); ?>					</td>
                    <td class="<?php echo $color; ?>">
					<?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_site = "SELECT SITE FROM lieu,obj_lie WHERE obj_lie.INDEX_OBJET =".intval($row_objet['INDEX_OBJET'])." AND lieu.INDEX_LIEU = obj_lie.INDEX_LIEU AND obj_lie.QUALIFIANT = 'LIEUX_DECOUVERTE' ORDER BY INDEX_OBJ_LIE ASC";
$site = mysql_query($query_site, $alienorweblibre) or die(mysql_error());
$row_site = mysql_fetch_assoc($site);
$totalRows_site = mysql_num_rows($site);
$i = 0 ;
	do {
		if ($i !=0 ) {
		echo "/";
		}
		echo $row_site['SITE'];
		$i++;
		} while ($row_site = mysql_fetch_assoc($site)); ?>
					</td>
                    <td class="<?php echo $color; ?>"><?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_auteur = "SELECT ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET =".intval($row_objet['INDEX_OBJET'])." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'AUTEUR' ORDER BY INDEX_OBJ_PER ASC";
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
                    <td class="<?php echo $color; ?>"><?php echo $row_objet['LOCALISATION']; ?></td>
                </tr>
                <?php } while ($row_objet = mysql_fetch_assoc($objet)); ?>
        </table>
    </form>
</div>
<?php } ?>
</body>
</html>
<?php
mysql_free_result($objet);
?>