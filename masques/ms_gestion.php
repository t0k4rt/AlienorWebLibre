<?php
	session_start();
require_once('../config/config.php');
	$niveau_visa = $ms;
	$page = "ba";
	$msg = "";
	$result = "";
	include('../include/securite.php');
	include('../include/fonctions.php');
	
    include('../Connections/alienorweblibre.php');
    
	$action = $_POST['ACTION'];
	$no_fiche_objet = $_POST['INDEX_OBJET'];
	if ((isset($_POST["ACTION"])) && ($_POST["ACTION"] == 'CREATION')) {
		mysql_select_db($database_alienorweblibre, $alienorweblibre);
		// D�but cr�ation de fiche */
			// ----------------- Construction dynamique de la requ�te de mise � jour -----------------
			$premier = 1;
		foreach($_POST as $key=>$val) {
			//echo("<b>Rubrique =</b> ".$key." <b>Valeur =</b> ".$val."<br>");
			if ($key != 'INDEX_OBJET' && $key != 'ACTION') {
				if ($premier == 1) {
					// le premier est forcement la date
					$champ ="(".$key;
					// ----------------- si la valeur est une date la convertir -----------------
					if (ereg("([0-9]{2}).([0-9]{2}).([0-9]{4})", $val)) {
						$val = preg_replace('/^(.{2}).(.{2}).(.{4})$/','$3-$2-$1', $val);
					}
					$donnees ="('".$val."'";
					$select_requete = $key." = '".$val."'";
					$premier = 0;
				}else{
					$champ = $champ.",".$key;
					// ----------------- si la valeur est une date la convertir -----------------
					if (ereg("([0-9]{2}).([0-9]{2}).([0-9]{4})", $val)) {
						$val = preg_replace('/^(.{2}).(.{2}).(.{4})$/','$3-$2-$1', $val);
					}
					$donnees = $donnees.",'".$val."'";
					$select_requete = $select_requete." AND ".$key." = '".$val."'";
				}
			} // if ($key != 'INDEX_OBJET' && $key != 'ACTION')
		} // foreach($_POST as $key=>$val)
		$champ = $champ.')';
		$donnees = $donnees.')';
		//echo "<br>champ :<br>";
		//echo $champ;
		//echo "<br>donn�es :<br>";
		//echo $donnees;
		//echo "<br>select_requete :<br>";
		//echo $select_requete;
		$requete = "INSERT INTO gestion ".$champ." VALUES ".$donnees;
		//echo "<br>requete creation :<br>";
		//echo $requete;
		$Result1 = mysql_query($requete, $alienorweblibre) or die(mysql_error());
		// fin cr�ation fiches
		// R�cuperation du num�ro de la fiche cr��e
		$requete = "SELECT INDEX_GESTION FROM gestion WHERE ";
		$requete = $requete.$select_requete;
		$requete = $requete." ORDER BY FICHE_CREEE_LE DESC";
		//echo "<br>requete selection :<br>";
		//echo $requete;
		$gestion = mysql_query($requete, $alienorweblibre) or die(mysql_error());
		$row_gestion = mysql_fetch_assoc($gestion);
		$totalRows_gestion = mysql_num_rows($gestion);
		$noGestion = intval($row_gestion['INDEX_GESTION']);
		//echo "<br> nogestion<br>";
		//echo $noGestion;
		// Fin de r�cup�ration de la fiche cr��e */
		/* D�but liaison de la fiche gestion avec la fiche objet */
		$insertSQL = sprintf("INSERT INTO obj_ges (INDEX_OBJET,INDEX_GESTION) VALUES (".intval($no_fiche_objet).",".$noGestion.")");
		mysql_select_db($database_alienorweblibre, $alienorweblibre);
		//echo "<br>liaison emplacement<br>";
		//echo $insertSQL;
		$Result1 = mysql_query($insertSQL, $alienorweblibre) or die(mysql_error());
		/* Fin liaison de la fiche gestion avec la fiche objet */
		$insertGoTo = "mc_objet_gestion.php?INDEX_OBJET=".$no_fiche_objet;	
		//echo $insertGoTo;
		header(sprintf("Location: %s", $insertGoTo));
	}
	
	
	
	
	
	
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="fr">
<head>
<title>Formulaire de saisie : gestion</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="pragma" content="no-cache">
<link href="../style/style_awl.css" rel="stylesheet" type="text/css" media="screen">
<link href="../style/style_awl_print.css" rel="stylesheet" type="text/css" media="print">
<script language="javascript">
<!--
// fonction de v�rification de la saisie d'une date
function champDat(champ) {
	var chaine = champ.value;
	if (chaine != "") {
		// Contr�le que la date soit de la forme "jj.mm.aaaa"
		if (chaine.search(/^[0-9]{2}\.[0-9]{2}\.[0-9]{4}$/) != 0) {
			alert("Le format de la date que vous venez de saisir n'est pas valide\n\nLa date doit �tre saisie sous la forme jj.mm.aaaa");
			champ.select();
			champ.focus();
		} else {
			// D�coupage de la date en entier base 10
			j = parseInt(chaine.split(".")[0], 10); // jour
			m = parseInt(chaine.split(".")[1], 10); // mois
			a = parseInt(chaine.split(".")[2], 10); // ann�e
			// test l'ann�e bisextile : divisible par 4, pas un si�cle et divisible par 400
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
<script language="JavaScript1.2" type="text/javascript" src="http://localhost/alienorweblibre/include/RoboHelp_CSH.js"></script>
<script type="text/javascript">
<!--
function FenetreTheso(URL) {
	window.open("<?php echo $_SESSION['thesaurus'];
		echo '"';
		if ($_SESSION['internet'] == "true" ){echo "+ URL";}else{ echo ' + "?THESO=" + URL'; }?>, '', 'scrollbars=yes,status=yes,width=450,height=500,resizable=yes');
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
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' doit contenir une adresse mail valide.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' doit contenir une valeur num�rique.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' doit contenir un nombre compris entre '+min+' et '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' doit �tre rempli.\n'; }
  } (errors) ? alert('Quelques omissions ou erreurs ont �t� trouv�es :\n'+errors) : document.gestion.submit();
  document.MM_returnValue = (errors == '');
}


//-->
</script>
</head>
<body>
<div id="haut">
<h2>Formulaire de saisie : gestion</h2>
</div>
<div id="s-menu">
    <div id="btnvalid">
        <input name="image" type="image" onClick="MM_validateForm('NUMERO_INVENTAIRE','','R','DISCIPLINE','','R','DOMAINE','','R','NB_EXEMPLAIRE','','NisNum','LOCALISATION','','R','PROPRIETAIRE','','R','PROPRIETAIRE_TXT_DATE_PATRIMONIALE','','R','PROPRIETAIRE_DEB_DATE_PATRIMONIALE','','R','TYPE_PROPRIETE','','R','SERVICE_GESTIONNAIRE','','R','MODE_ACQUISITION','','R','LOT','','NisNum','NUMERO','','NisNum');return document.MM_returnValue" src="/alienorweblibre/images/valider.gif">
    </div>
</div>
<div class="spacer"> </div>
<div align="center">
    <p style="color:#FF0000; font-weight:bold"><?php echo $msg?></p>
</div>
<div id="formulaire" class="saisie">
	<form name="gestion"  action="ms_gestion.php" method="post" target="_self">
		<input name="INDEX_OBJET" type="hidden" value="<?php echo $no_fiche_objet ?>">
		<input name="ACTION" type="hidden" value="CREATION">
		<?php
switch($action){
	case 'EMPLACEMENT' : ?>
							<p class="titre">Emplacement</p>
							<table cellpadding="3" cellspacing="0" class="centpcent">
								<tr>
									<td valign="top"><span class="obligatoire">Date</span> <a href="#" onClick="RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4122)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
										<br>
										<input name="DATE_EMPLACEMENT" type="text" class="champobligatoire" size="10" value="" onBlur="champDat(this);" size="10">
									</td>
									<td valign="top"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=DSCP&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=DISCIPLINE');"><span class="obligatoire">Emplacement</span></a> <a href="#" onClick="RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1101)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
										<br>
										<input name="EMPLACEMENT" id="EMPLACEMENT" type="text" class="motcles" value="">
									<td>
									<td valign="top">&nbsp;</td>
								</tr>
							</table>
						<?php break;
	case 'ETAT' :		?>
							<p class="titre">�tat</p>
							<table cellpadding="3" cellspacing="0" class="centpcent">
								<tr>
									<td valign="top"><span class="obligatoire">Date</span> <a href="#" onClick="RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4122)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
										<br>
										<input name="DATE_CONSERVATION" type="text" class="champobligatoire" size="10" value="" onBlur="champDat(this);" size="10">
									</td>
									<td valign="top"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=DSCP&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=DISCIPLINE');"><span class="obligatoire">�tat</span></a> <a href="#" onClick="RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1101)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
										<br>
										<textarea name="ETAT_CONSERVATION" rows="3" id="ETAT_CONSERVATION"class="motcles"></textarea>
									<td>
									<td valign="top"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=DSCP&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=DISCIPLINE');"><span class="obligatoire">Expert</span></a> <a href="#" onClick="RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1101)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
										<br>
										<input name="EXPERT" id="EXPERT" type="text" class="motcles" value="">
									</td>
								</tr>
							</table>
						<?php break;
	case 'VALEUR' :		?>
						<p class="titre">Valeur</p>
							<table cellpadding="3" cellspacing="0" class="centpcent">
								<tr>
									<td valign="top"><span class="obligatoire">Date</span> <a href="#" onClick="RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4122)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
										<br>
										<input name="DATE_VALEUR" type="text" class="champobligatoire" size="10" value="" onBlur="champDat(this);" size="10">
									</td>
									<td valign="top"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=DSCP&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=DISCIPLINE');"><span class="obligatoire">Valeur</span></a> <a href="#" onClick="RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1101)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
										<br>
										<input name="Valeur" id="Valeur" type="text" class="motcles" value="">
									<td>
									<td valign="top"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=DSCP&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=DISCIPLINE');"><span class="obligatoire">Expert</span></a> <a href="#" onClick="RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1101)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
										<br>
										<input name="EXPERT" id="EXPERT" type="text" class="motcles" value="">
									</td>
								</tr>
							</table>
						<?php break;
} ?>
		<input name="FICHE_CREEE_LE" type="hidden" value="<?php echo date("Y.m.d")?>">
		<input name="FICHE_CREEE_PAR" type="hidden" value="<?php echo $_SESSION["nom"]." ".$_SESSION["prenom"]; ?>">
		<input name="CODEMUSEE" type="hidden" value="<?php echo $_SESSION["code_musee"]; ?>">
	</form>
</div>
<div><a name="FIN_FORMULAIRE"></a></div>
</body>
</html>