<?php
session_start();
require_once('../config/config.php');
	$niveau_visa = $ms;
	$page = "personne";
	$msg = "";
	$result = "";
	include('../include/securite.php');
	include('../include/base_personne.php');
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="fr">
<head>
<title>Formulaire de saisie : Personne</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../style/style_awl.css" rel="stylesheet" type="text/css" media="screen">
<link href="../style/style_awl_print.css" rel="stylesheet" type="text/css" media="print">
<script language="javascript">
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
        if (isNaN(val)) errors+='- '+nm+' doit contenir une valeur numérique.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' doit contenir un nombre compris entre '+min+' et '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' doit être rempli.\n'; }
  } (errors) ? alert('Quelques omissions ou erreurs ont été trouvées :\n'+errors) : document.personne.submit();
  document.MM_returnValue = (errors == '');
}


//-->
</script>
</head>
<body>
<?php include('../include/navigation.php'); ?>
<div id="haut">
    <h2>Formulaire de saisie Personne</h2>
</div>
<div id="s-menu">
    <div id="menu"><a href="#IDENTIFICATION">Identification</a> <span class="invisible">|</span> <a href="#ADRESSE">Adresse</a> <span class="invisible">|</span> <a href="#DOCUMENTATION">Documentation</a> <span class="invisible">|</span> <a href="#INFORMATIQUE">Gestion&nbsp;informatique</a></div>
    <div id="btnvalid">
        <input name="image" type="image" onClick="MM_validateForm('GENRE','','R','ETAT_CIVIL','','R','TYPE_PERSONNE','','R');return document.MM_returnValue" src="/alienorweblibre/images/valider.gif">
    </div>
</div>
<div class="spacer"> </div>
<div align="center">
    <p style="color:#FF0000; font-weight:bold"> <?php echo $msg?> </p>
</div>
<div id="formulaire" class="saisie">
    <form name="personne" action="<?php echo $editFormAction; ?>" method="post" target="_self">
        <?php do { ?> <?php ($duplication == 1) ? $fiche = "" : $fiche = $row_rech_personne['INDEX_PERSONNE']; ?>
        <input name="INDEX_PERSONNE" type="hidden" value="<?php echo $fiche?>">
        <div><a name="IDENTIFICATION"></a></div>
        <p class="titre">IDENTIFICATION</p>
        <table cellpadding="3" cellspacing="0" class="centpcent">
            <tr>
                <td>
                    <label for="TYPE_PERSONNE" class="obligatoire"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=TYPERS&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=TYPE_PERSONNE');">Type de personne</a></label>
                    <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,2104)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a><br>
                    <br>
                    <?php isset($_POST['TYPE_PERSONNE']) ? $valeur = $_POST['TYPE_PERSONNE'] : $valeur = $row_rech_personne['TYPE_PERSONNE']; ?>
                    <textarea name="TYPE_PERSONNE" id="TYPE_PERSONNE" rows="1" class="textarealong40"><?php echo stripslashes($valeur)?></textarea>
                </td>
                <td>
                    <label for="GENRE" class="obligatoire"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=SEXE&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=GENRE');">Genre</a></label>
                    <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,2103)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a><br>
                    <br>
                    <?php isset($_POST['GENRE']) ? $valeur = $_POST['GENRE'] : $valeur = $row_rech_personne['GENRE']; ?>
                    <input class="inputlong40" name="GENRE" id="GENRE" value="<?php echo stripslashes($valeur)?>">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="ETAT_CIVIL" class="obligatoire"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=AUT&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=ETAT_CIVIL');">&Eacute;tat civil</a></label>
                    <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,2101)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a><br>
                    <br>
                    <?php isset($_POST['ETAT_CIVIL']) ? $valeur = $_POST['ETAT_CIVIL'] : $valeur = $row_rech_personne['ETAT_CIVIL']; ?>
                    <textarea name="ETAT_CIVIL" id="ETAT_CIVIL" rows="2" class="textarealong40"><?php echo stripslashes($valeur)?></textarea>
                    <?php ($duplication == 1) ? $num_ini = "" : $num_ini = $row_rech_personne['ETAT_CIVIL']; ?>
                    <input name="ETAT_CIVIL_INIT" type="hidden" class="motcles" id="ETAT_CIVIL_INIT" value="<?php echo stripslashes($valeur)?>">
                </td>
                <td>
                    <label for="NOM_MARITAL">Nom marital</label>
                    <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,2102)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a><br>
                    <br>
                    <?php isset($_POST['NOM_MARITAL']) ? $valeur = $_POST['NOM_MARITAL'] : $valeur = $row_rech_personne['NOM_MARITAL']; ?>
                    <textarea name="NOM_MARITAL" rows="2" class="textarealong40" id="NOM_MARITAL"><?php echo stripslashes($valeur)?></textarea>
                </td>
            </tr>
            <tr valign="top">
                <td>
                    <label for="NATIONALITE_NAISSANCE">Nationalit&eacute; de naissance</label>
                    <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,2106)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a><br>
                    <br>
                    <?php isset($_POST['NATIONALITE_NAISSANCE']) ? $valeur = $_POST['NATIONALITE_NAISSANCE'] : $valeur = $row_rech_personne['NATIONALITE_NAISSANCE']; ?>
                    <textarea name="NATIONALITE_NAISSANCE" rows="2" class="textarealong40" id="NATIONALITE_NAISSANCE"><?php echo stripslashes($valeur)?></textarea>
                </td>
                <td>
                    <label for="ECOLE_NATIONALITE"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=ECOLE&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=ECOLE_NATIONALITE');">&Eacute;cole ou nationalit&eacute;</a></label>
                    <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,2105)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a><br>
                    <br>
                    <?php isset($_POST['ECOLE_NATIONALITE']) ? $valeur = $_POST['ECOLE_NATIONALITE'] : $valeur = $row_rech_personne['ECOLE_NATIONALITE']; ?>
                    <textarea name="ECOLE_NATIONALITE" rows="2" class="textarealong40" id="ECOLE_NATIONALITE"><?php echo stripslashes($valeur)?></textarea>
                </td>
            </tr>
        </table>
        <table cellpadding="3" cellspacing="0">
            <tr>
                <td>
                    <label for="LIEU_NAISSANCE"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=TLIEU&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=LIEU_NAISSANCE');">Lieu de naissance</a></label>
                    </a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,2111)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a><br>
                    <br>
                    <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_lieu = "SELECT SITE FROM lieu,per_lie WHERE per_lie.INDEX_PERSONNE =".$noFiche." AND lieu.INDEX_LIEU = per_lie.INDEX_LIEU AND per_lie.QUALIFIANT = 'LIEU_NAISSANCE' ORDER BY INDEX_PER_LIE ASC";
