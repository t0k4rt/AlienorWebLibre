<?php

require_once('../config/config.php');
	$niveau_visa = $ms;
	$page = "archeo";
	$isobjet =1;
	$msg = "";
	$result = "";
	include('../include/securite.php');
	include('../include/base_objet.php');

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="fr">
<head>
<title>Formulaire de saisie : Arch&eacute;ologie</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="pragma" content="no-cache">
<link href="../style/style_awl.css" rel="stylesheet" type="text/css" media="screen">
<link href="../style/style_awl_print.css" rel="stylesheet" type="text/css" media="print">
<link href="../include/fonctions.js" type="text/javascript">
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
<script language="JavaScript1.2" type="text/javascript" src="../include/RoboHelp_CSH.js"></script>
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
  } (errors) ? alert('Quelques omissions ou erreurs ont été trouvées :\n'+errors) : document.objets.submit();
  document.MM_returnValue = (errors == '');
}


//-->
</script>
</head>
<body>
<?php include('../include/navigation.php'); ?>
<div id="haut">
    <h2>Formulaire de saisie Arch&eacute;ologie </h2>
</div>
<div id="s-menu">
    <div id="menu"><a href="#IDENTIFICATION">D&eacute;signation</a> <span class="invisible">|</span> <a href="#DECOUVERTE">Provenance&nbsp;g&eacute;ographique</a> <span class="invisible">|</span> <a href="#DESCRIPTION">Description</a> <span class="invisible">|</span> <a href="#EXECUTION">Donn&eacute;es&nbsp;sur &nbsp;l'execution</a> <span class="invisible">|</span> <a href="#UTILISATION">Donn&eacute;es&nbsp;sur&nbsp;l'utilisation</a> <span class="invisible">|</span> <a href="#ADMINISTRATION">Information&nbsp;administrative</a> <span class="invisible">|</span> <a href="#objet_rapport">Objets&nbsp;li&eacute;s</a> <span class="invisible">|</span> <a href="#GESTION">Gestion</a> <span class="invisible">|</span> <a href="#DOCUMENTATION">Documentation</a> <span class="invisible">|</span> <a href="#INFORMATIQUE">Gestion&nbsp;informatique</a></div>
    <div id="btnvalid">
        <input name="image" type="image" onClick="MM_validateForm('NUMERO_INVENTAIRE','','R','DISCIPLINE','','R','DOMAINE','','R','NB_EXEMPLAIRE','','NisNum','LOCALISATION','','R','PROPRIETAIRE','','R','PROPRIETAIRE_TXT_DATE_PATRIMONIALE','','R','PROPRIETAIRE_DEB_DATE_PATRIMONIALE','','R','TYPE_PROPRIETE','','R','SERVICE_GESTIONNAIRE','','R','MODE_ACQUISITION','','R','LOT','','NisNum','NUMERO','','NisNum');return document.MM_returnValue" src="/alienorweblibre/images/valider.gif">
    </div>
</div>
<div class="spacer"> </div>
<div align="center">
    <p style="color:#FF0000; font-weight:bold"><?php echo $msg?></p>
</div>
<div id="formulaire" class="saisie">
    <div><a name="IDENTIFICATION"></a></div>
    <form name="objets" action="<?php echo $editFormAction; ?>" method="post" target="_self">
        <p class="titre">D&Eacute;SIGNATION</p>
        <?php do { ?> <?php ($duplication == 1) ? $fiche = "" : $fiche = $row_rech_objet['INDEX_OBJET']; ?>
        <input name="INDEX_OBJET" type="hidden" value="<?php echo $fiche?>">
        <table cellpadding="3" cellspacing="0" class="centpcent">
            <tr>
                <td valign="top"><span class="obligatoire">
                    <label for="NUMERO_INVENTAIRE">Num&eacute;ro d&#8217;inventaire</label>
                    </span> <a href="#" onClick="RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4122)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
                    <br>
                    <?php isset($_POST['NUMERO_INVENTAIRE']) ? $valeur = $_POST['NUMERO_INVENTAIRE'] : $valeur = $row_rech_objet['NUMERO_INVENTAIRE']; ?>
                    <input name="NUMERO_INVENTAIRE" id="NUMERO_INVENTAIRE" type="text" class="motcles" value="<?php echo stripslashes($valeur)?>">
                    <?php ($duplication == 1) ? $num_ini = "" : $num_ini = $row_rech_objet['NUMERO_INVENTAIRE']; ?>
                    <input name="NUMERO_INVENTAIRE_INIT" type="hidden" value="<?php echo $num_ini?>">
                </td>
                <td valign="top"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=DSCP&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=DISCIPLINE');"><span class="obligatoire">
                    <label for="DISCIPLINE">Discipline</label>
                    </span></a> <a href="#" onClick="RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1101)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
                    <br>
                    <?php isset($_POST['DISCIPLINE']) ? $valeur = $_POST['DISCIPLINE'] : $valeur = $row_rech_objet['DISCIPLINE']; ?>
                    <input name="DISCIPLINE" id="DISCIPLINE" type="text" class="motcles" value="<?php echo stripslashes($valeur)?>">
                </td>
                <td valign="top"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=DOMN&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=DOMAINE');"><span class="obligatoire">
                    <label for="DOMAINE">Domaine</label>
                    </span></a> <a href="#" onClick="RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1101)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
                    <br>
                    <?php isset($_POST['DOMAINE']) ? $valeur = $_POST['DOMAINE'] : $valeur = $row_rech_objet['DOMAINE']; ?>
                    <input name="DOMAINE" id="DOMAINE" type="text" class="motcles" value="<?php echo stripslashes($valeur)?>">
                </td>
            </tr>
            <tr>
                <td valign="top"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=DENO&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=DENOMINATION');">
                    <label for="DENOMINATION">D&eacute;nomination</label>
                    </a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1103)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
                    <br>
                    <?php isset($_POST['DENOMINATION']) ? $valeur = $_POST['DENOMINATION'] : $valeur = $row_rech_objet['DENOMINATION']; ?>
                    <input name="DENOMINATION" type="text" class="motcles" id="DENOMINATION" value="<?php echo stripslashes($valeur)?>">
                </td>
                <td valign="top">
                    <label for="TITRE">Titre</label>
                    <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1104)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
                    <br>
                    <?php isset($_POST['TITRE']) ? $valeur = $_POST['TITRE'] : $valeur = $row_rech_objet['TITRE']; ?>
                    <textarea name="TITRE" rows="3" class="textarealong40" id="TITRE"><?php echo stripslashes($valeur)?></textarea>
                </td>
                <td valign="top">Nombre d&#8217;exemplaires <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1107)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
                    <br>
                    <?php isset($_POST['NB_EXEMPLAIRE']) ? $valeur = $_POST['NB_EXEMPLAIRE'] : $valeur = $row_rech_objet['NB_EXEMPLAIRE']; ?>
                    <input name="NB_EXEMPLAIRE" type="text" class="inputnumerique" value="<?php echo stripslashes($valeur)?>">
                </td>
            </tr>
            <tr>
                <td valign="top"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=TYPOL&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=TYPOLOGIE');">Typologie</a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1108)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
                    <br>
                    <?php isset($_POST['TYPOLOGIE']) ? $valeur = $_POST['TYPOLOGIE'] : $valeur = $row_rech_objet['TYPOLOGIE']; ?>
                    <textarea name="TYPOLOGIE" rows="3" class="textarealong40"><?php echo stripslashes($valeur)?></textarea>
                </td>
                <td valign="top"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=APPEL&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=APPELATION');">
                    <label for="APPELLATION">Appellation</label>
                    </a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1105)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
                    <br>
                    <?php isset($_POST['APPELLATION']) ? $valeur = $_POST['APPELLATION'] : $valeur = $row_rech_objet['APPELLATION']; ?>
                    <textarea name="APPELLATION" rows="3" class="textarealong40" id="APPELLATION"><?php echo stripslashes($valeur)?></textarea>
                </td>
                <td valign="top"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=VERNA&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=VERNACULAIRE');">
                    <label for="VERNACULAIRE">Appellation vernaculaire</label>
                    </a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1106)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
                    <br>
                    <?php isset($_POST['VERNACULAIRE']) ? $valeur = $_POST['VERNACULAIRE'] : $valeur = $row_rech_objet['VERNACULAIRE']; ?>
                    <textarea name="VERNACULAIRE" rows="3" class="textarealong40" id="VERNACULAIRE"><?php echo stripslashes($valeur)?></textarea>
                </td>
            </tr>
            <tr>
                <td valign="top"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=TAXO&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=TAXONOMIE');">
                    <label for="TAXONOMIE">Taxonomie</label>
                    </a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1108)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
                    <br>
                    <?php isset($_POST['TAXONOMIE']) ? $valeur = $_POST['TAXONOMIE'] : $valeur = $row_rech_objet['TAXONOMIE']; ?>
                    <textarea name="TAXONOMIE" rows="3" class="textarealong40" id="TAXONOMIE"><?php echo stripslashes($valeur)?></textarea>
                </td>
                <td valign="top">&nbsp;</td>
                <td valign="top">&nbsp;</td>
            </tr>
        </table>
        <div><a name="DECOUVERTE"></a></div>
        <p class="titre">PROVENANCE G&Eacute;OGRAPHIQUE</p>
        <table cellpadding="3" cellspacing="0" class="centpcent">
            <tr>
                <td valign="top" colspan="3"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=TLIEU&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=LIEUX_DECOUVERTE');">Lieu de d&eacute;couverte </a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1201)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
                    <br>
                    <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_lieu = "SELECT SITE FROM lieu,obj_lie WHERE obj_lie.INDEX_OBJET =".$noFiche." AND lieu.INDEX_LIEU = obj_lie.INDEX_LIEU AND obj_lie.QUALIFIANT = 'LIEUX_DECOUVERTE' ORDER BY INDEX_OBJ_LIE ASC";
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
} while ($row_lieu = mysql_fetch_assoc($lieu)); ?> <?php isset($_POST['LIEUX_DECOUVERTE']) ? $valeur = $_POST['LIEUX_DECOUVERTE'] : $valeur = $result; ?>
            <input name="LIEUX_DECOUVERTE" id="LIEUX_DECOUVERTE" class="inputlong40" type="text" value="<?php echo stripslashes($valeur)?>">
            </td>
            
            </tr>
            
            <tr>
                <td valign="top"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=TYPCO&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=TYPE_COLLECTE');">
                    <label for="TYPE_COLLECTE">Type de fouille</label>
                    </a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1205)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
                    <br>
                    <?php isset($_POST['TYPE_COLLECTE']) ? $valeur = $_POST['TYPE_COLLECTE'] : $valeur = $row_rech_objet['TYPE_COLLECTE']; ?>
                    <textarea name="TYPE_COLLECTE" rows="1" class="textarealong40" id="TYPE_COLLECTE"><?php echo stripslashes($valeur)?></textarea>
                </td>
                <td valign="top">
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td colspan="4" valign="top">Date de collecte <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1202)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
                        </tr>
                        <tr>
                            <td valign="middle">Affixe<br>
                                <?php isset($_POST['TXT_DATE_DECOUVERTE']) ? $valeur = $_POST['TXT_DATE_DECOUVERTE'] : $valeur = $row_rech_objet['TXT_DATE_DECOUVERTE']; ?>
                                <select name="TXT_DATE_DECOUVERTE">
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
                                <?php isset($_POST['DEB_DATE_DECOUVERTE']) ? $valeur = $_POST['DEB_DATE_DECOUVERTE'] : $valeur = $row_rech_objet['DEB_DATE_DECOUVERTE']; ?>
                                <input name="DEB_DATE_DECOUVERTE" type="text" class="inputnumerique" onBlur="champDat(this);" value="<?php echo reverseDate($valeur)?>">
                            </td>
                            <td valign="middle">et</td>
                            <td valign="middle">Date fin<br>
                                <?php isset($_POST['FIN_DATE_DECOUVERTE']) ? $valeur = $_POST['FIN_DATE_DECOUVERTE'] : $valeur = $row_rech_objet['FIN_DATE_DECOUVERTE']; ?>
                                <input name="FIN_DATE_DECOUVERTE" type="text" class="inputnumerique" onBlur="champDat(this);" value="<?php echo reverseDate($valeur)?>">
                            </td>
                        </tr>
                    </table>
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" valign="top">
                    <label for="PRECISION_DECOUVERTE">Pr&eacute;cision sur la d&eacute;couverte</label>
                    <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1203)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
                    <br>
                    <?php isset($_POST['PRECISION_DECOUVERTE']) ? $valeur = $_POST['PRECISION_DECOUVERTE'] : $valeur = $row_rech_objet['PRECISION_DECOUVERTE']; ?>
                    <textarea name="PRECISION_DECOUVERTE" rows="5" class="textarealong60" id="PRECISION_DECOUVERTE"><?php echo stripslashes($valeur)?></textarea>
                </td>
                <td valign="top" colspan="2"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=AUT&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=INVENTEUR');">
                    <label for="INVENTEUR">Inventeur</label>
                    </a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1106)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a><br>
                    <br>
                    <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_auteur = "SELECT ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET =".$noFiche." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'INVENTEUR' ORDER BY INDEX_OBJ_PER ASC";
