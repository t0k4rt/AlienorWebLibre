<?php
		session_start();
require_once('../config/config.php');
	$niveau_visa = $ms;
	$objet = 0;
    include('../include/securite.php');
	include('../include/fonctions.php');
	require_once('../Connections/alienorweblibre.php');

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == 'fichegestion')) {

	if ($_POST['EMPLACEMENT'] != '' && $_POST['DATE_EMPLACEMENT']!='') {
		/****************************************/
		/* Début création de fiche EMPLACEMENT */
		/***************************************/
		// ----------------- inverser date emplacement -----------------
		$DATE_EMPLACEMENT = preg_replace('/^(.{2}).(.{2}).(.{4})$/','$3-$2-$1', $_POST['DATE_EMPLACEMENT']);
		$insertSQL = sprintf("INSERT INTO gestion (EMPLACEMENT,DATE_EMPLACEMENT,EXPERT,COPYRIGHT,FICHE_CREEE_LE,FICHE_CREEE_PAR,CODEMUSEE) VALUES (%s,%s,%s,%s,%s,%s,%s)",
							GetSQLValueString($_POST['EMPLACEMENT'], "text"),
							GetSQLValueString($DATE_EMPLACEMENT, "date"),
							GetSQLValueString($_POST['FICHE_CREEE_PAR'], "text"),
							GetSQLValueString($_POST['COPYRIGHT'], "text"),
							GetSQLValueString($_POST['FICHE_CREEE_LE'], "date"),
							GetSQLValueString($_POST['FICHE_CREEE_PAR'], "text"),
							GetSQLValueString($_POST['CODEMUSEE'], "text"));
		mysql_select_db($database_alienorweblibre, $alienorweblibre);
		//echo "<br>Emplacement<br>";
		//echo $insertSQL;
		$Result1 = mysql_query($insertSQL, $alienorweblibre) or die(mysql_error());
		/* fin création fiches */
		/* Récuperation du numéro de la fiche créée */
		mysql_select_db($database_alienorweblibre, $alienorweblibre);
		$query_gestion = "SELECT INDEX_GESTION FROM gestion WHERE EMPLACEMENT = '".$_POST['EMPLACEMENT']."' ORDER BY INDEX_GESTION DESC";
		//echo "<br> question de selection fiche gestion emplacement<br>";
		//echo $query_gestion;
		$gestion = mysql_query($query_gestion, $alienorweblibre) or die(mysql_error());
		$row_gestion = mysql_fetch_assoc($gestion);
		$totalRows_gestion = mysql_num_rows($gestion);
		$noGestion = intval($row_gestion['INDEX_GESTION']);
		//echo "<br> nogestion emplacement <br>";
		//echo $noGestion;
		/* Fin de récupération de la fiche créée */ 
		/* Début liaison de la fiche gestion avec la fiche objet */
		$insertSQL = sprintf("INSERT INTO obj_ges (INDEX_OBJET,INDEX_GESTION) VALUES (".intval($_POST["noFiche"]).",".$noGestion.")");
		mysql_select_db($database_alienorweblibre, $alienorweblibre);
		//echo "<br>liaison emplacement<br>";
		//echo $insertSQL;
		$Result1 = mysql_query($insertSQL, $alienorweblibre) or die(mysql_error());
		/* Fin liaison de la fiche gestion avec la fiche objet */
		/****************************************/
		/*  Fin création de fiche EMPLACEMENT   */
		/***************************************/
		/****************************************/
		/*    Début création de fiche ETAT     */
		/***************************************/
		if ($_POST['ETAT_CONSERVATION'] != "" ){
					// ----------------- inverser date conservation -----------------
		$DATE_CONSERVATION = preg_replace('/^(.{2}).(.{2}).(.{4})$/','$3-$2-$1', $_POST['DATE_CONSERVATION']);
			$insertSQL = sprintf("INSERT INTO gestion (EXPERT,ETAT_CONSERVATION,DATE_CONSERVATION,COPYRIGHT,FICHE_CREEE_LE,FICHE_CREEE_PAR,CODEMUSEE) VALUES (%s,%s,%s,%s,%s,%s,%s)",
								GetSQLValueString($_POST['EXPERT_ETAT'], "text"),
								GetSQLValueString($_POST['ETAT_CONSERVATION'], "text"),
								GetSQLValueString($DATE_CONSERVATION, "date"),
								GetSQLValueString($_POST['COPYRIGHT'], "text"),
								GetSQLValueString($_POST['FICHE_CREEE_LE'], "date"),
								GetSQLValueString($_POST['FICHE_CREEE_PAR'], "text"),
								GetSQLValueString($_POST['CODEMUSEE'], "text"));
			mysql_select_db($database_alienorweblibre, $alienorweblibre);
			//echo "<br>Etat<br>";
			//echo $insertSQL;
			$Result1 = mysql_query($insertSQL, $alienorweblibre) or die(mysql_error());
			/* fin création fiches */
			
			/* Récuperation du numéro de la fiche créée */
			mysql_select_db($database_alienorweblibre, $alienorweblibre);
			$query_gestion = "SELECT INDEX_GESTION FROM gestion WHERE ETAT_CONSERVATION = '".$_POST['ETAT_CONSERVATION']."' ORDER BY INDEX_GESTION DESC";
			$gestion = mysql_query($query_gestion, $alienorweblibre) or die(mysql_error());
			$row_gestion = mysql_fetch_assoc($gestion);
			$totalRows_gestion = mysql_num_rows($gestion);
			$noGestion = intval($row_gestion['INDEX_GESTION']);
			//echo "<br> nogestion etat <br>";
			//echo $noGestion;
			/* Fin de récupération de la fiche créée */ 
			/* Début liaison de la fiche gestion avec la fiche objet */
			$insertSQL = sprintf("INSERT INTO obj_ges (INDEX_OBJET,INDEX_GESTION) VALUES (".intval($_POST["noFiche"]).",".$noGestion.")");
			mysql_select_db($database_alienorweblibre, $alienorweblibre);
			//echo "<br>liaison Etat<br>";
			//echo $insertSQL;
			$Result1 = mysql_query($insertSQL, $alienorweblibre) or die(mysql_error());
			/* Fin liaison de la fiche gestion avec la fiche objet */
		} // if etat <>""
		/****************************************/
		/*     Fin création de fiche ETAT       */
		/***************************************/
		/****************************************/
		/*    Début création de fiche VALEUR    */
		/***************************************/
		if ( $_POST['VALEUR'] != "" ) {
			// ----------------- inverser date valeur -----------------
			$DATE_VALEUR = preg_replace('/^(.{2}).(.{2}).(.{4})$/','$3-$2-$1', $_POST['DATE_VALEUR']);
			$insertSQL = sprintf("INSERT INTO gestion (EXPERT,VALEUR,DATE_VALEUR,COPYRIGHT,FICHE_CREEE_LE,FICHE_CREEE_PAR,CODEMUSEE) VALUES (%s,%s,%s,%s,%s,%s,%s)",
								GetSQLValueString($_POST['EXPERT_VALEUR'], "text"),
								GetSQLValueString($_POST['VALEUR'], "text"),
								GetSQLValueString($DATE_VALEUR, "date"),					
								GetSQLValueString($_POST['COPYRIGHT'], "text"),
								GetSQLValueString($_POST['FICHE_CREEE_LE'], "date"),
								GetSQLValueString($_POST['FICHE_CREEE_PAR'], "text"),
								GetSQLValueString($_POST['CODEMUSEE'], "text"));
			mysql_select_db($database_alienorweblibre, $alienorweblibre);
			//echo "<br>Valeur<br>";
			//echo $insertSQL;
			$Result1 = mysql_query($insertSQL, $alienorweblibre) or die(mysql_error());
			/* fin création fiches */
			
			/* Récuperation du numéro de la fiche créée */
			mysql_select_db($database_alienorweblibre, $alienorweblibre);
			$query_gestion = "SELECT INDEX_GESTION FROM gestion WHERE VALEUR = '".$_POST['VALEUR']."' ORDER BY INDEX_GESTION DESC";
			$gestion = mysql_query($query_gestion, $alienorweblibre) or die(mysql_error());
			$row_gestion = mysql_fetch_assoc($gestion);
			$totalRows_gestion = mysql_num_rows($gestion);
			$noGestion = intval($row_gestion['INDEX_GESTION']);
			//echo "<br> nogestion valeur <br>";
			//echo $noGestion;
			/* Fin de récupération de la fiche créée */ 
			/* Début liaison de la fiche gestion avec la fiche objet */
			$insertSQL = sprintf("INSERT INTO obj_ges (INDEX_OBJET,INDEX_GESTION) VALUES (".intval($_POST["noFiche"]).",".$noGestion.")");
			mysql_select_db($database_alienorweblibre, $alienorweblibre);
			//echo "<br>liaison valeur<br>";
			//echo $insertSQL;
			$Result1 = mysql_query($insertSQL, $alienorweblibre) or die(mysql_error());
			/* Fin liaison de la fiche gestion avec la fiche objet */
		} // if valeur <> ""
		/****************************************/
		/*    Fin création de fiche VALEUR     */
		/***************************************/
		$insertGoTo = "mc_".$_POST["page"].".php?noFiche=".$_POST["noFiche"];
		//echo $insertGoTo;
		header(sprintf("Location: %s", $insertGoTo));
	}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="fr">
<head>
<title>Alienor Web : Mise &agrave; jour Gestion</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="pragma" content="no-cache">
<link href="../style/style_awl.css" rel="stylesheet" type="text/css" media="screen">
<link href="../style/style_awl_print.css" rel="stylesheet" type="text/css" media="print">
<script language="javascript" type="text/javascript">
<!--
// fonction de vérification de la saisie d'une date
function champDat(champ) {
	var chaine = champ.value;
	if (chaine != "") {
		// Contrôle que la date soit de la forme "jj.mm.aaaa"
		if (chaine.search(/^[0-9]{2}\.[0-9]{2}\.[0-9]{4}$/) != 0){
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
<script type="text/javascript">
<!--
function MM_validateForm() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' doit contenir une adresse mail valide.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' doit contenir une valeur numérique.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' doit contenir un nombre compris entre '+min+' et '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' doit être rempli.\n'; }
  } 
  	if (errors!='' ) {
		alert('Quelques omissions ou erreurs ont été trouvées :\n'+errors);
	}
}


function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}
<?php creerFenetreTheso(); ?>
//-->
</script>
<script language="JavaScript1.2" type="text/javascript" src="../include/RoboHelp_CSH.js"></script>
</head>
<body>
<div id="haut">
    <h2>Gestion</h2>