$lieu = mysql_query($query_lieu, $alienorweblibre) or die(mysql_error());
$row_lieu = mysql_fetch_assoc($lieu);
$totalRows_lieu = mysql_num_rows($lieu);
$i = 0 ;
$result = "";
do {
	if ($i !=0 ) {
		$result .= "/";
	}
	$result .= $row_lieu['SITE'];
	$i++;
} while ($row_lieu = mysql_fetch_assoc($lieu)); ?> <?php isset($_POST['LIEU_NAISSANCE']) ? $valeur = $_POST['LIEU_NAISSANCE'] : $valeur = $result; ?>
            <textarea name="LIEU_NAISSANCE" id="LIEU_NAISSANCE" rows="2" class="textarealong40"><?php echo stripslashes($valeur)?></textarea>
            </td>
            
            <td>
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td colspan="4">Date de naissance <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,2112)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a><br>
                            </td>
                        </tr>
                        <tr>
                            <td valign="middle">Affixe<br>
                                <?php isset($_POST['NAISSANCE_TXTDATEDEBUT']) ? $valeur = $_POST['NAISSANCE_TXTDATEDEBUT'] : $valeur = $row_rech_personne['NAISSANCE_TXTDATEDEBUT']; ?>
                                <select name="NAISSANCE_TXTDATEDEBUT">
                                    <option value=""<?php if ($valeur == "") {?> selected<?php ;} ?>>--</option>
                                    <option value="le"<?php if ($valeur == "le") {?> selected<?php ;} ?>>Le</option>
                                    <option value="avant"<?php if ($valeur == "avant") {?> selected<?php ;} ?>>Avant</option>
                                    <option value="après"<?php if ($valeur == "après") {?> selected<?php ;} ?>>Apr&egrave;s</option>
                                    <option value="entre"<?php if ($valeur == "entre") {?> selected<?php ;} ?>>Entre</option>
                                    <option value="année"<?php if ($valeur == "année") {?> selected<?php ;} ?>>Ann&eacute;e</option>
                                    <option value="mois"<?php if ($valeur == "mois") {?> selected<?php ;} ?>>Mois</option>
                                </select>
                            </td>
                            <td valign="middle">Date d&eacute;but<br>
                                <?php isset($_POST['NAISSANCE_DEBDATEDEBUT']) ? $valeur = $_POST['NAISSANCE_DEBDATEDEBUT'] : $valeur = $row_rech_personne['NAISSANCE_DEBDATEDEBUT']; ?>
                                <input name="NAISSANCE_DEBDATEDEBUT" type="text" class="inputnumerique" id="NAISSANCE_DEBDATEDEBUT" onBlur="champDat(this);" value="<?php echo reverseDate($valeur)?>" maxlength="10">
                            </td>
                            <td valign="middle">et</td>
                            <td valign="middle">Date fin<br>
                                <?php isset($_POST['NAISSANCE_FINDATEDEBUT']) ? $valeur = $_POST['NAISSANCE_FINDATEDEBUT'] : $valeur = $row_rech_personne['NAISSANCE_FINDATEDEBUT']; ?>
                                <input name="NAISSANCE_FINDATEDEBUT" type="text" class="inputnumerique" id="NAISSANCE_FINDATEDEBUT" onBlur="champDat(this);" value="<?php echo reverseDate($valeur)?>" maxlength="10">
                            </td>
                        </tr>
                    </table>
              </td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>
                    <label for="LIEU_DECES"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=TLIEU&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=LIEU_DECES');">Lieu de d&eacute;c&egrave;s</a></label>
                    <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,2113)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a><br>
                    <br>
                    <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_lieu = "SELECT SITE FROM lieu,per_lie WHERE per_lie.INDEX_PERSONNE =".$noFiche." AND lieu.INDEX_LIEU = per_lie.INDEX_LIEU AND per_lie.QUALIFIANT = 'LIEU_DECES' ORDER BY INDEX_PER_LIE ASC";