$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
$row_auteur = mysql_fetch_assoc($auteur);
$totalRows_auteur = mysql_num_rows($auteur);
$i = 0 ;
$result = "";
do {
	if ($i !=0 ) {
		$result .= "/";
	}
	$result .= $row_auteur['ETAT_CIVIL'];
	$i++;
} while ($row_auteur = mysql_fetch_assoc($auteur)); ?> <?php isset($_POST['INVENTEUR']) ? $valeur = $_POST['INVENTEUR'] : $valeur = $result; ?>
                    <input name="INVENTEUR" id="INVENTEUR" class="inputlong40" type="text" value="<?php echo stripslashes($valeur)?>">
                </td>
            </tr>
        </table>
        <div><a name="DESCRIPTION"></a></div>
        <p class="titre">DESCRIPTION </p>
        <table cellpadding="3" cellspacing="0" class="centpcent">
            <tr>
                <td valign="top"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=MAT&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=MATIERE');">
                    <label for="MATIERE">Mati&egrave;re</label>
                    </a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1301)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
                    <br>
                    <?php isset($_POST['MATIERE']) ? $valeur = $_POST['MATIERE'] : $valeur = $row_rech_objet['MATIERE']; ?>
                    <textarea name="MATIERE" rows="3" class="textarealong40" id="MATIERE"><?php echo stripslashes($valeur)?></textarea>
                </td>
                <td valign="top"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=TECHN&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=THECHNIQUE');">
                    <label for="TECHNIQUE">Technique</label>
                    </a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1309)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
                    <br>
                    <?php isset($_POST['TECHNIQUE']) ? $valeur = $_POST['TECHNIQUE'] : $valeur = $row_rech_objet['TECHNIQUE']; ?>
                    <textarea name="TECHNIQUE" rows="3" class="textarealong40" id="TECHNIQUE"><?php echo stripslashes($valeur)?></textarea>
                </td>
                <td valign="top">&nbsp;</td>
            </tr>
            <tr>
                <td valign="top"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=ENCOM&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=ENCOMBREMENT');">
                    <label for="ENCOMBREMENT">Encombrement</label>
                    </a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1310)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
                    <br>
                    <?php isset($_POST['ENCOMBREMENT']) ? $valeur = $_POST['ENCOMBREMENT'] : $valeur = $row_rech_objet['ENCOMBREMENT']; ?>
                    <textarea name="ENCOMBREMENT" rows="3" class="textarealong40" id="ENCOMBREMENT"><?php echo stripslashes($valeur)?></textarea>
                </td>
                <td valign="top">
                    <label for="DIMENSIONS_FORMES">Dimensions et forme</label>
                    <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1302)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
                    <br>
                    <?php isset($_POST['DIMENSIONS_FORMES']) ? $valeur = $_POST['DIMENSIONS_FORMES'] : $valeur = $row_rech_objet['DIMENSIONS_FORMES']; ?>
                    <textarea name="DIMENSIONS_FORMES" rows="3" class="textarealong40" id="DIMENSIONS_FORMES"><?php echo stripslashes($valeur)?></textarea>
                </td>
                <td valign="top">&nbsp;</td>
            </tr>
            <tr>
                <td valign="top"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=TYPIN&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=TYPE_INSCRIPTION');">
                    <label for="TYPE_INSCRIPTION">Type d&#8217;inscription</label>
                    </a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1304)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
                    <br>
                    <?php isset($_POST['TYPE_INSCRIPTION']) ? $valeur = $_POST['TYPE_INSCRIPTION'] : $valeur = $row_rech_objet['TYPE_INSCRIPTION']; ?>
                    <textarea name="TYPE_INSCRIPTION" rows="4" class="textarealong40" id="TYPE_INSCRIPTION"><?php echo stripslashes($valeur)?>
</textarea>
                </td>
                <td valign="top">
                    <label for="TRANSCRIPTION_INSCRIPTION">Transcription des inscriptions</label>
                    <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1305)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
                    <br>
                    <?php isset($_POST['TRANSCRIPTION_INSCRIPTION']) ? $valeur = $_POST['TRANSCRIPTION_INSCRIPTION'] : $valeur = $row_rech_objet['TRANSCRIPTION_INSCRIPTION']; ?>
                    <textarea name="TRANSCRIPTION_INSCRIPTION" rows="4" class="textarealong40" id="TRANSCRIPTION_INSCRIPTION"><?php echo stripslashes($valeur)?>
</textarea>
                </td>
                <td valign="top">
                    <label for="ONOMASTIQUE">Onomastique</label>
                    <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1306)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
                    <br>
                    <?php isset($_POST['ONOMASTIQUE']) ? $valeur = $_POST['ONOMASTIQUE'] : $valeur = $row_rech_objet['ONOMASTIQUE']; ?>
                    <textarea name="ONOMASTIQUE" rows="4" class="textarealong40" id="ONOMASTIQUE"><?php echo stripslashes($valeur)?>