</div>
<form action="mcr_champs_gestion.php" method="post" onsubmit="MM_validateForm('EMPLACEMENT','','R','DATE_EMPLACEMENT','','R');return document.MM_returnValue" name="fiche" >
    <table width="80%" align="center" class="saisie" style="border:1px solid #000000">
        <tr>
            <td colspan="4" align="center">Les champs de gestion * doivent &ecirc;tre renseign&eacute;s</td>
        </tr>
        <tr>
            <th colspan="4">&nbsp;</th>
        </tr>
        <tr>
            <td colspan="4"><b>Valorisation</b>
				<a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,5107)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a>
            </td>
        </tr>
        <tr>
            <td align="right">Valeur :</td>
            <td align="left">
                <input type="text" name="VALEUR" value=""></td>
            <td align="right">Date :</td>
            <td>
                <input name="DATE_VALEUR" type="text" class="inputnumerique" onBlur="champDat(this);" value="">            </td>
        </tr>
        <tr>
            <td align="right"><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=AUT&amp;curterm=&amp;curindex=&amp;SRC=EXPERT_VALEUR&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=EXPERT_VALEUR');">Expertis&eacute;(e) par</a> :</td>
            <td align="left">
                <input name="EXPERT_VALEUR" type="text" id="EXPERT_VALEUR" value="">            </td>
            <td align="right">&nbsp;</td>
            <td align="left">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="4"><b>Emplacement</b> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,5217)"> <img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a> </td>
        </tr>
        <tr>
            <td align="right">Emplacement * :</td>
            <td align="left">
                <input type="text" name="EMPLACEMENT" value="">            </td>
            <td align="right">Date * :</td>
            <td align="left">
                <input name="DATE_EMPLACEMENT" type="text" class="inputnumerique" onBlur="champDat(this);" value="">            </td>
        </tr>
        <tr>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="4"><b>&Eacute;tat de conservation</b> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,5108)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
        </tr>
        <tr>
          <td colspan="4" align="left"><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=ETAT&amp;curterm=&amp;curindex=&amp;SRC=ETAT_CONSERVATION&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=ETAT_CONSERVATION');">&Eacute;tat</a> : </td>
        </tr>
        <tr>
            <td colspan="4" align="right"><textarea name="ETAT_CONSERVATION" cols="100" rows="5" class="textarealong100"></textarea></td>
        </tr>
        <tr>
          <td align="right">Date :</td>
          <td align="left"><input name="DATE_CONSERVATION" type="text" class="inputnumerique" onBlur="champDat(this);" value="">          </td>
          <td align="right"><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=AUT&amp;curterm=&amp;curindex=&amp;SRC=EXPERT_ETAT&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=EXPERT_ETAT');">Expertis&eacute;(e) par</a> :</td>
          <td align="left"><input name="EXPERT_ETAT" type="text" id="EXPERT_ETAT" value="">
          </td>
        </tr>
        <tr>
            <td align="right">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>
                <input type="hidden" name="page" value="<?php 
					if ($_GET["page"]) { echo $_GET["page"]; }else { echo $_POST["page"]; } ?>">
                <input type="hidden" name="noFiche" value="<?php 
					if ($_GET["noFiche"]) { echo $_GET["noFiche"]; }else { echo $_POST["noFiche"]; }  ?>">
                <input type="hidden" name="IDENTIFIANT_NATIONAL" value="">
                <input type="hidden" name="COPYRIGHT" value="<?php echo $_SESSION["musee"]; ?>">
                <input type="hidden" name="FICHE_CREEE_LE" value="<?php echo(date("Y.m.d")) ?>">
                <input type="hidden" name="FICHE_CREEE_PAR" value="<?php echo $_SESSION["nom"]." ".$_SESSION["prenom"]; ?>">
                <input type="hidden" name="CODEMUSEE" id="CODEMUSEE" value="<?php echo($_SESSION["code_musee"]); ?>">
                <input type="hidden" name="MM_insert" value="fichegestion">
 			<input name="image" type="image" src="../images/valider.gif">
           </td>
        </tr>
    </table>
</form>
</body>
</html>