$lieu = mysql_query($query_lieu, $alienorweblibre) or die(mysql_error());
$row_lieu = mysql_fetch_assoc($lieu);
$totalRows_lieu = mysql_num_rows($lieu);
$i = 0 ;
$result = "";
do {
	if ($i !=0 ) {
		$result .= "/";
	}
	$result .= $row_lieu['SITE'];
	$i++;
} while ($row_lieu = mysql_fetch_assoc($lieu)); ?> <?php isset($_POST['LIEU_DECES']) ? $valeur = $_POST['LIEU_DECES'] : $valeur = $result; ?>
                    <textarea name="LIEU_DECES" id="LIEU_DECES" rows="2" class="textarealong40"><?php echo stripslashes($valeur)?></textarea>
                </td>
                <td>
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td colspan="4">Date de d&eacute;c&egrave;s <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,2114)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a><br>
                            </td>
                        </tr>
                        <tr>
                            <td valign="middle">Affixe<br>
                                <?php isset($_POST['DECES_TXTDATEDEBUT']) ? $valeur = $_POST['DECES_TXTDATEDEBUT'] : $valeur = $row_rech_personne['DECES_TXTDATEDEBUT']; ?>
                                <select name="DECES_TXTDATEDEBUT">
                                    <option value=""<?php if ($valeur == "") {?> selected<?php ;} ?>>--</option>
                                    <option value="le"<?php if ($valeur == "le") {?> selected<?php ;} ?>>Le</option>
                                    <option value="avant"<?php if ($valeur == "avant") {?> selected<?php ;} ?>>Avant</option>
                                    <option value="après"<?php if ($valeur == "après") {?> selected<?php ;} ?>>Apr&egrave;s</option>
                                    <option value="entre"<?php if ($valeur == "entre") {?> selected<?php ;} ?>>Entre</option>
                                    <option value="année"<?php if ($valeur == "année") {?> selected<?php ;} ?>>Ann&eacute;e</option>
                                    <option value="mois"<?php if ($valeur == "mois") {?> selected<?php ;} ?>>Mois</option>
                                </select>
                            </td>
                            <td valign="middle">Date d&eacute;but<br>
                                <?php isset($_POST['DECES_DEBDATEDEBUT']) ? $valeur = $_POST['DECES_DEBDATEDEBUT'] : $valeur = $row_rech_personne['DECES_DEBDATEDEBUT']; ?>
                                <input name="DECES_DEBDATEDEBUT" type="text" class="inputnumerique" id="DECES_DEBDATEDEBUT" onBlur="champDat(this);" value="<?php echo reverseDate($valeur)?>" maxlength="10">
                            </td>
                            <td valign="middle">et</td>
                            <td valign="middle">Date fin<br>
                                <?php isset($_POST['DECES_FINDATEDEBUT']) ? $valeur = $_POST['DECES_FINDATEDEBUT'] : $valeur = $row_rech_personne['DECES_FINDATEDEBUT']; ?>
                                <input name="DECES_FINDATEDEBUT" type="text" class="inputnumerique" id="DECES_FINDATEDEBUT" onBlur="champDat(this);" value="<?php echo reverseDate($valeur)?>" maxlength="10">
                            </td>
                        </tr>
                    </table>
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>
                    <label for="LIEU_TRAVAIL"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=TLIEU&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=LIEU_TRAVAIL');">Lieu de travail</a></label>
                    <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,2115)"> <img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a><br>
                    <br>
                    <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_lieu = "SELECT SITE FROM lieu,per_lie WHERE per_lie.INDEX_PERSONNE =".$noFiche." AND lieu.INDEX_LIEU = per_lie.INDEX_LIEU AND per_lie.QUALIFIANT = 'LIEU_TRAVAIL' ORDER BY INDEX_PER_LIE ASC";
$lieu = mysql_query($query_lieu, $alienorweblibre) or die(mysql_error());
$row_lieu = mysql_fetch_assoc($lieu);
$totalRows_lieu = mysql_num_rows($lieu);
$i = 0 ;
$result = "";
do {
	if ($i !=0 ) {
		$result .= "/";
	}
	$result .= $row_lieu['SITE'];
	$i++;
} while ($row_lieu = mysql_fetch_assoc($lieu)); ?> <?php isset($_POST['LIEU_TRAVAIL']) ? $valeur = $_POST['LIEU_TRAVAIL'] : $valeur = $result; ?>
                    <textarea name="LIEU_TRAVAIL" id="LIEU_TRAVAIL" rows="2" class="textarealong40"><?php echo stripslashes($valeur)?></textarea>
                </td>
                <td align="left">
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td colspan="4">Date de fonctionnement des ateliers<br>
                                D&eacute;but <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,2116)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a></td>
                        </tr>
                        <tr>
                            <td valign="middle"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=DATE&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=LIEU_TRAVAIL_TXTDATEDEBUT');">Affixe</a><br>
                                <?php isset($_POST['LIEU_TRAVAIL_TXTDATEDEBUT']) ? $valeur = $_POST['LIEU_TRAVAIL_TXTDATEDEBUT'] : $valeur = $row_rech_personne['LIEU_TRAVAIL_TXTDATEDEBUT']; ?>
                                <input name="LIEU_TRAVAIL_TXTDATEDEBUT" type="text" class="inputnumerique" id="LIEU_TRAVAIL_TXTDATEDEBUT" value="<?php echo stripslashes($valeur)?>">
                            </td>
                            <td valign="middle">Date d&eacute;but<br>
                                <?php isset($_POST['LIEU_TRAVAIL_DEBDATEDEBUT']) ? $valeur = $_POST['LIEU_TRAVAIL_DEBDATEDEBUT'] : $valeur = $row_rech_personne['LIEU_TRAVAIL_DEBDATEDEBUT']; ?>
                                <input name="LIEU_TRAVAIL_DEBDATEDEBUT" type="text" class="inputnumerique" id="LIEU_TRAVAIL_DEBDATEDEBUT" value="<?php echo reverseDate($valeur)?>">
                            </td>
                            <td valign="middle">et</td>
                            <td valign="middle">Date fin<br>
                                <?php isset($_POST['LIEU_TRAVAIL_FINDATEDEBUT']) ? $valeur = $_POST['LIEU_TRAVAIL_FINDATEDEBUT'] : $valeur = $row_rech_personne['LIEU_TRAVAIL_FINDATEDEBUT']; ?>
                                <input name="LIEU_TRAVAIL_FINDATEDEBUT" type="text" class="inputnumerique" id="LIEU_TRAVAIL_FINDATEDEBUT" value="<?php echo reverseDate($valeur)?>">
                            </td>
                        </tr>
                    </table>
                </td>
                <td align="left">
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td colspan="4">Date de fonctionnement des ateliers<br>
                                Fin <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,2117)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a> </td>
                        </tr>
                        <tr>
                            <td valign="middle"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=DATE&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=LIEU_TRAVAIL_TXTDATEFIN');">Affixe</a><br>
                                <?php isset($_POST['LIEU_TRAVAIL_TXTDATEFIN']) ? $valeur = $_POST['LIEU_TRAVAIL_TXTDATEFIN'] : $valeur = $row_rech_personne['LIEU_TRAVAIL_TXTDATEFIN']; ?>
                                <input name="LIEU_TRAVAIL_TXTDATEFIN" type="text" class="inputnumerique" id="LIEU_TRAVAIL_TXTDATEFIN" value="<?php echo stripslashes($valeur)?>">
                            </td>
                            <td valign="middle">Date d&eacute;but<br>
                                <input name="LIEU_TRAVAIL_DEBDATEFIN" type="text" class="inputnumerique" id="LIEU_TRAVAIL_DEBDATEFIN" value="<?php echo reverseDate($valeur)?>">
                                <?php isset($_POST['LIEU_TRAVAIL_DEBDATEFIN']) ? $valeur = $_POST['LIEU_TRAVAIL_DEBDATEFIN'] : $valeur = $row_rech_personne['LIEU_TRAVAIL_DEBDATEFIN']; ?> </td>
                            <td valign="middle">et</td>
                            <td valign="middle">Date fin<br>
                                <?php isset($_POST['LIEU_TRAVAIL_FINDATEFIN']) ? $valeur = $_POST['LIEU_TRAVAIL_FINDATEFIN'] : $valeur = $row_rech_personne['LIEU_TRAVAIL_FINDATEFIN']; ?>
                                <input name="LIEU_TRAVAIL_FINDATEFIN" type="text" class="inputnumerique" id="LIEU_TRAVAIL_FINDATEFIN" value="<?php echo reverseDate($valeur)?>">
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td valign="top">
                    <label for="GALERIE"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=TLIEU&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=GALERIE');">Galerie de vente</a></label>
                    <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,2119)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a><br>
                    <br>
                    <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_lieu = "SELECT SITE FROM lieu,per_lie WHERE per_lie.INDEX_PERSONNE =".$noFiche." AND lieu.INDEX_LIEU = per_lie.INDEX_LIEU AND per_lie.QUALIFIANT = 'GALERIE' ORDER BY INDEX_PER_LIE ASC";