</textarea>
                </td>
            </tr>
            <tr>
                <td colspan="3" valign="top">Description <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1308)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
                    <br>
                    <?php isset($_POST['PRECISION_DESCRIPTION']) ? $valeur = $_POST['PRECISION_DESCRIPTION'] : $valeur = $row_rech_objet['PRECISION_DESCRIPTION']; ?>
                    <textarea name="PRECISION_DESCRIPTION" rows="5" class="textarealong90"><?php echo stripslashes($valeur)?>
</textarea>
                </td>
            </tr>
            <tr>
                <td colspan="3" valign="top"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=REPDC&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=REPRESENTATION_DECOR');">Repr&eacute;sentation et d&eacute;cor</a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1307)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
                    <br>
                    <?php isset($_POST['REPRESENTATION_DECOR']) ? $valeur = $_POST['REPRESENTATION_DECOR'] : $valeur = $row_rech_objet['REPRESENTATION_DECOR']; ?>
                    <textarea name="REPRESENTATION_DECOR" rows="5" class="textarealong90"><?php echo stripslashes($valeur)?>
</textarea>
                </td>
            </tr>
        </table>
        <div><a name="EXECUTION"></a></div>
        <p class="titre">DONN&Eacute;ES SUR L&#8217;EX&Eacute;CUTION </p>
        <table cellpadding="3" cellspacing="0" class="centpcent">
            <tr>
                <td valign="top"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=AUT&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=AUTEUR');">Auteur</a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1413)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
                    <br>
                    <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_auteur = "SELECT ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET =".$noFiche." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'AUTEUR' ORDER BY INDEX_OBJ_PER ASC";
$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
$row_auteur = mysql_fetch_assoc($auteur);
$totalRows_auteur = mysql_num_rows($auteur);
$i = 0 ;
$result = "";
do {
	if ($i !=0 ) {
		$result.= "/";
	}
	$result .= $row_auteur['ETAT_CIVIL'];
	$i++;
} while ($row_auteur = mysql_fetch_assoc($auteur)); ?> <?php isset($_POST['AUTEUR']) ? $valeur = $_POST['AUTEUR'] : $valeur = $result; ?>
                    <input name="AUTEUR" class="inputlong40" type="text" value="<?php echo stripslashes($valeur)?>">
                </td>
                <td valign="top">R&ocirc;le de l&#8217;auteur <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1414)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a><br>
                    <br>
                    <?php isset($_POST['ROLE']) ? $valeur = $_POST['ROLE'] : $valeur = $row_rech_objet['ROLE']; ?>
                    <input name="ROLE" type="text" class="inputlong40" value="<?php echo stripslashes($valeur)?>">
                </td>
            </tr>
            <tr>
                <td valign="top"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=TLIEU&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=LIEU_EXECUTION');">Lieu d&#8217;ex&eacute;cution</a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1401)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a></td>
                <td valign="top"></td>
            </tr>
            <tr>
                <td valign="top"> <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_lieu = "SELECT SITE FROM lieu,obj_lie WHERE obj_lie.INDEX_OBJET =".$noFiche." AND lieu.INDEX_LIEU = obj_lie.INDEX_LIEU AND obj_lie.QUALIFIANT = 'LIEUX_EXECUTION' ORDER BY INDEX_OBJ_LIE ASC";
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
} while ($row_lieu = mysql_fetch_assoc($lieu)); ?> <?php isset($_POST['LIEUX_EXECUTION']) ? $valeur = $_POST['LIEUX_EXECUTION'] : $valeur = $result; ?>
                    <input name="LIEUX_EXECUTION" class="inputlong40" type="text" value="<?php echo stripslashes($valeur)?>">
                </td>
                <td valign="top">&nbsp;</td>
            </tr>
            <tr>
                <td valign="top"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=PERIO&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=SIECLE_MILLENAIRE');">Si&egrave;cle ou mill&eacute;naire</a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1407)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a></td>
                <td valign="top">Date de l&#8217;ex&eacute;cution <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1406)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a></td>
            </tr>
            <tr>
                <td valign="top"> <?php isset($_POST['SIECLE_MILLENAIRE']) ? $valeur = $_POST['SIECLE_MILLENAIRE'] : $valeur = $row_rech_objet['SIECLE_MILLENAIRE']; ?>
                    <textarea name="SIECLE_MILLENAIRE" rows="2" class="textarealong40"><?php echo stripslashes($valeur)?></textarea>
                </td>
                <td valign="top">
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td>Affixe</td>
                            <td>Date d&eacute;but</td>
                            <td>&nbsp;</td>
                            <td>Date fin</td>
                        </tr>
                        <tr>
                            <td> <?php isset($_POST['TXT_DATE_EXECUTION']) ? $valeur = $_POST['TXT_DATE_EXECUTION'] : $valeur = $row_rech_objet['TXT_DATE_EXECUTION']; ?>
                                <select name="TXT_DATE_EXECUTION">
                                    <option value=""<?php if ($valeur == "") {?> selected<?php ;} ?>>--</option>
                                    <option value="le"<?php if ($valeur == "le") {?> selected<?php ;} ?>>Le</option>
                                    <option value="avant"<?php if ($valeur == "avant") {?> selected<?php ;} ?>>Avant</option>
                                    <option value="après"<?php if ($valeur == "après") {?> selected<?php ;} ?>>Apr&egrave;s</option>
                                    <option value="entre"<?php if ($valeur == "entre") {?> selected<?php ;} ?>>Entre</option>
                                    <option value="année"<?php if ($valeur == "année") {?> selected<?php ;} ?>>Ann&eacute;e</option>
                                    <option value="mois"<?php if ($valeur == "mois") {?> selected<?php ;} ?>>Mois</option>
                                </select>
                            </td>
                            <td> <?php isset($_POST['DEB_DATE_EXECUTION']) ? $valeur = $_POST['DEB_DATE_EXECUTION'] : $valeur = $row_rech_objet['DEB_DATE_EXECUTION']; ?>
                                <input name="DEB_DATE_EXECUTION" type="text" class="inputnumerique" onBlur="champDat(this);" value="<?php echo reverseDate($valeur)?>">
                            </td>
                            <td>et</td>
                            <td> <?php isset($_POST['FIN_DATE_EXECUTION']) ? $valeur = $_POST['FIN_DATE_EXECUTION'] : $valeur = $row_rech_objet['FIN_DATE_EXECUTION']; ?>
                                <input name="FIN_DATE_EXECUTION" type="text" class="inputnumerique" onBlur="champDat(this);" value="<?php echo reverseDate($valeur)?>">
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td valign="top">Pr&eacute;cision sur la datation <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1409)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a></td>
                <td valign="top"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=EPOQU&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=EPOQUE_STYLE');">Style</a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1408)"> <img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a></td>
            </tr>
            <tr>
                <td valign="top"> <?php isset($_POST['PRECISION_DATATION']) ? $valeur = $_POST['PRECISION_DATATION'] : $valeur = $row_rech_objet['PRECISION_DATATION']; ?>
                    <textarea name="PRECISION_DATATION" rows="4" class="textarealong40"><?php echo stripslashes($valeur)?>
</textarea>
                </td>
                <td valign="top"> <?php isset($_POST['EPOQUE_STYLE']) ? $valeur = $_POST['EPOQUE_STYLE'] : $valeur = $row_rech_objet['EPOQUE_STYLE']; ?>
                    <textarea name="EPOQUE_STYLE" rows="4" class="textarealong40"><?php echo stripslashes($valeur)?>
</textarea>
                </td>
            </tr>
            <tr>
                <td valign="top">Pr&eacute;cision sur la gen&egrave;se <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1409)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a></td>
                <td valign="top">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" valign="top"> <?php isset($_POST['PRECISION_GENESE']) ? $valeur = $_POST['PRECISION_GENESE'] : $valeur = $row_rech_objet['PRECISION_GENESE']; ?>
                    <textarea name="PRECISION_GENESE" rows="3" class="textarealong90"><?php echo stripslashes($valeur)?>
</textarea>
                </td>
            </tr>
            <tr>
                <td valign="top">Sources de la repr&eacute;sentation <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1410)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a></td>
                <td valign="top">Date de la repr&eacute;sentation <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1411)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a></td>
            </tr>
            <tr>
                <td valign="top"> <?php isset($_POST['SOURCE_ORALE_ECRITE']) ? $valeur = $_POST['SOURCE_ORALE_ECRITE'] : $valeur = $row_rech_objet['SOURCE_ORALE_ECRITE']; ?>
                    <textarea name="SOURCE_ORALE_ECRITE" rows="3" class="textarealong40"><?php echo stripslashes($valeur)?>
