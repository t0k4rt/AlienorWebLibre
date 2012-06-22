<?php
	session_start();
	include('../config/config.php');
	$niveau_visa = $admin;
	require_once('../Connections/alienorweblibre.php');
	include('../include/fonctions.php');
	include('../include/securite.php');
	
/******** Initialisation des variables *******/
$page = "Administration";
$isobjet = "";
$msg = "";
$nom = "";
$prenom = "";
$login = "";
$mot_de_passe = "";
/*********************************************/
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

/******* Supression d'un utilisateur *******/
if ((isset($_POST['MM_supprimer'])) && ($_POST['MM_supprimer'] == "utilisateur")) {
$deleteSQL = sprintf("DELETE FROM utilisateur WHERE per_index=%s",
	GetSQLValueString($_POST['per_index'], "int"));
  mysql_select_db($database_alienorweblibre, $alienorweblibre);

		$Result1 = mysql_query($deleteSQL, $alienorweblibre) or die(mysql_error());
		$msg = "L'utilisateur a bien été supprimé";
}
/******* Modifier un utilisateur *******/

if (isset($_POST["MM_modifier"]) && isset($_POST['per_index']))
	{$per_index = intval($_POST['per_index']);
	}
else
	{$per_index = 0;}
	
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_utilisateur = "SELECT * FROM utilisateur WHERE per_index = ".$per_index."";
$mod_utilisateur = mysql_query($query_utilisateur, $alienorweblibre) or die(mysql_error());
$row_mod_utilisateur = mysql_fetch_assoc($mod_utilisateur);
$totalRows_mod_utilisateur = mysql_num_rows($mod_utilisateur);

if ((isset($_POST["MM_modif"])) && ($_POST["MM_modif"] == "utilisateur")) {
	$per_index = intval($_POST['per_index']);
	if (!empty($_POST['mot_de_passe']) and $_POST['mot_de_passe']==$_POST['mot_de_passe1']) {
		$_POST['mot_de_passe'] = md5($_POST['mot_de_passe']);
		$updateSQL = sprintf("UPDATE utilisateur SET nom=%s, prenom=%s, login=%s, mot_de_passe=%s, droit=%s WHERE per_index = ".$per_index."",
						   GetSQLValueString($_POST['nom'], "text"),
						   GetSQLValueString($_POST['prenom'], "text"),
						   GetSQLValueString($_POST['login'], "text"),
						   GetSQLValueString($_POST['mot_de_passe'], "text"),
						   GetSQLValueString($_POST['droit'], "int"));
	} else {
		$updateSQL = sprintf("UPDATE utilisateur SET nom=%s, prenom=%s, login=%s, droit=%s WHERE per_index = ".$per_index."",
						   GetSQLValueString($_POST['nom'], "text"),
						   GetSQLValueString($_POST['prenom'], "text"),
						   GetSQLValueString($_POST['login'], "text"),
						   GetSQLValueString($_POST['droit'], "int"));
	}
	mysql_select_db($database_alienorweblibre, $alienorweblibre);
	$Result1 = mysql_query($updateSQL, $alienorweblibre) or die(mysql_error());
	$msg = "Le profil utilisateur a été modifié";
	//remise à zéro de la valeur : permet d'afficher les champs mots de passe
	$per_index=0;
}
/*******************************************/

/******* Inserer un utilisateur *******/
if((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "utilisateur") && ($_POST['nom'] != ""))
{
  $_POST['mot_de_passe'] = md5($_POST['mot_de_passe']);
  $insertSQL = sprintf("INSERT INTO utilisateur (nom,prenom,login,mot_de_passe,droit) VALUES (%s,%s,%s,%s,%s)",
                       GetSQLValueString($_POST['nom'], "text"),
					   GetSQLValueString($_POST['prenom'], "text"),
					   GetSQLValueString($_POST['login'], "text"),
					   GetSQLValueString($_POST['mot_de_passe'], "text"),
					   GetSQLValueString($_POST['droit'], "int"));

	/******* Vérification login pour éviter les doublons *******/
	mysql_select_db($database_alienorweblibre, $alienorweblibre);
	$query_utilisateur = "SELECT * FROM utilisateur WHERE login = '".$_POST['login']."'";
	$utilisateur = mysql_query($query_utilisateur, $alienorweblibre) or die(mysql_error());
	$row_utilisateur = mysql_fetch_assoc($utilisateur);
	$totalRows_utilisateur = mysql_num_rows($utilisateur);
	/***********************************************************/
	
		if ($totalRows_utilisateur == 0) {
			mysql_select_db($database_alienorweblibre, $alienorweblibre);
			$Result = mysql_query($insertSQL, $alienorweblibre) or die(mysql_error());
			$msg = "Utilisateur inséré avec succès";
		} else {
			$msg = "Ce login existe déjà";
		}
}
/********************************************/