$lieu = mysql_query($query_lieu, $alienorweblibre) or die(mysql_error());
$row_lieu = mysql_fetch_assoc($lieu);
$totalRows_lieu = mysql_num_rows($lieu);
$i = 0 ;
$result = "";
do {
	if ($i !=0 ) {
		$result .= "/";
	}
	$result .= $row_lieu['SITE'];
	$i++;
} while ($row_lieu = mysql_fetch_assoc($lieu)); ?> <?php isset($_POST['GALERIE']) ? $valeur = $_POST['GALERIE'] : $valeur = $result; ?>
                    <textarea name="GALERIE" id="GALERIE" rows="2" class="textarealong40"><?php echo stripslashes($valeur)?></textarea>
                </td>
                <td align="left">
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td colspan="4">Date d&#8217;occupation<br>
                                D&eacute;but <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,2220)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a> </td>
                        </tr>
                        <tr>
                            <td valign="middle"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=DATE&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=GALERIE_TXTDATEDEBUT');">Affixe</a><br>
                                <?php isset($_POST['GALERIE_TXTDATEDEBUT']) ? $valeur = $_POST['GALERIE_TXTDATEDEBUT'] : $valeur = $row_rech_personne['GALERIE_TXTDATEDEBUT']; ?>
                                <input name="GALERIE_TXTDATEDEBUT" type="text" class="inputnumerique" id="GALERIE_TXTDATEDEBUT" value="<?php echo stripslashes($valeur)?>">
                            </td>
                            <td valign="middle">Date d&eacute;but<br>
                                <?php isset($_POST['GALERIE_DEBDATEDEBUT']) ? $valeur = $_POST['GALERIE_DEBDATEDEBUT'] : $valeur = $row_rech_personne['GALERIE_DEBDATEDEBUT']; ?>
                                <input name="GALERIE_DEBDATEDEBUT" type="text" class="inputnumerique" id="GALERIE_DEBDATEDEBUT" value="<?php echo reverseDate($valeur)?>">
                            </td>
                            <td valign="middle">et</td>
                            <td valign="middle">Date fin<br>
                                <?php isset($_POST['GALERIE_FINDATEDEBUT']) ? $valeur = $_POST['GALERIE_FINDATEDEBUT'] : $valeur = $row_rech_personne['GALERIE_FINDATEDEBUT']; ?>
                                <input name="GALERIE_FINDATEDEBUT" type="text" class="inputnumerique" id="GALERIE_FINDATEDEBUT" value="<?php echo reverseDate($valeur)?>">
                            </td>
                        </tr>
                    </table>
                </td>
                <td align="left" >
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td colspan="4">Date d&#8217;occupation<br>
                                Fin <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,2221)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a> </td>
                        </tr>
                        <tr>
                            <td valign="middle"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=DATE&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=GALERIE_TXTDATEFIN');">Affixe</a><br>
                                <?php isset($_POST['GALERIE_TXTDATEFIN']) ? $valeur = $_POST['GALERIE_TXTDATEFIN'] : $valeur = $row_rech_personne['GALERIE_TXTDATEFIN']; ?>
                                <input name="GALERIE_TXTDATEFIN" type="text" class="inputnumerique" id="GALERIE_TXTDATEFIN" value="<?php echo stripslashes($valeur)?>">
                            </td>
                            <td valign="middle">Date d&eacute;but<br>
                                <?php isset($_POST['GALERIE_DEBDATEFIN']) ? $valeur = $_POST['GALERIE_DEBDATEFIN'] : $valeur = $row_rech_personne['GALERIE_DEBDATEFIN']; ?>
                                <input name="GALERIE_DEBDATEFIN" type="text" class="inputnumerique" id="GALERIE_DEBDATEFIN" value="<?php echo reverseDate($valeur)?>">
                            </td>
                            <td valign="middle">et</td>
                            <td valign="middle">Date fin<br>
                                <?php isset($_POST['GALERIE_FINDATEFIN']) ? $valeur = $_POST['GALERIE_FINDATEFIN'] : $valeur = $row_rech_personne['GALERIE_FINDATEFIN']; ?>
                                <input name="GALERIE_FINDATEFIN" type="text" class="inputnumerique" id="GALERIE_FINDATEFIN" value="<?php echo reverseDate($valeur)?>">
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table cellspacing="0">
            <tr>
                <td valign="top">
                    <label id="COMMENTAIRE">Biographie</label>
                    <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,2107)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a><br>
                    <br>
                    <?php isset($_POST['COMMENTAIRE']) ? $valeur = $_POST['COMMENTAIRE'] : $valeur = $row_rech_personne['COMMENTAIRE']; ?>
                    <textarea name="COMMENTAIRE" id="COMMENTAIRE" cols="110" rows="8"><?php echo stripslashes($valeur)?></textarea>
                </td>
            </tr>
        </table>
        <div><a name="ADRESSE"></a></div>
        <p class="titre">ADRESSE</p>
        <table class="centpcent">
            <tr valign="top">
                <td>
                    <label for="LIEU_RESIDENCE"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=TLIEU&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=LIEU_RESIDENCE');">Lieu de r&eacute;sidence</a></label>
                    <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,2224)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a><br>
                    <br>
                    <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_lieu = "SELECT SITE FROM lieu,per_lie WHERE per_lie.INDEX_PERSONNE =".$noFiche." AND lieu.INDEX_LIEU = per_lie.INDEX_LIEU AND per_lie.QUALIFIANT = 'LIEU_RESIDENCE' ORDER BY INDEX_PER_LIE ASC";
