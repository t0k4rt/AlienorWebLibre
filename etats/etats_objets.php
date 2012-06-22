<?php	
	require_once('../config/config.php');
	$niveau_visa = $mcr;
	$page = $_POST['page'];
	include('../include/securite.php');
	include('../include/fonctions.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../style/style_awl.css" rel="stylesheet" type="text/css" />
<title>Liste des &eacute;tats disponibles</title>
<script language="javascript" type="text/javascript">
function valide(direction){
	if (direction == 'etiquette') {
		document.etats.action = "etiquette.php";
	};
	if (direction == 'complete') {
		document.etats.action = "nt_oeuvrescpl.php";
	};
	if (direction == 'juridique') {
		document.etats.action = "inventaire.php";
	};
	if (direction == 'inventaire-recolement'){
		document.etats.action = "../bordereaux/mc_inventaire-recolement.php";
	}
	document.etats.submit();
	
}
</script>
</head>

<body>
<?php 
if ($_POST['chx_selection'] == "") {?>
	<div id="haut">
	<a href="javascript:window.close();">votre s&eacute;lection est vide</a>
	</div>
	<?php
}else{
	include('../include/navigation.php'); ?>
  <div id="haut"> 
    <h2>Liste des états disponibles</h2>
</div>
<div id="formulaire">
	<form action="etats_objets.php" method="post" name="etats">
			<input name="chx_selection" type="hidden" id="chx_selection" value="<?php echo $_POST['chx_selection'];?>"  />
		    <table width="70%" border="0" align="center" cellpadding="0" cellspacing="0">
			<tr>
			  <td colspan="2" align="center"><p class="titre-tbl">&Eacute;tats</p></td>
			</tr>
			<tr>
			  <td align="center" style="padding:4px;"><p class="obligatoire"><a href="javascript:valide('complete');">notice d'oeuvre compl&egrave;te</a></p></td>
			  <td align="center"  style="padding:4px;"><p class="obligatoire"><a href="javascript:valide('juridique');" > inventaire
			  			juridique </a> </p></td>
			</tr>
            <tr>
			  <td align="center"  style="padding:4px;"><p class="obligatoire"><a href="javascript:valide('etiquette');">&eacute;tiquettes (d&eacute;p&ocirc;t arch&eacute;o)</a></p></td>
			  <td align="center"  style="padding:4px;"><p class="obligatoire"> </p></td>
			</tr>
			<tr>
			  <td colspan="2" align="center" class="titre-tbl">Bordereaux</td>
			  </tr>
			<tr>
			  <td align="center"><a href="javascript:valide('inventaire-recolement');" class="obligatoire">inventaire r&eacute;colement</a></td>
			  <td align="center">&nbsp;</td>
			</tr>
			<tr>
			  <td colspan="2" align="center"><p class="titre-tbl">Export XML </p></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
			</tr>
	  </table>
	</form>
</div>
<?php } ?>
</body>
</html>