</textarea>
                </td>
                <td valign="top">
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=DATE&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=TXT_DATE_REPRESENTATION');">Affixe</a></td>
                            <td>Date d&eacute;but</td>
                            <td>&nbsp;</td>
                            <td>Date fin</td>
                        </tr>
                        <tr>
                            <td> <?php isset($_POST['TXT_DATE_REPRESENTATION']) ? $valeur = $_POST['TXT_DATE_REPRESENTATION'] : $valeur = $row_rech_objet['TXT_DATE_REPRESENTATION']; ?>
                                <input name="TXT_DATE_REPRESENTATION" type="text" class="inputnumerique" value="<?php echo stripslashes($valeur)?>">
                            </td>
                            <td> <?php isset($_POST['DEB_DATE_REPRESENTATION']) ? $valeur = $_POST['DEB_DATE_REPRESENTATION'] : $valeur = $row_rech_objet['DEB_DATE_REPRESENTATION']; ?>
                                <input name="DEB_DATE_REPRESENTATION" type="text" class="inputnumerique" value="<?php echo reverseDate($valeur)?>">
                            </td>
                            <td>et</td>
                            <td> <?php isset($_POST['FIN_DATE_REPRESENTATION']) ? $valeur = $_POST['FIN_DATE_REPRESENTATION'] : $valeur = $row_rech_objet['FIN_DATE_REPRESENTATION']; ?>
                                <input name="FIN_DATE_REPRESENTATION" type="text" class="inputnumerique" value="<?php echo reverseDate($valeur)?>">
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td valign="top">Datation original copi&eacute; <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1412)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a></td>
                <td valign="top">&nbsp;</td>
            </tr>
            <tr>
                <td valign="top">
                    <table cellspacing="0">
                        <tr>
                            <td>Affixe</td>
                            <td>Date d&eacute;but</td>
                            <td>&nbsp;</td>
                            <td>Date fin</td>
                        </tr>
                        <tr>
                            <td> <?php isset($_POST['TXT_DATE_ORIGINAL_COPIE']) ? $valeur = $_POST['TXT_DATE_ORIGINAL_COPIE'] : $valeur = $row_rech_objet['TXT_DATE_ORIGINAL_COPIE']; ?>
                                <select name="TXT_DATE_ORIGINAL_COPIE">
                                    <option value="" <?php if ($valeur == "") {?>selected<?php ;} ?>>--</option>
                                    <option value="le" <?php if ($valeur == "le") {?>selected<?php ;} ?>>Le</option>
                                    <option value="avant" <?php if ($valeur == "avant") {?>selected<?php ;} ?>>Avant</option>
                                    <option value="après" <?php if ($valeur == "après") {?>selected<?php ;} ?>>Apr&egrave;s</option>
                                    <option value="entre" <?php if ($valeur == "entre") {?>selected<?php ;} ?>>Entre</option>
                                    <option value="année" <?php if ($valeur == "année") {?>selected<?php ;} ?>>Ann&eacute;e</option>
                                    <option value="mois" <?php if ($valeur == "mois") {?>selected<?php ;} ?>>Mois</option>
                                </select>
                            </td>
                            <td> <?php isset($_POST['DEB_DATE_ORIGINAL_COPIE']) ? $valeur = $_POST['DEB_DATE_ORIGINAL_COPIE'] : $valeur = $row_rech_objet['DEB_DATE_ORIGINAL_COPIE']; ?>
                                <input name="DEB_DATE_ORIGINAL_COPIE" type="text" class="inputnumerique" onBlur="champDat(this);" value="<?php echo reverseDate($valeur)?>" maxlength="10">
                            </td>
                            <td>et</td>
                            <td> <?php isset($_POST['FIN_DATE_ORIGINAL_COPIE']) ? $valeur = $_POST['FIN_DATE_ORIGINAL_COPIE'] : $valeur = $row_rech_objet['FIN_DATE_ORIGINAL_COPIE']; ?>
                                <input name="FIN_DATE_ORIGINAL_COPIE" type="text" class="inputnumerique" onBlur="champDat(this);" value="<?php echo reverseDate($valeur)?>" maxlength="10">
                            </td>
                        </tr>
                    </table>
                </td>
                <td valign="top">&nbsp;</td>
            </tr>
        </table>
        <div><a name="UTILISATION"></a></div>
        <p class="titre">DONN&Eacute;ES SUR L&#8217;UTILISATION</p>
        <table border="0" cellspacing="0" class="centpcent">
            <tr>
                <td valign="top"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=AUT&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=UTILISATEUR');">Utilisateur</a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1508)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a><br>
                    <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_auteur = "SELECT ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET =".$noFiche." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'UTILISATEUR' ORDER BY INDEX_OBJ_PER ASC";
$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
$row_auteur = mysql_fetch_assoc($auteur);
$totalRows_auteur = mysql_num_rows($auteur);
$i = 0 ;
$result = "";
do {
	if ($i !=0 ) {
		$result .= "/";
	}
	$result .= $row_auteur['ETAT_CIVIL'];
	$i++;
} while ($row_auteur = mysql_fetch_assoc($auteur)); ?> <?php isset($_POST['UTILISATEUR']) ? $valeur = $_POST['UTILISATEUR'] : $valeur = $result; ?>
                    <input name="UTILISATEUR" class="inputlong40" type="text" value="<?php echo stripslashes($valeur)?>">
                </td>
                <td valign="top"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=TLIEU&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=LIEUX_UTILISATION');">Lieux d&#8217;utilisation</a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1507)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
                    <br>
                    <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_lieu = "SELECT SITE FROM lieu,obj_lie WHERE obj_lie.INDEX_OBJET =".$noFiche." AND lieu.INDEX_LIEU = obj_lie.INDEX_LIEU AND obj_lie.QUALIFIANT = 'LIEUX_UTILISATION' ORDER BY INDEX_OBJ_LIE ASC";
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
} while ($row_lieu = mysql_fetch_assoc($lieu)); ?> <?php isset($_POST['LIEUX_UTILISATION']) ? $valeur = $_POST['LIEUX_UTILISATION'] : $valeur = $result; ?>
                    <input name="LIEUX_UTILISATION" class="inputlong40" type="text" value="<?php echo stripslashes($valeur)?>">
                </td>
            </tr>
            <tr valign="top">
                <td><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=UTIL&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=UTILISATION');">Utilisation</a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1501)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
                    <br>
                    <?php isset($_POST['UTILISATION']) ? $valeur = $_POST['UTILISATION'] : $valeur = $row_rech_objet['UTILISATION']; ?>
                    <textarea name="UTILISATION" rows="3" class="textarealong40"><?php echo stripslashes($valeur)?>
</textarea>
                </td>
                <td valign="top">
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td colspan="4">Date de l&#8217;utilisation <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1504)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
                        </tr>
                        <tr>
                            <td>Affixe<br>
                                <?php isset($_POST['TXT_DATE_UTILISATION']) ? $valeur = $_POST['TXT_DATE_UTILISATION'] : $valeur = $row_rech_objet['TXT_DATE_UTILISATION']; ?>
                                <select name="TXT_DATE_UTILISATION">
                                    <option value=""<?php if ($valeur == "") {?> selected<?php ;} ?>>--</option>
                                    <option value="le"<?php if ($valeur == "le") {?> selected<?php ;} ?>>Le</option>
                                    <option value="avant"<?php if ($valeur == "avant") {?> selected<?php ;} ?>>Avant</option>
                                    <option value="après"<?php if ($valeur == "après") {?> selected<?php ;} ?>>Apr&egrave;s</option>
                                    <option value="entre"<?php if ($valeur == "entre") {?> selected<?php ;} ?>>Entre</option>
                                    <option value="année"<?php if ($valeur == "année") {?> selected<?php ;} ?>>Ann&eacute;e</option>
                                    <option value="mois"<?php if ($valeur == "mois") {?> selected<?php ;} ?>>Mois</option>
                                </select>
                            </td>
                            <td>Date d&eacute;but<br>
                                <?php isset($_POST['DEB_DATE_UTILISATION']) ? $valeur = $_POST['DEB_DATE_UTILISATION'] : $valeur = $row_rech_objet['DEB_DATE_UTILISATION']; ?>
                                <input name="DEB_DATE_UTILISATION" type="text" class="inputnumerique" onBlur="champDat(this);" value="<?php echo reverseDate($valeur)?>">
                            </td>
                            <td valign="bottom">et</td>
                            <td>Date fin<br>
                                <?php isset($_POST['FIN_DATE_UTILISATION']) ? $valeur = $_POST['FIN_DATE_UTILISATION'] : $valeur = $row_rech_objet['FIN_DATE_UTILISATION']; ?>
                                <input name="FIN_DATE_UTILISATION" type="text" class="inputnumerique" onBlur="champDat(this);" value="<?php echo reverseDate($valeur)?>">
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td valign="top">
                    <label for="PRECISION_UTILISATION">Pr&eacute;cision sur l&#8217;utilisation</label>
                    <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1502)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
                    <br>
                    <?php isset($_POST['PRECISION_UTILISATION']) ? $valeur = $_POST['PRECISION_UTILISATION'] : $valeur = $row_rech_objet['PRECISION_UTILISATION']; ?>
                    <textarea name="PRECISION_UTILISATION" rows="5" class="textarealong40" id="PRECISION_UTILISATION"><?php echo stripslashes($valeur)?>
</textarea>
                </td>
                <td valign="top">
                    <label for="UTILISATION_SECONDE">Pr&eacute;cision sur l&#8217;utilisation seconde</label>
                    <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1505)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
                    <br>
                    <?php isset($_POST['UTILISATION_SECONDE']) ? $valeur = $_POST['UTILISATION_SECONDE'] : $valeur = $row_rech_objet['UTILISATION_SECONDE']; ?>
                    <textarea name="UTILISATION_SECONDE" rows="5" class="textarealong40" id="UTILISATION_SECONDE"><?php echo stripslashes($valeur)?>