$lieu = mysql_query($query_lieu, $alienorweblibre) or die(mysql_error());
$row_lieu = mysql_fetch_assoc($lieu);
$totalRows_lieu = mysql_num_rows($lieu);
$i = 0 ;
$result = "";
do {
	if ($i !=0 ) {
		$result .= "/";
	}
	$result .= $row_lieu['SITE'];
	$i++;
} while ($row_lieu = mysql_fetch_assoc($lieu)); ?> <?php isset($_POST['LIEU_RESIDENCE']) ? $valeur = $_POST['LIEU_RESIDENCE'] : $valeur = $result; ?>
                    <textarea name="LIEU_RESIDENCE" id="LIEU_RESIDENCE" rows="2" class="textarealong40"><?php echo stripslashes($valeur)?></textarea>
                </td>
                <td align="left">
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td colspan="4" valign="middle">Date de r&eacute;sidence<br>
                                Date D&eacute;but <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,2225)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a> </td>
                        </tr>
                        <tr>
                            <td valign="middle"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=DATE&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=LIEU_RESIDENCE_TXTDATEDEBUT');">Affixe</a><br>
                                <?php isset($_POST['LIEU_RESIDENCE_TXTDATEDEBUT']) ? $valeur = $_POST['LIEU_RESIDENCE_TXTDATEDEBUT'] : $valeur = $row_rech_personne['LIEU_RESIDENCE_TXTDATEDEBUT']; ?>
                                <input name="LIEU_RESIDENCE_TXTDATEDEBUT" type="text" class="inputnumerique" id="LIEU_RESIDENCE_TXTDATEDEBUT" value="<?php echo stripslashes($valeur)?>">
                            </td>
                            <td valign="middle">Date d&eacute;but<br>
                                <?php isset($_POST['LIEU_RESIDENCE_DEBDATEDEBUT']) ? $valeur = $_POST['LIEU_RESIDENCE_DEBDATEDEBUT'] : $valeur = $row_rech_personne['LIEU_RESIDENCE_DEBDATEDEBUT']; ?>
                                <input name="LIEU_RESIDENCE_DEBDATEDEBUT" type="text" class="inputnumerique" id="LIEU_RESIDENCE_DEBDATEDEBUT" value="<?php echo reverseDate($valeur)?>">
                            </td>
                            <td valign="middle">et</td>
                            <td valign="middle">Date fin<br>
                                <?php isset($_POST['LIEU_RESIDENCE_FINDATEDEBUT']) ? $valeur = $_POST['LIEU_RESIDENCE_FINDATEDEBUT'] : $valeur = $row_rech_personne['LIEU_RESIDENCE_FINDATEDEBUT']; ?>
                                <input name="LIEU_RESIDENCE_FINDATEDEBUT" type="text" class="inputnumerique" id="LIEU_RESIDENCE_FINDATEDEBUT" value="<?php echo reverseDate($valeur)?>">
                            </td>
                        </tr>
                    </table>
                </td>
                <td align="left">
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td colspan="4"><br>
                                Date Fin <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,2226)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a> </td>
                        </tr>
                        <tr>
                            <td valign="middle"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=DATE&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=LIEU_RESIDENCE_TXTDATEFIN');">Affixe</a><br>
                                <?php isset($_POST['LIEU_RESIDENCE_TXTDATEFIN']) ? $valeur = $_POST['LIEU_RESIDENCE_TXTDATEFIN'] : $valeur = $row_rech_personne['LIEU_RESIDENCE_TXTDATEFIN']; ?>
                                <input name="LIEU_RESIDENCE_TXTDATEFIN" type="text" class="inputnumerique" id="LIEU_RESIDENCE_TXTDATEFIN" value="<?php echo stripslashes($valeur)?>">
                            </td>
                            <td valign="middle">Date d&eacute;but<br>
                                <?php isset($_POST['LIEU_RESIDENCE_DEBDATEFIN']) ? $valeur = $_POST['LIEU_RESIDENCE_DEBDATEFIN'] : $valeur = $row_rech_personne['LIEU_RESIDENCE_DEBDATEFIN']; ?>
                                <input name="LIEU_RESIDENCE_DEBDATEFIN" type="text" class="inputnumerique" id="LIEU_RESIDENCE_DEBDATEFIN" value="<?php echo reverseDate($valeur)?>">
                            </td>
                            <td valign="middle">et</td>
                            <td valign="middle">Date fin<br>
                                <?php isset($_POST['LIEU_RESIDENCE_FINDATEFIN']) ? $valeur = $_POST['LIEU_RESIDENCE_FINDATEFIN'] : $valeur = $row_rech_personne['LIEU_RESIDENCE_FINDATEFIN']; ?>
                                <input name="LIEU_RESIDENCE_FINDATEFIN" type="text" class="inputnumerique" id="LIEU_RESIDENCE_FINDATEFIN" value="<?php echo reverseDate($valeur)?>">
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table class="centpcent">
            <td valign="top">
                    <label for="SITE_INTERNET">Site Internet</label>
                    <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,2222)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a><br>
                    <br>
                    <?php isset($_POST['SITE_INTERNET']) ? $valeur = $_POST['SITE_INTERNET'] : $valeur = $row_rech_personne['SITE_INTERNET']; ?>
                    <textarea name="SITE_INTERNET" rows="2" class="textarealong40" id="SITE_INTERNET"><?php echo stripslashes($valeur)?></textarea>
              </td>
                <td>
                    <label for="ADELE">Ad&egrave;le</label>
                    <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,2223)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a><br>
                    <br>
                    <?php isset($_POST['ADELE']) ? $valeur = $_POST['ADELE'] : $valeur = $row_rech_personne['ADELE']; ?>
                    <textarea name="ADELE" rows="2" class="textarealong40" id="ADELE"><?php echo stripslashes($valeur)?></textarea>
                </td>
            </tr>
        </table>
        <div><a name="documentation"></a></div>
        <p class="titre">DOCUMENTATION</p>
        <table border="0" cellspacing="0" class="centpcent">
            <tr>
                <td valign="top">Bibliographie<br>
                    <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_docum = "SELECT IDENTIFIANT FROM per_doc,documentation WHERE per_doc.INDEX_PERSONNE =".$noFiche." AND documentation.INDEX_DOCUMENTATION = per_doc.INDEX_DOCUMENTATION AND per_doc.QUALIFIANT = 'BIBLIOGRAPHIE' ORDER BY INDEX_per_doc ASC";