/******** Affichage des utilisateurs *******/
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_utilisateur = "SELECT * FROM utilisateur ORDER BY nom ASC";
$utilisateur = mysql_query($query_utilisateur, $alienorweblibre) or die(mysql_error());
$row_utilisateur = mysql_fetch_assoc($utilisateur);
$totalRows_utilisateur = mysql_num_rows($utilisateur);
/********************************************/
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="fr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="pragma" content="no-cache">
<title>Gestion des param&egrave;tres de votre base</title>
<link href="../style/style_awl.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
<!--
function verifMdp() {
	if (document.utilisateur.mot_de_passe.value != document.utilisateur.mot_de_passe1.value) {
		alert("ATTENTION :\n\nLes mots de passe ne sont pas identique");
		document.utilisateur.mot_de_passe.value = '';
		document.utilisateur.mot_de_passe1.value = '';
		document.utilisateur.mot_de_passe.select();
		document.utilisateur.mot_de_passe.focus();
	}
}

function confirmer() {
	if (confirm('Voulez vous supprimer cet utilisateur ?')) {
	document.supprimer.submit();	
	} else {
		return false;
	}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_validateForm() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' doit contenir une adresse mail.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' doit contenir un nombre.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' doit être compris entre '+min+' et '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' est requis.\n'; }
  } if (errors) alert('Quelques omissions ou erreurs ont été trouvées :\n'+errors);
  document.MM_returnValue = (errors == '');
}
//-->
</script>
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
-->
</style>
</head>
<body>
<?php include('../include/navigation.php'); ?>
<div id="haut">
    <h2>Formulaire des param&egrave;tres des utilisateurs</h2>
</div>
<div class="centre">
    <form method="post" name="utilisateur" action="<?php echo $editFormAction; ?>">
        <table cellspacing="0" class="bd-tbl-mr" align="center">
            <tr>
                <td colspan="2" align="center" class="titre-tbl"><b>Utilisateur</b></td>
            </tr>
            <tr>
                <td align="right">
                    <label for="nom">Nom&nbsp;:</label>
                </td>
                <td align="left">
                    <input type="text" name="nom" id="nom" size="32" accesskey="N" tabindex="1" value="<?php echo $row_mod_utilisateur['nom']; ?>">
                </td>
            </tr>
            <tr>
                <td align="right">
                    <label for="prenom">Pr&eacute;nom&nbsp;:</label>
                </td>
                <td align="left">
                    <input type="text" name="prenom" id="prenom" size="32" accesskey="P" tabindex="2" value="<?php echo $row_mod_utilisateur['prenom']; ?>">
                </td>
            </tr>
            <tr>
                <td align="right">
                    <label for="login">Login&nbsp;:</label>
                </td>
                <td align="left">
                    <input type="text" name="login" id="login" size="32" accesskey="L" tabindex="3" value="<?php echo $row_mod_utilisateur['login']; ?>">
                </td>
            </tr>
            <?php if (isset($_POST["module"]) && $_POST["module"] != "utilisateur" || $per_index == 0) { ?>
                <tr>
                    <td align="right">
                        <label for="mot_de_passe">Mot&nbsp;de&nbsp;passe&nbsp;:</label>
                    </td>
                    <td align="left">
                        <input type="password" name="mot_de_passe" id="mot_de_passe" size="32" accesskey="M" tabindex="4" value="">
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        <label for="mot_de_passe1">Confirmer&nbsp;mot&nbsp;de&nbsp;passe&nbsp;:</label>
                    </td>
                    <td align="left">
                        <input type="password" name="mot_de_passe1" id="mot_de_passe1" value="" size="32" accesskey="C" tabindex="5" onBlur="verifMdp()">
                    </td>
                </tr>
                <?php } ?>
            <tr>
                <td align="right">
                    Droit&nbsp;:
                </td>
                <td align="left" valign="middle"> <?php  $accesdroit = array("Public","Privé","Recherche","Saisie","Visa","Administration"); ?> <?php for($i=0; $i <= 5 ; $i++) { ?>
                    <?php if($i==2 || $i==3 || $i==5){ ?>
					<input type="radio" name="droit" id="droit<?php echo $i ?>" value="<?php echo($i*10); ?>"<?php if ($row_mod_utilisateur['droit'] == ($i*10)) { ?>  checked<?php } ?> tabindex="6">
                    <label for="droit<?php echo $i ?>"><?php echo($accesdroit[$i]); ?></label>
                    &nbsp; 
					<?php } ?>
					<?php } ?> </td>
            </tr>
            <tr>
                <td align="right">&nbsp;</td>
                <td> <?php if (isset($_POST["MM_modifier"])) { ?>
                            <input name="modifier" type="submit" value="Modifier l'enregistrement" accesskey="O">
                            <input type="hidden" name="per_index" value="<?php echo $row_mod_utilisateur['per_index']?>">
                        <input type="hidden" name="MM_modif" value="utilisateur">
                        <?php } else { ?>
                        <input name="inserer" type="submit" accesskey="I" onClick="MM_validateForm('nom','','R','prenom','','R','login','','R');return document.MM_returnValue; " value="Ins&eacute;rer l'enregistrement">
                        <input type="hidden" name="MM_insert" value="utilisateur">
                        <?php } ?> </td>
            </tr>
            <tr>
                <td colspan="2" align="right">
                    <p style="text-align:center; color:#FF0000; font-weight:bold"> <?php echo $msg; ?> </p>
                </td>
            </tr>
        </table>
    </form>