</textarea>
                </td>
            </tr>
            <tr>
                <td valign="top">
                    <label for="DATATION_CONTEXTE">Datation du contexte</label>
                    <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1409)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
                    <br>
                    <?php isset($_POST['DATATION_CONTEXTE']) ? $valeur = $_POST['DATATION_CONTEXTE'] : $valeur = $row_rech_objet['DATATION_CONTEXTE']; ?>
                    <textarea name="DATATION_CONTEXTE" rows="5" class="textarealong40" id="DATATION_CONTEXTE"><?php echo stripslashes($valeur)?>
                    </textarea>
                </td>
                <td valign="top">&nbsp;</td>
            </tr>
        </table>
        <div><a name="ADMINISTRATION"></a></div>
        <p class="titre">INFORMATION ADMINISTRATIVE</p>
        <table cellpadding="3" cellspacing="0" class="centpcent">
            <tr valign="top">
                <td><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=TLIEU&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=LOCALISATION');"><span class="obligatoire">Localisation</span></a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1601)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
                    <br>
                    <?php isset($_POST['LOCALISATION']) ? $valeur = $_POST['LOCALISATION'] : $valeur = $row_rech_objet['LOCALISATION']; ?>
                    <input name="LOCALISATION" type="text" class="inputlong40" value="<?php echo stripslashes($valeur)?>">
                </td>
                <td><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=AUT&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=PROPRIETAIRE');"><span class="obligatoire">Propri&eacute;taire</span></a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1617)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
                    <br>
                    <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_auteur = "SELECT ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET =".$noFiche." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'PROPRIETAIRE' ORDER BY INDEX_OBJ_PER ASC";
$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
$row_auteur = mysql_fetch_assoc($auteur);
$totalRows_auteur = mysql_num_rows($auteur);
$result = "";
do {
	$result .= $row_auteur['ETAT_CIVIL'];
} while ($row_auteur = mysql_fetch_assoc($auteur)); ?> <?php isset($_POST['PROPRIETAIRE']) ? $valeur = $_POST['PROPRIETAIRE'] : $valeur = $result; ?>
                    <input name="PROPRIETAIRE" class="inputlong40" type="text" value="<?php echo stripslashes($valeur)?>">
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr valign="top">
                <td>
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td colspan="4"><span class="obligatoire">Date d&#8217;acquisition</span> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1619)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
                        </tr>
                        <tr>
                            <td>Affixe<br>
                                <?php isset($_POST['PROPRIETAIRE_TXT_DATE_PATRIMONIALE']) ? $valeur = $_POST['PROPRIETAIRE_TXT_DATE_PATRIMONIALE'] : $valeur = $row_rech_objet['PROPRIETAIRE_TXT_DATE_PATRIMONIALE']; ?>
                                <select name="PROPRIETAIRE_TXT_DATE_PATRIMONIALE" class="champobligatoire">
                                    <option value=""<?php if ($valeur == "") {?> selected<?php ;} ?>>--</option>
                                    <option value="le"<?php if ($valeur == "le") {?> selected<?php ;} ?>>Le</option>
                                    <option value="avant"<?php if ($valeur == "avant") {?> selected<?php ;} ?>>Avant</option>
                                    <option value="après"<?php if ($valeur == "après") {?> selected<?php ;} ?>>Apr&egrave;s</option>
                                    <option value="entre"<?php if ($valeur == "entre") {?> selected<?php ;} ?>>Entre</option>
                                    <option value="année"<?php if ($valeur == "année") {?> selected<?php ;} ?>>Ann&eacute;e</option>
                                    <option value="mois"<?php if ($valeur == "mois") {?> selected<?php ;} ?>>Mois</option>
                                </select>
                            </td>
                            <td valign="bottom">Date d&eacute;but<br>
                                <?php isset($_POST['PROPRIETAIRE_DEB_DATE_PATRIMONIALE']) ? $valeur = $_POST['PROPRIETAIRE_DEB_DATE_PATRIMONIALE'] : $valeur = $row_rech_objet['PROPRIETAIRE_DEB_DATE_PATRIMONIALE']; ?>
                                <input name="PROPRIETAIRE_DEB_DATE_PATRIMONIALE" type="text"  maxlength="10" class="inputnumerique" value="<?php echo reverseDate($valeur)?>" onBlur="champDat(this);">
                            </td>
                            <td valign="bottom">et</td>
                            <td>Date fin<br>
                                <?php isset($_POST['PROPRIETAIRE_FIN_DATE_PATRIMONIALE']) ? $valeur = $_POST['PROPRIETAIRE_FIN_DATE_PATRIMONIALE'] : $valeur = $row_rech_objet['PROPRIETAIRE_FIN_DATE_PATRIMONIALE']; ?>
                                <input name="PROPRIETAIRE_FIN_DATE_PATRIMONIALE" type="text" class="inputnumerique" onBlur="champDat(this);" value="<?php echo reverseDate($valeur)?>"  maxlength="10">
                            </td>
                        </tr>
                    </table>
                </td>
                <td><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=TYPRO&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=TYPE_PROPRIETE');"><span class="obligatoire">Type de propri&eacute;t&eacute;</span></a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1618)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
                    <br>
                    <?php isset($_POST['TYPE_PROPRIETE']) ? $valeur = $_POST['TYPE_PROPRIETE'] : $valeur = $row_rech_objet['TYPE_PROPRIETE']; ?>
                    <input type="text"  name="TYPE_PROPRIETE" class="inputlong40" value="<?php echo stripslashes($valeur)?>">
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr valign="top">
                <td><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=AUT&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=SERVICE_GESTIONNAIRE');"><span class="obligatoire">Service gestionnaire</span></a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1624)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
                    <br>
                    <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_auteur = "SELECT ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET =".$noFiche." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'SERVICE_GESTIONNAIRE' ORDER BY INDEX_OBJ_PER ASC";
$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
$row_auteur = mysql_fetch_assoc($auteur);
$totalRows_auteur = mysql_num_rows($auteur);
$i = 0 ;
$result = "";
do {
	if ($i !=0 ) {
		$result .= "/";
	}
	$result .= $row_auteur['ETAT_CIVIL'];
	$i++;
} while ($row_auteur = mysql_fetch_assoc($auteur)); ?> <?php isset($_POST['SERVICE_GESTIONNAIRE']) ? $valeur = $_POST['SERVICE_GESTIONNAIRE'] : $valeur = $result; ?>
                    <input name="SERVICE_GESTIONNAIRE" class="inputlong40" type="text" value="<?php echo stripslashes($valeur)?>">
                </td>
                <td>Pr&eacute;cision administrative <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1613)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
                    <br>
                    <?php isset($_POST['PRECISION_ADMINISTRATIVE']) ? $valeur = $_POST['PRECISION_ADMINISTRATIVE'] : $valeur = $row_rech_objet['PRECISION_ADMINISTRATIVE']; ?>
                    <textarea name="PRECISION_ADMINISTRATIVE" rows="3" class="textarealong40"><?php echo stripslashes($valeur)?>
</textarea>
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr valign="top">
                <td><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=MACQ&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=MODE_ACQUISITION');"><span class="obligatoire">Mode d&#8217;acquisition</span></a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1603)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
                    <br>
                    <?php isset($_POST['MODE_ACQUISITION']) ? $valeur = $_POST['MODE_ACQUISITION'] : $valeur = $row_rech_objet['MODE_ACQUISITION']; ?>
                    <textarea name="MODE_ACQUISITION" rows="1" class="textarealong40"><?php echo stripslashes($valeur)?>
</textarea>
                </td>
                <td>Lot <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1605)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
                    <br>
                    <?php isset($_POST['LOT']) ? $valeur = $_POST['LOT'] : $valeur = $row_rech_objet['LOT']; ?>
                    <input name="LOT" type="text" class="inputnumerique" value="<?php echo stripslashes($valeur)?>">
                </td>
                <td>N&deg; <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1606)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
                    <br>
                    <?php isset($_POST['NUMERO']) ? $valeur = $_POST['NUMERO'] : $valeur = $row_rech_objet['NUMERO']; ?>
                    <input name="NUMERO" type="text" class="inputnumerique" value="<?php echo stripslashes($valeur)?>" maxlength="20">
                </td>
            </tr>
            <tr>
                <td valign="top"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=AUT&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=ANCIENNE_APPARTENANCE');">Ancienne appartenance</a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1614)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
                    <br>
                    <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_auteur = "SELECT ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET =".$noFiche." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'ANCIENNE_APPARTENANCE' ORDER BY INDEX_OBJ_PER ASC";