$docum = mysql_query($query_docum, $alienorweblibre) or die(mysql_error());
$row_docum = mysql_fetch_assoc($docum);
$totalRows_docum = mysql_num_rows($docum);
$i = 0 ;
$result = "";
do {
	if ($i !=0 ) {
		$result .= "/";
	}
	$result .= $row_docum['IDENTIFIANT'];
	$i++;
} while ($row_docum = mysql_fetch_assoc($docum)); ?> <?php isset($_POST['BIBLIOGRAPHIE']) ? $valeur = $_POST['BIBLIOGRAPHIE'] : $valeur = $result; ?>
                    <input name="BIBLIOGRAPHIE" class="inputlong40" type="text" value="<?php echo stripslashes($valeur)?>">
                </td>
                <td valign="top"> Num&eacute;ro de page<br>
                    <?php isset($_POST['BIBLIOGRAPHIE_PARAM']) ? $valeur = $_POST['BIBLIOGRAPHIE_PARAM'] : $valeur = $row_rech_personne['BIBLIOGRAPHIE_PARAM']; ?>
                    <input name="BIBLIOGRAPHIE_PARAM" type="text" class="motcles" value="<?php echo stripslashes($valeur)?>">
                </td>
            </tr>
            <tr>
                <td valign="top">Photographie<br>
                    <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_docum = "SELECT IDENTIFIANT FROM per_doc,documentation WHERE per_doc.INDEX_PERSONNE =".$noFiche." AND documentation.INDEX_DOCUMENTATION = per_doc.INDEX_DOCUMENTATION AND per_doc.QUALIFIANT = 'PHOTOGRAPHIE' ORDER BY INDEX_per_doc ASC";
$docum = mysql_query($query_docum, $alienorweblibre) or die(mysql_error());
$row_docum = mysql_fetch_assoc($docum);
$totalRows_docum = mysql_num_rows($docum);
$i = 0 ;
$result = "";
do {
	if ($i !=0 ) {
		$result .= "/";
	}
	$result .= $row_docum['IDENTIFIANT'];
	$i++;
} while ($row_docum = mysql_fetch_assoc($docum)); ?> <?php isset($_POST['PHOTOGRAPHIE']) ? $valeur = $_POST['PHOTOGRAPHIE'] : $valeur = $result; ?>
                    <input name="PHOTOGRAPHIE" class="inputlong40" type="text" value="<?php echo stripslashes($valeur)?>">
                </td>
                <td valign="top"> Image de r&eacute;p&eacute;rage 1 autre 0<br>
                    <?php isset($_POST['PHOTOGRAPHIE_PARAM']) ? $valeur = $_POST['PHOTOGRAPHIE_PARAM'] : $valeur = $row_rech_personne['PHOTOGRAPHIE_PARAM']; ?>
                    <input name="PHOTOGRAPHIE_PARAM" type="text" class="motcles" value="<?php echo stripslashes($valeur)?>">
                </td>
            </tr>
            <tr>
                <td valign="top">Exposition<br>
                    <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_docum = "SELECT IDENTIFIANT FROM per_doc,documentation WHERE per_doc.INDEX_PERSONNE =".$noFiche." AND documentation.INDEX_DOCUMENTATION = per_doc.INDEX_DOCUMENTATION AND per_doc.QUALIFIANT = 'EXPOSITION' ORDER BY INDEX_per_doc ASC";
$docum = mysql_query($query_docum, $alienorweblibre) or die(mysql_error());
$row_docum = mysql_fetch_assoc($docum);
$totalRows_docum = mysql_num_rows($docum);
$i = 0 ;
$result = "";
do {
	if ($i !=0 ) {
		$result .= "/";
	}
	$result .= $row_docum['IDENTIFIANT'];
	$i++;
} while ($row_docum = mysql_fetch_assoc($docum)); ?> <?php isset($_POST['EXPOSITION']) ? $valeur = $_POST['EXPOSITION'] : $valeur = $result; ?>
                    <input name="EXPOSITION" class="inputlong40" type="text" value="<?php echo stripslashes($valeur)?>">
                </td>
                <td valign="top"> N&deg; de catalogue<br>
                    <?php isset($_POST['EXPOSITION_PARAM']) ? $valeur = $_POST['EXPOSITION_PARAM'] : $valeur = $row_rech_personne['EXPOSITION_PARAM']; ?>
                    <input name="EXPOSITION_PARAM" type="text" class="motcles" value="<?php echo stripslashes($valeur)?>">
                </td>
            </tr>
            <tr>
                <td valign="top">C&eacute;d&eacute;rom<br>
                    <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_docum = "SELECT IDENTIFIANT FROM per_doc,documentation WHERE per_doc.INDEX_PERSONNE =".$noFiche." AND documentation.INDEX_DOCUMENTATION = per_doc.INDEX_DOCUMENTATION AND per_doc.QUALIFIANT = 'CEDEROM' ORDER BY INDEX_per_doc ASC";
