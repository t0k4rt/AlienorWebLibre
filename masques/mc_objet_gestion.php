<?php
	session_start();
$niveau_visa="";
require_once('../Connections/alienorweblibre.php');
include('../include/securite.php');
include('../include/fonctions.php');
$msg = "";
$page = "gestion";
$objet = 0;
/* Récupération des noms des champs et des valeurs passer par la méthode post */
if(isset($_POST['INDEX_OBJET']) && !empty($_POST['INDEX_OBJET'])) {
	$no_fiche_objet = $_POST['INDEX_OBJET'];
}else{
	$no_fiche_objet = $_GET['INDEX_OBJET'];
}
	//echo "<br> no fiche objet";
	//echo $no_fiche_objet;
		$requete = " WHERE obj_ges.INDEX_OBJET = ".$no_fiche_objet;
		$requete = $requete." AND obj_ges.INDEX_GESTION = gestion.INDEX_GESTION";
	/* Requète Gestion */
	mysql_select_db($database_alienorweblibre, $alienorweblibre);
		$query_emplacement = "SELECT obj_ges.INDEX_GESTION,gestion.INDEX_GESTION,gestion.EMPLACEMENT,gestion.EXPERT,gestion.DATE_EMPLACEMENT FROM gestion, obj_ges WHERE obj_ges.INDEX_OBJET = '".$no_fiche_objet ."' AND obj_ges.INDEX_GESTION = gestion.INDEX_GESTION AND gestion.EMPLACEMENT IS NOT NULL ORDER BY gestion.FICHE_CREEE_LE ASC";
		$query_valeur = "SELECT gestion.INDEX_GESTION,gestion.VALEUR,gestion.EXPERT,gestion.DATE_VALEUR FROM gestion, obj_ges WHERE obj_ges.INDEX_OBJET = '".$no_fiche_objet ."' AND obj_ges.INDEX_GESTION = gestion.INDEX_GESTION AND gestion.VALEUR IS NOT NULL ORDER BY DATE_VALEUR ASC";
		$query_etat = "SELECT gestion.INDEX_GESTION,gestion.ETAT_CONSERVATION,gestion.EXPERT,gestion.DATE_CONSERVATION FROM gestion, obj_ges WHERE obj_ges.INDEX_OBJET = '".$no_fiche_objet ."' AND obj_ges.INDEX_GESTION = gestion.INDEX_GESTION AND gestion.ETAT_CONSERVATION IS NOT NULL ORDER BY DATE_CONSERVATION ASC";
	//echo ('<br>Requête emplacement= '.$query_emplacement.'<br>');
	$emplacement = mysql_query($query_emplacement, $alienorweblibre) or die(mysql_error());
	$row_emplacement = mysql_fetch_assoc($emplacement);
	$totalRows_emplacement = mysql_num_rows($emplacement);
	//echo ('<br>Requête valeur= '.$query_valeur.'<br>');
	$valeur = mysql_query($query_valeur, $alienorweblibre) or die(mysql_error());
	$row_valeur = mysql_fetch_assoc($valeur);
	$totalRows_valeur = mysql_num_rows($valeur);
	//echo ('<br>Requête etat= '.$query_etat.'<br>');
	$etat = mysql_query($query_etat, $alienorweblibre) or die(mysql_error());
	$row_etat = mysql_fetch_assoc($etat);
	$totalRows_etat = mysql_num_rows($etat);


/* recherche de l'entet de lobjet */
$query_objet = "SELECT DENOMINATION, TITRE, APPELLATION, TAXONOMIE, NUMERO_INVENTAIRE FROM objet WHERE INDEX_OBJET=".$no_fiche_objet;
$objet = mysql_query($query_objet, $alienorweblibre) or die(mysql_error());
$row_objet = mysql_fetch_assoc($objet);

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
<div id="menu" align="center">
	<h1 align="center">&nbsp;</h1>