$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
$row_auteur = mysql_fetch_assoc($auteur);
$totalRows_auteur = mysql_num_rows($auteur);
$i = 0 ;
$result = "";
do {
	if ($i !=0 ) {
		$result .= "/";
	}
	$result .= $row_auteur['ETAT_CIVIL'];
	$i++;
} while ($row_auteur = mysql_fetch_assoc($auteur)); ?> <?php isset($_POST['ANCIENNE_APPARTENANCE']) ? $valeur = $_POST['ANCIENNE_APPARTENANCE'] : $valeur = $result; ?>
                    <input name="ANCIENNE_APPARTENANCE" class="inputlong40" type="text" value="<?php echo stripslashes($valeur)?>">
                </td>
                <td valign="top">
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td colspan="4">Date d&#8217;entr&eacute;e dans collection <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1615)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
                        </tr>
                        <tr>
                            <td><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=DATE&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=ANCIENNE_APPARTENANCE_TXT_DATE_PATRIMONIALE');">Affixe</a><br>
                                <?php isset($_POST['ANCIENNE_APPARTENANCE_TXT_DATE_PATRIMONIALE']) ? $valeur = $_POST['ANCIENNE_APPARTENANCE_TXT_DATE_PATRIMONIALE'] : $valeur = $row_rech_objet['ANCIENNE_APPARTENANCE_TXT_DATE_PATRIMONIALE']; ?>
                                <input name="ANCIENNE_APPARTENANCE_TXT_DATE_PATRIMONIALE" type="text" class="inputnumerique" value="<?php echo stripslashes($valeur)?>">
                            </td>
                            <td>Date d&eacute;but<br>
                                <?php isset($_POST['ANCIENNE_APPARTENANCE_DEB_DATE_PATRIMONIALE']) ? $valeur = $_POST['ANCIENNE_APPARTENANCE_DEB_DATE_PATRIMONIALE'] : $valeur = $row_rech_objet['ANCIENNE_APPARTENANCE_DEB_DATE_PATRIMONIALE']; ?>
                                <input name="ANCIENNE_APPARTENANCE_DEB_DATE_PATRIMONIALE" type="text" class="inputnumerique" value="<?php echo reverseDate($valeur)?>">
                            </td>
                            <td valign="bottom">et</td>
                            <td>Date fin<br>
                                <?php isset($_POST['ANCIENNE_APPARTENANCE_FIN_DATE_PATRIMONIALE']) ? $valeur = $_POST['ANCIENNE_APPARTENANCE_FIN_DATE_PATRIMONIALE'] : $valeur = $row_rech_objet['ANCIENNE_APPARTENANCE_FIN_DATE_PATRIMONIALE']; ?>
                                <input name="ANCIENNE_APPARTENANCE_FIN_DATE_PATRIMONIALE" type="text" class="inputnumerique" value="<?php echo reverseDate($valeur)?>">
                            </td>
                        </tr>
                    </table>
                </td>
                <td>N&deg; de catalogue <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1616)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
                    <br>
                    <?php isset($_POST['NUMERO_CATALOGUE']) ? $valeur = $_POST['NUMERO_CATALOGUE'] : $valeur = $row_rech_objet['NUMERO_CATALOGUE']; ?>
                    <input name="NUMERO_CATALOGUE" type="text" size="20" value="<?php echo stripslashes($valeur)?>">
                </td>
            </tr>
            <tr>
                <td valign="top"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=AUT&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=COMMISSAIRE_PRISEUR');">Commissaire priseur</a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1620)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
                    <br>
                    <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_auteur = "SELECT ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET =".$noFiche." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'COMMISSAIRE_PRISEUR' ORDER BY INDEX_OBJ_PER ASC";
$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
$row_auteur = mysql_fetch_assoc($auteur);
$totalRows_auteur = mysql_num_rows($auteur);
$i = 0 ;
$result = "";
do {
	if ($i !=0 ) {
		$result .= "/";
	}
	$result .= $row_auteur['ETAT_CIVIL'];
	$i++;
} while ($row_auteur = mysql_fetch_assoc($auteur)); ?> <?php isset($_POST['COMMISSAIRE_PRISEUR']) ? $valeur = $_POST['COMMISSAIRE_PRISEUR'] : $valeur = $result; ?>
                    <input name="COMMISSAIRE_PRISEUR" class="inputlong40" type="text" value="<?php echo stripslashes($valeur)?>">
                </td>
                <td valign="top">
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td colspan="4">Date d&#8217;entr&eacute;e dans collection <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1615)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
                        </tr>
                        <tr>
                            <td>Affixe<br>
                                <?php isset($_POST['COMMISSAIRE_PRISEUR_TXT_DATE_PATRIMONIALE']) ? $valeur = $_POST['COMMISSAIRE_PRISEUR_TXT_DATE_PATRIMONIALE'] : $valeur = $row_rech_objet['COMMISSAIRE_PRISEUR_TXT_DATE_PATRIMONIALE']; ?>
                                <input name="COMMISSAIRE_PRISEUR_TXT_DATE_PATRIMONIALE" type="text" class="inputnumerique" value="<?php echo stripslashes($valeur)?>">
                            </td>
                            <td>Date d&eacute;but<br>
                                <?php isset($_POST['COMMISSAIRE_PRISEUR_DEB_DATE_PATRIMONIALE']) ? $valeur = $_POST['COMMISSAIRE_PRISEUR_DEB_DATE_PATRIMONIALE'] : $valeur = $row_rech_objet['COMMISSAIRE_PRISEUR_DEB_DATE_PATRIMONIALE']; ?>
                                <input name="COMMISSAIRE_PRISEUR_DEB_DATE_PATRIMONIALE" type="text" class="inputnumerique" value="<?php echo reverseDate($valeur)?>">
                            </td>
                            <td valign="bottom">et</td>
                            <td>Date fin<br>
                                <?php isset($_POST['COMMISSAIRE_PRISEUR_FIN_DATE_PATRIMONIALE']) ? $valeur = $_POST['COMMISSAIRE_PRISEUR_FIN_DATE_PATRIMONIALE'] : $valeur = $row_rech_objet['COMMISSAIRE_PRISEUR_FIN_DATE_PATRIMONIALE']; ?>
                                <input name="COMMISSAIRE_PRISEUR_FIN_DATE_PATRIMONIALE" type="text" class="inputnumerique" value="<?php echo reverseDate($valeur)?>">
                            </td>
                        </tr>
                    </table>
                </td>
                <td>N&deg; de catalogue <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1616)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
                    <br>
                    <?php isset($_POST['COMMISSAIRE_PRISEUR_FIN_DATE_PATRIMONIALE']) ? $valeur = $_POST['COMMISSAIRE_PRISEUR_FIN_DATE_PATRIMONIALE'] : $valeur = $row_rech_objet['COMMISSAIRE_PRISEUR_FIN_DATE_PATRIMONIALE']; ?>
                    <input name="COMMISSAIRE_PRISEUR_NUMERO_CATALOGUE" type="text" size="20" value="<?php echo stripslashes($valeur)?>">
                </td>
            </tr>
            <tr>
                <td valign="top"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=AUT&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=GALERIE');">Galerie</a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1623)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
                    <br>
                    <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_auteur = "SELECT ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET =".$noFiche." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'GALERIE' ORDER BY INDEX_OBJ_PER ASC";
$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
$row_auteur = mysql_fetch_assoc($auteur);
$totalRows_auteur = mysql_num_rows($auteur);
$i = 0 ;
$result = "";
do {
	if ($i !=0 ) {
		$result .= "/";
	}
	$result .= $row_auteur['ETAT_CIVIL'];
	$i++;
} while ($row_auteur = mysql_fetch_assoc($auteur)); ?> <?php isset($_POST['GALERIE']) ? $valeur = $_POST['GALERIE'] : $valeur = $result; ?>
                    <input name="GALERIE" class="inputlong40" type="text" value="<?php echo stripslashes($valeur)?>">
                </td>
                <td valign="top">
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td colspan="4">Date <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1615)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
                        </tr>
                        <tr>
                            <td>Affixe<br>
                                <?php isset($_POST['GALERIE_TXT_DATE_PATRIMONIALE']) ? $valeur = $_POST['GALERIE_TXT_DATE_PATRIMONIALE'] : $valeur = $row_rech_objet['GALERIE_TXT_DATE_PATRIMONIALE']; ?>
                                <input name="GALERIE_TXT_DATE_PATRIMONIALE" type="text" class="inputnumerique" value="<?php echo stripslashes($valeur)?>">
                            </td>
                            <td>Date d&eacute;but<br>
                                <?php isset($_POST['GALERIE_DEB_DATE_PATRIMONIALE']) ? $valeur = $_POST['GALERIE_DEB_DATE_PATRIMONIALE'] : $valeur = $row_rech_objet['GALERIE_DEB_DATE_PATRIMONIALE']; ?>
                                <input name="GALERIE_DEB_DATE_PATRIMONIALE" type="text" class="inputnumerique" value="<?php echo reverseDate($valeur)?>">
                            </td>
                            <td valign="bottom">et</td>
                            <td >Date fin<br>
                                <?php isset($_POST['GALERIE_FIN_DATE_PATRIMONIALE']) ? $valeur = $_POST['GALERIE_FIN_DATE_PATRIMONIALE'] : $valeur = $row_rech_objet['GALERIE_FIN_DATE_PATRIMONIALE']; ?>
                                <input name="GALERIE_FIN_DATE_PATRIMONIALE" type="text" class="inputnumerique" value="<?php echo reverseDate($valeur)?>">
                            </td>
                        </tr>
                    </table>
                </td>
                <td>N&deg; de catalogue <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1616)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
                    <br>
                    <?php isset($_POST['GALERIE_NUMERO_CATALOGUE']) ? $valeur = $_POST['GALERIE_NUMERO_CATALOGUE'] : $valeur = $row_rech_objet['GALERIE_NUMERO_CATALOGUE']; ?>
                    <input name="GALERIE_NUMERO_CATALOGUE" type="text" size="20" value="<?php echo stripslashes($valeur)?>">
                </td>
            </tr>
            <tr>
                <td valign="top"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=AUT&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=DEPOSITAIRE');">D&eacute;positaire</a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1621)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
                    <br>
                    <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_auteur = "SELECT ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET =".$noFiche." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'DEPOSITAIRE' ORDER BY INDEX_OBJ_PER ASC";