$docum = mysql_query($query_docum, $alienorweblibre) or die(mysql_error());
$row_docum = mysql_fetch_assoc($docum);
$totalRows_docum = mysql_num_rows($docum);
$i = 0 ;
$result = "";
do {
	if ($i !=0 ) {
		$result .= "/";
	}
	$result .= $row_docum['IDENTIFIANT'];
	$i++;
} while ($row_docum = mysql_fetch_assoc($docum)); ?> <?php isset($_POST['CEDEROM']) ? $valeur = $_POST['CEDEROM'] : $valeur = $result; ?>
                    <input name="CEDEROM" class="inputlong40" type="text" value="<?php echo stripslashes($valeur)?>">
                </td>
                <td valign="top"> Fichier<br>
                    <?php isset($_POST['CEDEROM_PARAM']) ? $valeur = $_POST['CEDEROM_PARAM'] : $valeur = $row_rech_personne['CEDEROM_PARAM']; ?>
                    <input name="CEDEROM_PARAM" type="text" class="motcles" value="<?php echo stripslashes($valeur)?>">
                </td>
            </tr>
            <tr>
                <td valign="top">Internet<br>
                    <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_docum = "SELECT IDENTIFIANT FROM per_doc,documentation WHERE per_doc.INDEX_PERSONNE =".$noFiche." AND documentation.INDEX_DOCUMENTATION = per_doc.INDEX_DOCUMENTATION AND per_doc.QUALIFIANT = 'INTERNET' ORDER BY INDEX_per_doc ASC";
$docum = mysql_query($query_docum, $alienorweblibre) or die(mysql_error());
$row_docum = mysql_fetch_assoc($docum);
$totalRows_docum = mysql_num_rows($docum);
$i = 0 ;
$result = "";
do {
	if ($i !=0 ) {
		$result .= "/";
	}
	$result .= $row_docum['IDENTIFIANT'];
	$i++;
} while ($row_docum = mysql_fetch_assoc($docum)); ?> <?php isset($_POST['INTERNET']) ? $valeur = $_POST['INTERNET'] : $valeur = $result; ?>
                    <input name="INTERNET" class="inputlong40" type="text" value="<?php echo stripslashes($valeur)?>">
                </td>
                <td valign="top"> Lien hypertext<br>
                    <?php isset($_POST['INTERNET_PARAM']) ? $valeur = $_POST['INTERNET_PARAM'] : $valeur = $row_rech_personne['INTERNET_PARAM']; ?>
                    <input name="INTERNET_PARAM" type="text" class="motcles" value="<?php echo stripslashes($valeur)?>">
                </td>
            </tr>
            <tr>
                <td valign="top">Tapuscrit<br>
                    <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_docum = "SELECT IDENTIFIANT FROM per_doc,documentation WHERE per_doc.INDEX_PERSONNE =".$noFiche." AND documentation.INDEX_DOCUMENTATION = per_doc.INDEX_DOCUMENTATION AND per_doc.QUALIFIANT = 'TAPUSCRIT' ORDER BY INDEX_per_doc ASC";
$docum = mysql_query($query_docum, $alienorweblibre) or die(mysql_error());
$row_docum = mysql_fetch_assoc($docum);
$totalRows_docum = mysql_num_rows($docum);
$i = 0 ;
$result = "";
do {
	if ($i !=0 ) {
		$result .= "/";
	}
	$result .= $row_docum['IDENTIFIANT'];
	$i++;
} while ($row_docum = mysql_fetch_assoc($docum)); ?> <?php isset($_POST['TAPUSCRIT']) ? $valeur = $_POST['TAPUSCRIT'] : $valeur = $result; ?>
                    <input name="TAPUSCRIT" class="inputlong40" type="text" value="<?php echo stripslashes($valeur)?>">
                </td>
                <td valign="top">Texte libre<br>
                    <?php isset($_POST['TAPUSCRIT_PARAM']) ? $valeur = $_POST['TAPUSCRIT_PARAM'] : $valeur = $row_rech_personne['TAPUSCRIT_PARAM']; ?>
                    <input name="TAPUSCRIT_PARAM" type="text" class="motcles" value="<?php echo stripslashes($valeur)?>">
                </td>
            </tr>
            <tr>
                <td valign="top">Manuscrit<br>
                    <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_docum = "SELECT IDENTIFIANT FROM per_doc,documentation WHERE per_doc.INDEX_PERSONNE =".$noFiche." AND documentation.INDEX_DOCUMENTATION = per_doc.INDEX_DOCUMENTATION AND per_doc.QUALIFIANT = 'MANUSCRIT' ORDER BY INDEX_per_doc ASC";
$docum = mysql_query($query_docum, $alienorweblibre) or die(mysql_error());
$row_docum = mysql_fetch_assoc($docum);
$totalRows_docum = mysql_num_rows($docum);
$i = 0 ;
$result = "";
do {
	if ($i !=0 ) {
		$result .= "/";
	}
	$result .= $row_docum['IDENTIFIANT'];
	$i++;
} while ($row_docum = mysql_fetch_assoc($docum)); ?> <?php isset($_POST['MANUSCRIT']) ? $valeur = $_POST['MANUSCRIT'] : $valeur = $result; ?>
                    <input name="MANUSCRIT" class="inputlong40" type="text" value="<?php echo stripslashes($valeur)?>">
                </td>
                <td valign="top"> Texte libre <br>
                    <?php isset($_POST['MANUSCRIT_PARAM']) ? $valeur = $_POST['MANUSCRIT_PARAM'] : $valeur = $row_rech_personne['MANUSCRIT_PARAM']; ?>
                    <input name="MANUSCRIT_PARAM" type="text" class="motcles" value="<?php echo stripslashes($valeur)?>">
                </td>
            </tr>
            <tr>
                <td valign="top">Vid&eacute;o<br>
                    <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_docum = "SELECT IDENTIFIANT FROM per_doc,documentation WHERE per_doc.INDEX_PERSONNE =".$noFiche." AND documentation.INDEX_DOCUMENTATION = per_doc.INDEX_DOCUMENTATION AND per_doc.QUALIFIANT = 'VIDEO' ORDER BY INDEX_per_doc ASC";
