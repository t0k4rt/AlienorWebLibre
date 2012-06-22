<?php	
	require_once('../config/config.php');
	$niveau_visa = $mcr;
	$page = "inventaire";
	include('../include/securite.php');
	include('../include/fonctions.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Saisie de la date de l'inventaire</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../style/style_awl.css" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript">
<!--
// fonction de vérification de la saisie d'une date
function champDat(champ) {
	var chaine = champ.value;
	if (chaine != "") {
		// Contrôle que la date soit de la forme "jj.mm.aaaa"
		if (chaine.search(/^[0-9]{2}\.[0-9]{2}\.[0-9]{4}$/) != 0) {
			alert("Le format de la date que vous venez de saisir n'est pas valide\n\nLa date doit être saisie sous la forme jj.mm.aaaa");
			champ.select();
			champ.focus();
		} else {
			// Découpage de la date en entier base 10
			j = parseInt(chaine.split(".")[0], 10); // jour
			m = parseInt(chaine.split(".")[1], 10); // mois
			a = parseInt(chaine.split(".")[2], 10); // année
			// test l'année bisextile : divisible par 4, pas un siècle et divisible par 400
			if (a%4 == 0 && a%100 !=0 || a%400 == 0) fev=29; else fev=28;
			// Nombre de jour pour chaque mois
			nbJours = new Array(31,fev,31,30,31,30,31,31,30,31,30,31);
			// test si le mois est compris entre 1 et 12 et si jour est compris entre 1 et jour mois max
			if ((m >= 1 && m <=12 && j >= 1 && j <= nbJours[m-1]) != true) {
				alert("La date saisie n'est pas valide\n\njour ou mois non valide");
				champ.select();
				champ.focus();
			}
		}
	}
}
-->
</script>
<script language="JavaScript1.2" type="text/javascript" src="../include/RoboHelp_CSH.js"></script>
</head>
<body>
<div id="haut"><h1>&nbsp;</h1></div>
<div id="action">
  <h2>Date de l'inventaire</h2>
</div>
<div id="formulaire">
<table align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td class="champobligatoire">
            <form action="finventaire.php" method="POST" name="form1" target="_self">
                Entrez la date de pr&eacute;vue de signature et de paraphage de l&#8217;inventaire :
                <input name="date" type="text" value="<?php echo date("d.m.Y") ?>" size="15" maxlength="15" title="Entrer la date sous la forme 01.01.2000" onFocus="javascript:window.status='Entrer la date sous la forme 01.01.2000';" onBlur="javascript:champDat(this);">
				<input name="chx_selection" type="hidden" value="<?php echo $_POST['chx_selection']; ?>">
                <input type="image" value="submit" src="../images/valider.gif" alt="valider">
            </form>        </td>
    </tr>
</table>
</div>
</body>
</html>