$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
$row_auteur = mysql_fetch_assoc($auteur);
$totalRows_auteur = mysql_num_rows($auteur);
$i = 0 ;
$result = "";
do {
	if ($i !=0 ) {
		$result .= "/";
	}
	$result .= $row_auteur['ETAT_CIVIL'];
	$i++;
} while ($row_auteur = mysql_fetch_assoc($auteur)); ?> <?php isset($_POST['DEPOSITAIRE']) ? $valeur = $_POST['DEPOSITAIRE'] : $valeur = $result; ?>
                    <input name="DEPOSITAIRE" class="inputlong40" type="text" value="<?php echo stripslashes($valeur)?>">
                </td>
                <td valign="top">
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td colspan="4">Date de d&eacute;p&ocirc;t <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1622)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
                        </tr>
                        <tr>
                            <td>Affixe<br>
                                <?php isset($_POST['DEPOSITAIRE_TXT_DATE_PATRIMONIALE']) ? $valeur = $_POST['DEPOSITAIRE_TXT_DATE_PATRIMONIALE'] : $valeur = $row_rech_objet['DEPOSITAIRE_TXT_DATE_PATRIMONIALE']; ?>
                                <input name="DEPOSITAIRE_TXT_DATE_PATRIMONIALE" type="text" class="inputnumerique" value="<?php echo stripslashes($valeur)?>">
                            </td>
                            <td>Date d&eacute;but<br>
                                <?php isset($_POST['DEPOSITAIRE_DEB_DATE_PATRIMONIALE']) ? $valeur = $_POST['DEPOSITAIRE_DEB_DATE_PATRIMONIALE'] : $valeur = $row_rech_objet['DEPOSITAIRE_DEB_DATE_PATRIMONIALE']; ?>
                                <input name="DEPOSITAIRE_DEB_DATE_PATRIMONIALE" type="text" class="inputnumerique" value="<?php echo reverseDate($valeur)?>">
                            </td>
                            <td valign="bottom">et</td>
                            <td>Date fin<br>
                                <?php isset($_POST['DEPOSITAIRE_FIN_DATE_PATRIMONIALE']) ? $valeur = $_POST['DEPOSITAIRE_FIN_DATE_PATRIMONIALE'] : $valeur = $row_rech_objet['DEPOSITAIRE_FIN_DATE_PATRIMONIALE']; ?>
                                <input name="DEPOSITAIRE_FIN_DATE_PATRIMONIALE" type="text" class="inputnumerique" value="<?php echo reverseDate($valeur)?>">
                            </td>
                        </tr>
                    </table>
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td valign="top"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=AUT&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=ANCIEN_DEPOSITAIRE');">Ancien d&eacute;positaire</a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1625)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
                    <br>
                    <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_auteur = "SELECT ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET =".$noFiche." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'ANCIEN_DEPOSITAIRE' ORDER BY INDEX_OBJ_PER ASC";
$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
$row_auteur = mysql_fetch_assoc($auteur);
$totalRows_auteur = mysql_num_rows($auteur);
$i = 0 ;
$result = "";
do {
	if ($i !=0 ) {
		$result .= "/";
	}
	$result .= $row_auteur['ETAT_CIVIL'];
	$i++;
} while ($row_auteur = mysql_fetch_assoc($auteur)); ?> <?php isset($_POST['ANCIEN_DEPOSITAIRE']) ? $valeur = $_POST['ANCIEN_DEPOSITAIRE'] : $valeur = $result; ?>
                    <input name="ANCIEN_DEPOSITAIRE" class="inputlong40" type="text" value="<?php echo stripslashes($valeur)?>">
                </td>
                <td valign="top">
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td colspan="4">Date de d&eacute;p&ocirc;t <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1622)" target="_blank"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
                        </tr>
                        <tr>
                            <td>Affixe<br>
                                <?php isset($_POST['ANCIEN_DEPOSITAIRE_TXT_DATE_PATRIMONIALE']) ? $valeur = $_POST['ANCIEN_DEPOSITAIRE_TXT_DATE_PATRIMONIALE'] : $valeur = $row_rech_objet['ANCIEN_DEPOSITAIRE_TXT_DATE_PATRIMONIALE']; ?>
                                <input name="ANCIEN_DEPOSITAIRE_TXT_DATE_PATRIMONIALE" type="text" class="inputnumerique" value="<?php echo stripslashes($valeur)?>">
                            </td>
                            <td>Date d&eacute;but<br>
                                <?php isset($_POST['ANCIEN_DEPOSITAIRE_DEB_DATE_PATRIMONIALE']) ? $valeur = $_POST['ANCIEN_DEPOSITAIRE_DEB_DATE_PATRIMONIALE'] : $valeur = $row_rech_objet['ANCIEN_DEPOSITAIRE_DEB_DATE_PATRIMONIALE']; ?>
                                <input name="ANCIEN_DEPOSITAIRE_DEB_DATE_PATRIMONIALE" type="text" class="inputnumerique" value="<?php echo reverseDate($valeur)?>" maxlength="10">
                            </td>
                            <td valign="bottom">et</td>
                            <td>Date fin<br>
                                <?php isset($_POST['ANCIEN_DEPOSITAIRE_FIN_DATE_PATRIMONIALE']) ? $valeur = $_POST['ANCIEN_DEPOSITAIRE_FIN_DATE_PATRIMONIALE'] : $valeur = $row_rech_objet['ANCIEN_DEPOSITAIRE_FIN_DATE_PATRIMONIALE']; ?>
                                <input name="ANCIEN_DEPOSITAIRE_FIN_DATE_PATRIMONIALE" type="text" class="inputnumerique" value="<?php echo reverseDate($valeur)?>" maxlength="10">
                            </td>
                        </tr>
                    </table>
                </td>
                <td>&nbsp;</td>
            </tr>
        </table>
        <p class="titre"><a name="objet_rapport"></a>OBJET(S) LI&Eacute;(S) :</p>
        <table>
            <tr>
                <td valign="top">Idenfiant national <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1711)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
                    <?php isset($_POST['LIEN_INTRAOBJET']) ? $valeur = $_POST['LIEN_INTRAOBJET'] : $valeur = $row_rech_objet['LIEN_INTRAOBJET']; ?>
                    <input name="LIEN_INTRAOBJET" type="text" size="20" value="<?php echo stripslashes($valeur)?>">
                </td>
            </tr>
        </table>
        <div><a name="GESTION"></a></div>
        <p class="titre">GESTION </p>
        <table border="0" cellspacing="0" class="centpcent">
            <tr>
                <td valign="top">N&deg; dossier <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1808)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
                    <br>
                    <?php isset($_POST['NUMERO_DOSSIER']) ? $valeur = $_POST['NUMERO_DOSSIER'] : $valeur = $row_rech_objet['NUMERO_DOSSIER']; ?>
                    <textarea name="NUMERO_DOSSIER" rows="1" class="textarealong20"><?php echo stripslashes($valeur)?>
</textarea>
                </td>
                <td valign="top">Accessoire de pr&eacute;sentation <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1802)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
                    <br>
                    <?php isset($_POST['ACCESSOIRE_PRESENTATION']) ? $valeur = $_POST['ACCESSOIRE_PRESENTATION'] : $valeur = $row_rech_objet['ACCESSOIRE_PRESENTATION']; ?>
                    <textarea name="ACCESSOIRE_PRESENTATION" rows="2" class="textarealong40"><?php echo stripslashes($valeur)?>