$docum = mysql_query($query_docum, $alienorweblibre) or die(mysql_error());
$row_docum = mysql_fetch_assoc($docum);
$totalRows_docum = mysql_num_rows($docum);
$i = 0 ;
$result = "";
do {
	if ($i !=0 ) {
		$result .= "/";
	}
	$result .= $row_docum['IDENTIFIANT'];
	$i++;
} while ($row_docum = mysql_fetch_assoc($docum)); ?> <?php isset($_POST['VIDEO']) ? $valeur = $_POST['VIDEO'] : $valeur = $result; ?>
                    <input name="VIDEO" class="inputlong40" type="text" value="<?php echo stripslashes($valeur)?>">
                </td>
                <td valign="top">Texte libre<br>
                    <?php isset($_POST['VIDEO_PARAM']) ? $valeur = $_POST['VIDEO_PARAM'] : $valeur = $row_rech_personne['VIDEO_PARAM']; ?>
                    <input name="VIDEO_PARAM" type="text" class="motcles" value="<?php echo stripslashes($valeur)?>">
                </td>
            </tr>
            <tr>
                <td valign="top">Reproduction<br>
                    <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_docum = "SELECT IDENTIFIANT FROM per_doc,documentation WHERE per_doc.INDEX_PERSONNE =".$noFiche." AND documentation.INDEX_DOCUMENTATION = per_doc.INDEX_DOCUMENTATION AND per_doc.QUALIFIANT = 'REPRODUCTION' ORDER BY INDEX_per_doc ASC";
$docum = mysql_query($query_docum, $alienorweblibre) or die(mysql_error());
$row_docum = mysql_fetch_assoc($docum);
$totalRows_docum = mysql_num_rows($docum);
$i = 0 ;
$result = "";
do {
	if ($i !=0 ) {
		$result .= "/";
	}
	$result .= $row_docum['IDENTIFIANT'];
	$i++;
} while ($row_docum = mysql_fetch_assoc($docum)); ?> <?php isset($_POST['REPRODUCTION']) ? $valeur = $_POST['REPRODUCTION'] : $valeur = $result; ?>
                    <input name="REPRODUCTION" class="inputlong40" type="text" value="<?php echo stripslashes($valeur)?>">
                </td>
                <td valign="top"> Texte libre <br>
                    <?php isset($_POST['REPRODUCTION_PARAM']) ? $valeur = $_POST['REPRODUCTION_PARAM'] : $valeur = $row_rech_personne['REPRODUCTION_PARAM']; ?>
                    <input name="REPRODUCTION_PARAM" type="text" class="motcles" value="<?php echo stripslashes($valeur)?>">
                </td>
            </tr>
        </table>
        <div><a name="INFORMATIQUE"></a></div>
        <p class="titre">GESTION INFORMATIQUE</p>
        <table class="centpcent">
            <tr>
                <td>Copyright <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1902)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
                    <br>
					<?php ($duplication == 1) ? $noFiche = 0 : $noFiche = $noFiche; ?>
                    <?php if ($noFiche == 0 || $row_rech_personne['COPYRIGHT']=="") { ?>
						<textarea name="COPYRIGHT" rows="3" class="textarealong40"><?php echo $_SESSION["musee"]?></textarea>
                    <?php } else { ?>
                    	<textarea name="COPYRIGHT" rows="3" class="textarealong40"><?php echo $row_rech_personne['COPYRIGHT']?></textarea>
                    <?php } ?> <?php if ($noFiche != 0) { ?>
                    <input name="FICHE_CREEE_LE" type="hidden" value="<?php echo reverseDate($row_rech_personne['FICHE_CREEE_LE'])?>">
                    <?php } else { ?>
                    <input name="FICHE_CREEE_LE" type="hidden" value="<?php echo date("d.m.Y")?>">
                    <?php } ?> <?php if ($noFiche != 0) { ?>
                    <input name="FICHE_CREEE_PAR" type="hidden" value="<?php echo $row_rech_personne['FICHE_CREEE_PAR']?>">
                    <?php } else { ?>
                    <input name="FICHE_CREEE_PAR" type="hidden" value="<?php echo $_SESSION["nom"]." ".$_SESSION["prenom"]; ?>">
                    <?php } ?> <?php if ($noFiche != 0) { ?>
                    <input name="NIVEAU_VISA" type="hidden" value="<?php echo $row_rech_personne['NIVEAU_VISA']?>">
                    <?php } else { ?>
                    <input name="NIVEAU_VISA" type="hidden" value="0">
                    <?php } ?> <?php if ($noFiche != 0) { ?>
                    <input name="IDENTIFIANT_NATIONAL" type="hidden" value="<?php echo $row_rech_personne['IDENTIFIANT_NATIONAL']?>">
                    <?php } else { ?>
                    <input name="IDENTIFIANT_NATIONAL" type="hidden" value="0">
                    <?php } ?> <?php if ($noFiche != 0) { ?>
                    <input name="CODEMUSEE" type="hidden" value="<?php echo $row_rech_personne['CODEMUSEE']?>">
                    <?php } else { ?>
                    <input name="CODEMUSEE" type="hidden" value="<?php echo $_SESSION["code_musee"]; ?>">
                    <?php } ?> </td>
            </tr>
        </table>
        <?php } while ($row_rech_personne = mysql_fetch_assoc($rech_personne)); ?>
        <input type="hidden" name="MM_update" value="personne">
        <div><a name="FIN_FORMULAIRE"></a></div>
    </form>
</div>
</body>
</html>
<?php
mysql_free_result($rech_personne);
?>