</div>
<br>
<div class="centre">
    <table cellpadding="3" cellspacing="1" class="bd-tbl-mr" align="center">
        <tr>
          	<th>Nom</th>
            <th>Pr&eacute;nom</th>
            <th>Login</th>
            <th>Droit</th>
            <th>Supprimer</th>
            <th>Modifier l'utilisateur </th>
            <th>Modif mot de passe </th>
        </tr>
        <?php $c = 0;
			do {
					($c%2) ? $color = "L1" :  $color = "L2";
					$c++; 
					?>
	            <tr>
	              	<td class="<?php echo $color; ?>"><?php echo $row_utilisateur['nom'];?></td>
	                <td class="<?php echo $color; ?>"><?php echo $row_utilisateur['prenom']; ?></td>
	                <td class="<?php echo $color; ?>"><?php echo $row_utilisateur['login']; ?></td>
	                <td class="<?php echo $color; ?>"><?php echo $row_utilisateur['droit']; ?></td>
	                <td class="<?php echo $color; ?>" style="vertical-align:middle">
	                    <form id="supprimer<?php echo $c?>" name="supprimer<?php echo $c?>" method="post" action="" onSubmit="return confirmer();">
	                    	<input type="hidden" name="per_index" value="<?php echo $row_utilisateur['per_index']; ?>">
	                    	<input type="submit" name="sup_sel" value="Supprimer" accesskey="S" >
	                    	<input type="hidden" name="MM_supprimer" value="utilisateur">
	                    </form>
	                </td>
	                <td class="<?php echo $color; ?>">
	                    <form name="modifier<?php echo $c?>" method="post" action="#">
	                        <input type="hidden" name="per_index" value="<?php echo $row_utilisateur['per_index']; ?>">
	                        <input type="submit" name="module" value="utilisateur" accesskey="O">
	                        <input type="hidden" name="MM_modifier" value="utilisateur">
	                    </form>
	                </td>
	                <td class="<?php echo $color; ?>">
	                    <form name="modifier_<?php echo $c?>" method="post" action="#">
	                        <input type="hidden" name="per_index" value="<?php echo $row_utilisateur['per_index']; ?>">
							<input type="submit" name="module" value="motdepasse" accesskey="D" >
	                        <input type="hidden" name="MM_modifier" value="motdepasse">
	                    </form>
	                </td>
	            </tr>
<?php 
} while ($row_utilisateur = mysql_fetch_assoc($utilisateur)); ?>
    </table>
</div>
</body>
</html>
<?php
mysql_free_result($utilisateur);
?>