</textarea>
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
$query_docum = "SELECT IDENTIFIANT FROM obj_doc,documentation WHERE obj_doc.INDEX_OBJET =".$noFiche." AND documentation.INDEX_DOCUMENTATION = obj_doc.INDEX_DOCUMENTATION AND obj_doc.QUALIFIANT = 'BIBLIOGRAPHIE' ORDER BY INDEX_OBJ_DOC ASC";
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
                    <?php isset($_POST['BIBLIOGRAPHIE_PARAM']) ? $valeur = $_POST['BIBLIOGRAPHIE_PARAM'] : $valeur = $row_rech_objet['BIBLIOGRAPHIE_PARAM']; ?>
                    <input name="BIBLIOGRAPHIE_PARAM" type="text" class="motcles" value="<?php echo stripslashes($valeur)?>">
                </td>
            </tr>
            <tr>
                <td valign="top">Photographie<br>
                    <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_docum = "SELECT IDENTIFIANT FROM obj_doc,documentation WHERE obj_doc.INDEX_OBJET =".$noFiche." AND documentation.INDEX_DOCUMENTATION = obj_doc.INDEX_DOCUMENTATION AND obj_doc.QUALIFIANT = 'PHOTOGRAPHIE' ORDER BY INDEX_OBJ_DOC ASC";
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
                    <?php isset($_POST['PHOTOGRAPHIE_PARAM']) ? $valeur = $_POST['PHOTOGRAPHIE_PARAM'] : $valeur = $row_rech_objet['PHOTOGRAPHIE_PARAM']; ?>
                    <input name="PHOTOGRAPHIE_PARAM" type="text" class="motcles" value="<?php echo stripslashes($valeur)?>">
                </td>
            </tr>
            <tr>
                <td valign="top">Exposition<br>
                    <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_docum = "SELECT IDENTIFIANT FROM obj_doc,documentation WHERE obj_doc.INDEX_OBJET =".$noFiche." AND documentation.INDEX_DOCUMENTATION = obj_doc.INDEX_DOCUMENTATION AND obj_doc.QUALIFIANT = 'EXPOSITION' ORDER BY INDEX_OBJ_DOC ASC";
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
                    <?php isset($_POST['EXPOSITION_PARAM']) ? $valeur = $_POST['EXPOSITION_PARAM'] : $valeur = $row_rech_objet['EXPOSITION_PARAM']; ?>
                    <input name="EXPOSITION_PARAM" type="text" class="motcles" value="<?php echo stripslashes($valeur)?>">
                </td>
            </tr>
            <tr>
                <td valign="top">C&eacute;d&eacute;rom<br>
                    <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_docum = "SELECT IDENTIFIANT FROM obj_doc,documentation WHERE obj_doc.INDEX_OBJET =".$noFiche." AND documentation.INDEX_DOCUMENTATION = obj_doc.INDEX_DOCUMENTATION AND obj_doc.QUALIFIANT = 'CEDEROM' ORDER BY INDEX_OBJ_DOC ASC";
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
                    <?php isset($_POST['CEDEROM_PARAM']) ? $valeur = $_POST['CEDEROM_PARAM'] : $valeur = $row_rech_objet['CEDEROM_PARAM']; ?>
                    <input name="CEDEROM_PARAM" type="text" class="motcles" value="<?php echo stripslashes($valeur)?>">
                </td>
            </tr>
            <tr>
                <td valign="top">Internet<br>
                    <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_docum = "SELECT IDENTIFIANT FROM obj_doc,documentation WHERE obj_doc.INDEX_OBJET =".$noFiche." AND documentation.INDEX_DOCUMENTATION = obj_doc.INDEX_DOCUMENTATION AND obj_doc.QUALIFIANT = 'INTERNET' ORDER BY INDEX_OBJ_DOC ASC";
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
                    <?php isset($_POST['INTERNET_PARAM']) ? $valeur = $_POST['INTERNET_PARAM'] : $valeur = $row_rech_objet['INTERNET_PARAM']; ?>
                    <input name="INTERNET_PARAM" type="text" class="motcles" value="<?php echo stripslashes($valeur)?>">
                </td>
            </tr>
            <tr>
                <td valign="top">Tapuscrit<br>
                    <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_docum = "SELECT IDENTIFIANT FROM obj_doc,documentation WHERE obj_doc.INDEX_OBJET =".$noFiche." AND documentation.INDEX_DOCUMENTATION = obj_doc.INDEX_DOCUMENTATION AND obj_doc.QUALIFIANT = 'TAPUSCRIT' ORDER BY INDEX_OBJ_DOC ASC";
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
                    <?php isset($_POST['TAPUSCRIT_PARAM']) ? $valeur = $_POST['TAPUSCRIT_PARAM'] : $valeur = $row_rech_objet['TAPUSCRIT_PARAM']; ?>
                    <input name="TAPUSCRIT_PARAM" type="text" class="motcles" value="<?php echo stripslashes($valeur)?>">
                </td>
            </tr>
            <tr>
                <td valign="top">Manuscrit<br>
                    <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_docum = "SELECT IDENTIFIANT FROM obj_doc,documentation WHERE obj_doc.INDEX_OBJET =".$noFiche." AND documentation.INDEX_DOCUMENTATION = obj_doc.INDEX_DOCUMENTATION AND obj_doc.QUALIFIANT = 'MANUSCRIT' ORDER BY INDEX_OBJ_DOC ASC";
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
                    <?php isset($_POST['MANUSCRIT_PARAM']) ? $valeur = $_POST['MANUSCRIT_PARAM'] : $valeur = $row_rech_objet['MANUSCRIT_PARAM']; ?>
                    <input name="MANUSCRIT_PARAM" type="text" class="motcles" value="<?php echo stripslashes($valeur)?>">
                </td>
            </tr>
            <tr>
                <td valign="top">Vid&eacute;o<br>
                    <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_docum = "SELECT IDENTIFIANT FROM obj_doc,documentation WHERE obj_doc.INDEX_OBJET =".$noFiche." AND documentation.INDEX_DOCUMENTATION = obj_doc.INDEX_DOCUMENTATION AND obj_doc.QUALIFIANT = 'VIDEO' ORDER BY INDEX_OBJ_DOC ASC";
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
                    <?php isset($_POST['VIDEO_PARAM']) ? $valeur = $_POST['VIDEO_PARAM'] : $valeur = $row_rech_objet['VIDEO_PARAM']; ?>
                    <input name="VIDEO_PARAM" type="text" class="motcles" value="<?php echo stripslashes($valeur)?>">
                </td>
            </tr>
            <tr>
                <td valign="top">Reproduction<br>
                    <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_docum = "SELECT IDENTIFIANT FROM obj_doc,documentation WHERE obj_doc.INDEX_OBJET =".$noFiche." AND documentation.INDEX_DOCUMENTATION = obj_doc.INDEX_DOCUMENTATION AND obj_doc.QUALIFIANT = 'REPRODUCTION' ORDER BY INDEX_OBJ_DOC ASC";
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
                    <?php isset($_POST['REPRODUCTION_PARAM']) ? $valeur = $_POST['REPRODUCTION_PARAM'] : $valeur = $row_rech_objet['REPRODUCTION_PARAM']; ?>
                    <input name="REPRODUCTION_PARAM" type="text" class="motcles" value="<?php echo stripslashes($valeur)?>">
                </td>
            </tr>
        </table>
        <div><a name="INFORMATIQUE"></a></div>
        <p class="titre">GESTION INFORMATIQUE</p>
        <table border="0" cellspacing="0" class="centpcent">
            <tr>
                <td valign="top">Copyright <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1902)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
                    <br>
					<?php ($duplication == 1) ? $noFiche = 0 : $noFiche = $noFiche; ?>
                    <?php if ($noFiche != 0) { ?>
                    <textarea name="COPYRIGHT" rows="3" class="textarealong40"><?php echo $row_rech_objet['COPYRIGHT']?>
</textarea>
                    <?php } else { ?>
                    <textarea name="COPYRIGHT" rows="3" class="textarealong40"><?php echo $_SESSION["musee"]?>
</textarea>
                    <?php } ?> <?php if ($noFiche != 0) { ?>
                    <input name="FICHE_CREEE_LE" type="hidden" value="<?php echo reverseDate($row_rech_objet['FICHE_CREEE_LE'])?>">
                    <?php } else { ?>
                    <input name="FICHE_CREEE_LE" type="hidden" value="<?php echo date("d.m.Y")?>">
                    <?php } ?> <?php if ($noFiche != 0) { ?>
                    <input name="FICHE_CREEE_PAR" type="hidden" value="<?php echo $row_rech_objet['FICHE_CREEE_PAR']?>">
                    <?php } else { ?>
                    <input name="FICHE_CREEE_PAR" type="hidden" value="<?php echo $_SESSION["nom"]." ".$_SESSION["prenom"]; ?>">
                    <?php } ?> <?php if ($noFiche != 0) { ?>
                    <input name="NIVEAU_VISA" type="hidden" value="<?php echo $row_rech_objet['NIVEAU_VISA']?>">
                    <?php } else { ?>
                    <input name="NIVEAU_VISA" type="hidden" value="0">
                    <?php } ?> <?php if ($noFiche != 0) { ?>
                    <input name="IDENTIFIANT_NATIONAL" type="hidden" value="<?php echo $row_rech_objet['IDENTIFIANT_NATIONAL']?>">
                    <?php } else { ?>
                    <input name="IDENTIFIANT_NATIONAL" type="hidden" value="0">
                    <?php } ?> <?php if ($noFiche != 0) { ?>
                    <input name="CODEMUSEE" type="hidden" value="<?php echo $row_rech_objet['CODEMUSEE']?>">
                    <?php } else { ?>
                    <input name="CODEMUSEE" type="hidden" value="<?php echo($_SESSION["code_musee"]); ?>">
                    <?php } ?> </td>
            </tr>
        </table>
        <?php } while ($row_rech_objet = mysql_fetch_assoc($rech_objet)); ?>
        <input type="hidden" name="MM_update" value="objets">
    </form>
</div>
<div><a name="FIN_FORMULAIRE"></a></div>
</body>
</html>
<?php
mysql_free_result($rech_objet);
mysql_free_result($auteur);
mysql_free_result($lieu);
?>