</div>
<div id="objetGestion">
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
<div id="syntheseGestion">
	<div align="center" id="Emplacement">
		<h2>Emplacement</h2>
		<form action="rep_gestion.php" method="post" name="emplacement" id="emplacement">
			<table width="90%" style="border: 1px solid #666666" cellpadding="3">
				<tr>
					<th scope="col" width="4%" valign="middle">&nbsp;</th>
					<th scope="col" width="23%">Date</th>
					<th scope="col" width="23%">Emplacement</th>
					<th scope="col" width="23%">Redacteur</th>
				</tr>
				<?php
				$c = 0;
				do { 
					($c%2) ? $color = "L1" :  $color = "L2";
					$c++;
					if ($row_emplacement['INDEX_GESTION'] !=""){
					?>
						<tr>
							<td align="center" valign="middle" class="<?php echo $color; ?>"><a href="../masques/mc_<?php echo $page ?>.php?noFiche=<?php echo $row_emplacement['INDEX_GESTION'] ?>&amp;page=<?php echo $page?>" target="_blank"><img src="../images/notice.gif" alt="Voir la fiche num&eacute;ro <?php echo $row_emplacement['INDEX_GESTION']; ?>" width="13" height="16"></a></td>
							<td class="<?php echo $color; ?>"><?php echo reversedate($row_emplacement['DATE_EMPLACEMENT']) ?></td>
							<td class="<?php echo $color; ?>"><?php echo $row_emplacement['EMPLACEMENT'] ?></td>
							<td class="<?php echo $color; ?>"> <?php echo $row_emplacement['EXPERT'] ?></td>
						</tr>
					<?php };//if ($row_emplacement['INDEX_GESTION'] !="")
				} while ($row_emplacement = mysql_fetch_assoc($emplacement)); ?>
		  </table>
	  </form>
		<div align="right">
			<form name="ajou_empl" action="ms_gestion.php" method="post">
			  <input name="INDEX_OBJET" type="hidden" id="INDEX_OBJET" value="<?php echo $no_fiche_objet ?> ">
			  <input name="ACTION" type="hidden" id="ACTION" value="EMPLACEMENT">
			  <input name="INDEX_GESTION" type="hidden" id="INDEX_GESTION" value="0">
			  <input name="ajou_empl" type="submit" id="ajou_empl" value=" nouvel emplacement">
			</form>
	  </div>
	</div>
	<div align="center" id="etat">
		<h2>&Eacute;tat</h2>
		<form action="rep_gestion.php" method="post" name="etat" id="etat">
			<table width="90%" style="border: 1px solid #666666" cellpadding="3">
				<tr>
					<th scope="col" width="4%" valign="middle">&nbsp;</th>
					<th scope="col" width="23%">Date</th>
					<th scope="col" width="23%">&Eacute;tat</th>
					<th scope="col" width="23%">Redacteur</th>
				</tr>
				<?php
				$c = 0;
				do { 
					($c%2) ? $color = "L1" :  $color = "L2";
					$c++;
					if ( $row_etat['INDEX_GESTION'] != ""){
					?>
						<tr>
							<td align="center" valign="middle" class="<?php echo $color; ?>"><a href="../masques/mc_<?php echo $page ?>.php?noFiche=<?php echo $row_etat['INDEX_GESTION'] ?>&amp;page=<?php echo $page?>" target="_blank"><img src="../images/notice.gif" alt="Voir la fiche num&eacute;ro <?php echo $row_etat['INDEX_GESTION']; ?>" width="13" height="16"></a></td>
							<td class="<?php echo $color; ?>"><?php echo reversedate($row_etat['DATE_CONSERVATION']) ?></td>
							<td class="<?php echo $color; ?>"><?php echo $row_etat['ETAT_CONSERVATION'] ?></td>
							<td class="<?php echo $color; ?>"> <?php echo $row_etat['EXPERT'] ?></td>
						</tr>
					<?php 
					}; // if ( $row_etat['INDEX_GESTION'] != "")
					} while  ($row_etat = mysql_fetch_assoc($etat)) ; ?>
		  </table>
	  </form>
		<div align="right">
			<form action="ms_gestion.php" method="post" name="ajou_etat" id="ajou_etat">
			 <input name="INDEX_OBJET" type="hidden" id="INDEX_OBJET" value="<?php echo $no_fiche_objet ?> ">
			  <input name="ACTION" type="hidden" id="ACTION" value="ETAT">
			  <input name="INDEX_GESTION" type="hidden" id="INDEX_GESTION" value="0">
			  <input name="ajou_etat" type="submit" id="ajou_etat" value="nouvel &eacute;tat">
		  </form>
	  </div>
	</div>
	<div align="center" id="valeur">
		<h2>Valeur</h2>
		<form action="rep_gestion.php" name="valeur" id="valeur">
			<table width="90%" style="border: 1px solid #666666" cellpadding="3">
				<tr>
					<th scope="col" width="4%" valign="middle">&nbsp;</th>
					<th scope="col" width="23%">Date</th>
					<th scope="col" width="23%">Valeur</th>
					<th scope="col" width="23%">Redacteur</th>
				</tr>
				<?php
				$c = 0;
				do { 
					($c%2) ? $color = "L1" :  $color = "L2";
					$c++;
					if ($row_valeur['INDEX_GESTION'] != ""){
					?>
						<tr>
							<td align="center" valign="middle" class="<?php echo $color; ?>"><a href="../masques/mc_<?php echo $page ?>.php?noFiche=<?php echo $row_valeur['INDEX_GESTION'] ?>&amp;page=<?php echo $page?>" target="_blank"><img src="../images/notice.gif" alt="Voir la fiche num&eacute;ro <?php echo $row_valeur['INDEX_GESTION']; ?>" width="13" height="16"></a></td>
							<td class="<?php echo $color; ?>"><?php echo reverseDate($row_valeur['DATE_VALEUR']) ?></td>
							<td class="<?php echo $color; ?>"><?php echo $row_valeur['VALEUR'] ?></td>
							<td class="<?php echo $color; ?>"> <?php echo $row_valeur['EXPERT'] ?></td>
						</tr>
					<?php };//if ($row_valeur['INDEX_GESTION'] != "")
					} while ($row_valeur = mysql_fetch_assoc($valeur)); ?>
		   </table>
	  </form>
		<div align="right">
			<form action="ms_gestion.php" method="post" name="ajou_val" id="ajou_val">
			<input name="INDEX_OBJET" type="hidden" id="INDEX_OBJET" value="<?php echo $no_fiche_objet ?> ">
			  <input name="ACTION" type="hidden" id="ACTION" value="VALEUR">
			  <input name="INDEX_GESTION" type="hidden" id="INDEX_GESTION" value="0">
			  <input name="ajou_val" type="submit" id="ajou_val" value="nouvelle valeur">
		  </form>
	  </div>
	</div>
</div>
</body>
</html>
<?php
mysql_free_result($emplacement);
mysql_free_result($valeur);
mysql_free_result($etat);
?>