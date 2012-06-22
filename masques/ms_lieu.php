<?php
	session_start();
require_once('../config/config.php');
	$niveau_visa = $ms;
	$page = "lieu";
	$msg = "";
	$result = "";
	include('../include/securite.php');
	include('../include/base_lieu.php');
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="fr">
<head>
<title>Formulaire de saisie : Lieux</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="pragma" content="no-cache">
<link href="../style/style_awl.css" rel="stylesheet" type="text/css" media="screen">
<link href="../style/style_awl_print.css" rel="stylesheet" type="text/css" media="print">
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
  } (errors) ? alert('Quelques omissions ou erreurs ont été trouvées :\n'+errors) : document.lieu.submit();
  document.MM_returnValue = (errors == '');
}

//-->
</script>
</head>
<body>
<?php include('../include/navigation.php'); ?>
<div id="haut">
    <h2>Formulaire de saisie Lieux </h2>
</div>
<div id="s-menu">
    <div id="menu"><a href="#IDENTIFICATION">Identification</a> <span class="invisible">|</span> <a href="#ADRESSE">Adresse</a> <span class="invisible">|</span> <a href="#DOCUMENTATION">Documentation</a> <span class="invisible">|</span> <a href="#INFORMATIQUE">Gestion&nbsp;informatique</a></div>
    <div id="btnvalid">
        <input name="image" type="image" onClick="MM_validateForm('SITE','','R','TYPE_SITE','','R');return document.MM_returnValue" src="/alienorweblibre/images/valider.gif">
    </div>
</div>
<div class="spacer"> </div>
<div align="center">
    <p style="color:#FF0000; font-weight:bold"> <?php echo $msg?> </p>
</div>
<div id="formulaire" class="saisie"> <a name="IDENTIFICATION"></a>
    <form name="lieu" action="<?php echo $editFormAction; ?>" method="post" target="_self">
        <?php do { ?> <?php ($duplication == 1) ? $fiche = "" : $fiche = $row_rech_lieu['INDEX_LIEU']; ?>
        <input name="INDEX_LIEU" type="hidden" value="<?php echo $fiche?>">
        <div><a name="IDENTIFICATION"></a></div>
        <p align="center" class="titre">IDENTIFICATION</p>
        <table border="0" cellspacing="0" class="centpcent">
            <tr valign="top">
                <td>
                    <label for="SITE" class="obligatoire"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=TLIEU&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=SITE');">Nom&nbsp;du&nbsp;lieu&nbsp;ou&nbsp;du&nbsp;site&nbsp;(identifiant)</a></label>
                    &nbsp;<a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,3101)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a><br>
                    <br>
                    <?php isset($_POST['SITE']) ? $valeur = $_POST['SITE'] : $valeur = $row_rech_lieu['SITE']; ?>
                    <textarea name="SITE" id="SITE" rows="2" class="textarealong40"><?php echo stripslashes($valeur)?></textarea>
                    <?php ($duplication == 1) ? $num_ini = "" : $num_ini = $row_rech_lieu['SITE']; ?>
                    <input name="SITE_INIT" type="hidden" value="<?php echo $num_ini ?>">
                </td>
                <td>
                    <label for="TYPE_SITE" class="obligatoire"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=TSITE&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=TYPE_SITE');">Type de lieu ou de site</a></label>
                    <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,3104)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a><br>
                    <br>
                    <?php isset($_POST['TYPE_SITE']) ? $valeur = $_POST['TYPE_SITE'] : $valeur = $row_rech_lieu['TYPE_SITE']; ?>
                    <textarea name="TYPE_SITE" id="TYPE_SITE" rows="2" class="textarealong40"><?php echo stripslashes($valeur)?></textarea>
                </td>
            </tr>
            <tr valign="top">
                <td colspan="2">Pr&eacute;cision sur le site <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,3106)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a><br>
                    <br>
                    <?php isset($_POST['PRECISION_SITE']) ? $valeur = $_POST['PRECISION_SITE'] : $valeur = $row_rech_lieu['PRECISION_SITE']; ?>
                    <textarea name="PRECISION_SITE" rows="3" class="textarealong90"><?php echo stripslashes($valeur)?></textarea>
                </td>
            </tr>
            <tr valign="top">
                <td>N&deg; de site SDA <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,3102)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a><br>
                    <br>
                    <?php isset($_POST['NUMERO_SDA']) ? $valeur = $_POST['NUMERO_SDA'] : $valeur = $row_rech_lieu['NUMERO_SDA']; ?>
                    <input name="NUMERO_SDA" type="text" class="inputlong40" value="<?php echo stripslashes($valeur)?>">
                </td>
                <td>M&eacute;thode de collecte <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,3105)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a><br>
                    <br>
                    <?php isset($_POST['METHODE_COLLECTE']) ? $valeur = $_POST['METHODE_COLLECTE'] : $valeur = $row_rech_lieu['METHODE_COLLECTE']; ?>
                    <textarea name="METHODE_COLLECTE" rows="2" class="textarealong40"><?php echo stripslashes($valeur)?></textarea>
                </td>
            </tr>
            <tr valign="top">
                <td>
                    <label for="OCCUPANT"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=AUT&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=OCCUPANT');">Occupant&nbsp;</a></label>
                    <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,3108)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a><br>
                    <br>
                    <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_auteur = "SELECT ETAT_CIVIL FROM personne,lie_per WHERE lie_per.INDEX_LIEU =".$noFiche." AND personne.INDEX_PERSONNE = lie_per.INDEX_PERSONNE AND lie_per.QUALIFIANT = 'OCCUPANT' ORDER BY INDEX_LIE_PER ASC";
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
} while ($row_auteur = mysql_fetch_assoc($auteur)); ?> <?php isset($_POST['OCCUPANT']) ? $valeur = $_POST['OCCUPANT'] : $valeur = $result; ?>
            <input name="OCCUPANT" class="inputlong40" type="text" value="<?php echo stripslashes($valeur)?>">
            <td>
                    <table>
                        <tr>
                            <td colspan="4">P&eacute;riode d&#8217;occupation <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,2225)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a></td>
                        </tr>
                        <tr>
                            <td>Affixe<br>
                                <?php isset($_POST['OCCUPANT_TXTDATE1']) ? $valeur = $_POST['OCCUPANT_TXTDATE1'] : $valeur = $row_rech_lieu['OCCUPANT_TXTDATE1']; ?>
                                <input name="OCCUPANT_TXTDATE1" type="text" class="inputnumerique" value="<?php echo stripslashes($valeur)?>">
                            </td>
                            <td>Date d&eacute;but<br>
                                <?php isset($_POST['OCCUPANT_DEBDATE1']) ? $valeur = $_POST['OCCUPANT_DEBDATE1'] : $valeur = $row_rech_lieu['OCCUPANT_DEBDATE1']; ?>
                                <input name="OCCUPANT_DEBDATE1" type="text" class="inputnumerique" value="<?php echo reverseDate($valeur)?>">
                            </td>
                            <td valign="bottom">et</td>
                            <td>Date fin<br>
                                <?php isset($_POST['OCCUPANT_FINDATE1']) ? $valeur = $_POST['OCCUPANT_FINDATE1'] : $valeur = $row_rech_lieu['OCCUPANT_FINDATE1']; ?>
                                <input name="OCCUPANT_FINDATE1" type="text" class="inputnumerique" value="<?php echo reverseDate($valeur)?>">
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td valign="top">
                    <table>
                        <tr>
                            <td colspan="4">P&eacute;riode d&#8217;activit&eacute; <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,2116)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a></td>
                        </tr>
                        <tr>
                            <td>Affixe<br>
                                <?php isset($_POST['TXT_PERIODE_ACTIVITE']) ? $valeur = $_POST['TXT_PERIODE_ACTIVITE'] : $valeur = $row_rech_lieu['TXT_PERIODE_ACTIVITE']; ?>
                                <input name="TXT_PERIODE_ACTIVITE" type="text" class="inputnumerique" value="<?php echo stripslashes($valeur)?>">
                            </td>
                            <td>Date d&eacute;but<br>
                                <?php isset($_POST['DEB_PERIODE_ACTIVITE']) ? $valeur = $_POST['DEB_PERIODE_ACTIVITE'] : $valeur = $row_rech_lieu['DEB_PERIODE_ACTIVITE']; ?>
                                <input name="DEB_PERIODE_ACTIVITE" type="text" class="inputnumerique" value="<?php echo reverseDate($valeur)?>">
                            </td>
                            <td valign="bottom">et</td>
                            <td>Date fin<br>
                                <?php isset($_POST['FIN_PERIODE_ACTIVITE']) ? $valeur = $_POST['FIN_PERIODE_ACTIVITE'] : $valeur = $row_rech_lieu['FIN_PERIODE_ACTIVITE']; ?>
                                <input name="FIN_PERIODE_ACTIVITE" type="text" class="inputnumerique" value="<?php echo reverseDate($valeur)?>">
                            </td>
                        </tr>
                    </table>
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr valign="top">
                <td colspan="2">Commentaires <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,3107)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a><br>
                    <br>
                    <?php isset($_POST['COMMENTAIRES']) ? $valeur = $_POST['COMMENTAIRES'] : $valeur = $row_rech_lieu['COMMENTAIRES']; ?>
                    <textarea name="COMMENTAIRES" rows="5" class="textarealong90"><?php echo stripslashes($valeur)?></textarea>
                </td>
            </tr>
        </table>
        <div><a name="ADRESSE"></a></div>
        <p class="titre">ADRESSE</p>
        <table border="0" cellspacing="0" class="centpcent">
            <tr valign="top">
                <td>Adresse <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,3209)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a><br>
                    <br>
                    <?php isset($_POST['ADRESSE']) ? $valeur = $_POST['ADRESSE'] : $valeur = $row_rech_lieu['ADRESSE']; ?>
                    <textarea name="ADRESSE" rows="4" class="textarealong40"><?php echo stripslashes($valeur)?></textarea>
                </td>
                <td>T&eacute;l&eacute;phone <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,3210)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a><br>
                    <br>
                    <?php isset($_POST['TEL']) ? $valeur = $_POST['TEL'] : $valeur = $row_rech_lieu['TEL']; ?>
                    <textarea name="TEL" cols="15" rows="2"><?php echo stripslashes($valeur)?></textarea>
                </td>
                <td>Fax <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,3211)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a><br>
                    <br>
                    <?php isset($_POST['FAX']) ? $valeur = $_POST['FAX'] : $valeur = $row_rech_lieu['FAX']; ?>
                    <textarea name="FAX" cols="15" rows="2"><?php echo stripslashes($valeur)?></textarea>
                </td>
            </tr>
        </table>
        <div><a name="DOCUMENTATION"></a></div>
        <p class="titre">DOCUMENTATION</p>
        <table border="0" cellspacing="0" class="centpcent">
            <tr>
                <td valign="top">Bibliographie<br>
                    <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_docum = "SELECT IDENTIFIANT FROM lie_doc,documentation WHERE lie_doc.INDEX_LIEU =".$noFiche." AND documentation.INDEX_DOCUMENTATION = lie_doc.INDEX_DOCUMENTATION AND lie_doc.QUALIFIANT = 'BIBLIOGRAPHIE' ORDER BY INDEX_lie_doc ASC";
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
                    <?php isset($_POST['BIBLIOGRAPHIE_PARAM']) ? $valeur = $_POST['BIBLIOGRAPHIE_PARAM'] : $valeur = $row_rech_lieu['BIBLIOGRAPHIE_PARAM']; ?>
                    <input name="BIBLIOGRAPHIE_PARAM" type="text" class="motcles" value="<?php echo stripslashes($valeur)?>">
                </td>
            </tr>
            <tr>
                <td valign="top">Photographie<br>
                    <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_docum = "SELECT IDENTIFIANT FROM lie_doc,documentation WHERE lie_doc.INDEX_LIEU =".$noFiche." AND documentation.INDEX_DOCUMENTATION = lie_doc.INDEX_DOCUMENTATION AND lie_doc.QUALIFIANT = 'PHOTOGRAPHIE' ORDER BY INDEX_lie_doc ASC";
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
                    <?php isset($_POST['PHOTOGRAPHIE_PARAM']) ? $valeur = $_POST['PHOTOGRAPHIE_PARAM'] : $valeur = $row_rech_lieu['PHOTOGRAPHIE_PARAM']; ?>
                    <input name="PHOTOGRAPHIE_PARAM" type="text" class="motcles" value="<?php echo stripslashes($valeur)?>">
                </td>
            </tr>
            <tr>
                <td valign="top">Exposition<br>
                    <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_docum = "SELECT IDENTIFIANT FROM lie_doc,documentation WHERE lie_doc.INDEX_LIEU =".$noFiche." AND documentation.INDEX_DOCUMENTATION = lie_doc.INDEX_DOCUMENTATION AND lie_doc.QUALIFIANT = 'EXPOSITION' ORDER BY INDEX_lie_doc ASC";
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
                    <?php isset($_POST['EXPOSITION_PARAM']) ? $valeur = $_POST['EXPOSITION_PARAM'] : $valeur = $row_rech_lieu['EXPOSITION_PARAM']; ?>
                    <input name="EXPOSITION_PARAM" type="text" class="motcles" value="<?php echo stripslashes($valeur)?>">
                </td>
            </tr>
            <tr>
                <td valign="top">C&eacute;d&eacute;rom<br>
                    <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_docum = "SELECT IDENTIFIANT FROM lie_doc,documentation WHERE lie_doc.INDEX_LIEU =".$noFiche." AND documentation.INDEX_DOCUMENTATION = lie_doc.INDEX_DOCUMENTATION AND lie_doc.QUALIFIANT = 'CEDEROM' ORDER BY INDEX_lie_doc ASC";
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
                    <?php isset($_POST['CEDEROM_PARAM']) ? $valeur = $_POST['CEDEROM_PARAM'] : $valeur = $row_rech_lieu['CEDEROM_PARAM']; ?>
                    <input name="CEDEROM_PARAM" type="text" class="motcles" value="<?php echo stripslashes($valeur)?>">
                </td>
            </tr>
            <tr>
                <td valign="top">Internet<br>
                    <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_docum = "SELECT IDENTIFIANT FROM lie_doc,documentation WHERE lie_doc.INDEX_LIEU =".$noFiche." AND documentation.INDEX_DOCUMENTATION = lie_doc.INDEX_DOCUMENTATION AND lie_doc.QUALIFIANT = 'INTERNET' ORDER BY INDEX_lie_doc ASC";
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
                    <?php isset($_POST['INTERNET_PARAM']) ? $valeur = $_POST['INTERNET_PARAM'] : $valeur = $row_rech_lieu['INTERNET_PARAM']; ?>
                    <input name="INTERNET_PARAM" type="text" class="motcles" value="<?php echo stripslashes($valeur)?>">
                </td>
            </tr>
            <tr>
                <td valign="top">Tapuscrit<br>
                    <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_docum = "SELECT IDENTIFIANT FROM lie_doc,documentation WHERE lie_doc.INDEX_LIEU =".$noFiche." AND documentation.INDEX_DOCUMENTATION = lie_doc.INDEX_DOCUMENTATION AND lie_doc.QUALIFIANT = 'TAPUSCRIT' ORDER BY INDEX_lie_doc ASC";
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
                    <?php isset($_POST['TAPUSCRIT_PARAM']) ? $valeur = $_POST['TAPUSCRIT_PARAM'] : $valeur = $row_rech_lieu['TAPUSCRIT_PARAM']; ?>
                    <input name="TAPUSCRIT_PARAM" type="text" class="motcles" value="<?php echo stripslashes($valeur)?>">
                </td>
            </tr>
            <tr>
                <td valign="top">Manuscrit<br>
                    <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_docum = "SELECT IDENTIFIANT FROM lie_doc,documentation WHERE lie_doc.INDEX_LIEU =".$noFiche." AND documentation.INDEX_DOCUMENTATION = lie_doc.INDEX_DOCUMENTATION AND lie_doc.QUALIFIANT = 'MANUSCRIT' ORDER BY INDEX_lie_doc ASC";
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
                    <?php isset($_POST['MANUSCRIT_PARAM']) ? $valeur = $_POST['MANUSCRIT_PARAM'] : $valeur = $row_rech_lieu['MANUSCRIT_PARAM']; ?>
                    <input name="MANUSCRIT_PARAM" type="text" class="motcles" value="<?php echo stripslashes($valeur)?>">
                </td>
            </tr>
            <tr>
                <td valign="top">Vid&eacute;o<br>
                    <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_docum = "SELECT IDENTIFIANT FROM lie_doc,documentation WHERE lie_doc.INDEX_LIEU =".$noFiche." AND documentation.INDEX_DOCUMENTATION = lie_doc.INDEX_DOCUMENTATION AND lie_doc.QUALIFIANT = 'VIDEO' ORDER BY INDEX_lie_doc ASC";
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
                    <?php isset($_POST['VIDEO_PARAM']) ? $valeur = $_POST['VIDEO_PARAM'] : $valeur = $row_rech_lieu['VIDEO_PARAM']; ?>
                    <input name="VIDEO_PARAM" type="text" class="motcles" value="<?php echo stripslashes($valeur)?>">
                </td>
            </tr>
            <tr>
                <td valign="top">Reproduction<br>
                    <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_docum = "SELECT IDENTIFIANT FROM lie_doc,documentation WHERE lie_doc.INDEX_LIEU =".$noFiche." AND documentation.INDEX_DOCUMENTATION = lie_doc.INDEX_DOCUMENTATION AND lie_doc.QUALIFIANT = 'REPRODUCTION' ORDER BY INDEX_lie_doc ASC";
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
                    <?php isset($_POST['REPRODUCTION_PARAM']) ? $valeur = $_POST['REPRODUCTION_PARAM'] : $valeur = $row_rech_lieu['REPRODUCTION_PARAM']; ?>
                    <input name="REPRODUCTION_PARAM" type="text" class="motcles" value="<?php echo stripslashes($valeur)?>">
                </td>
            </tr>
        </table>
        <div><a name="INFORMATIQUE"></a></div>
        <p class="titre">GESTION INFORMATIQUE</p>
        <table border="0" cellspacing="0" class="centpcent">
            <tr>
                <td>Copyright <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1902)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
                    <br>
					<?php ($duplication == 1) ? $noFiche = 0 : $noFiche = $noFiche; ?>
                    <?php if ($noFiche == 0 || $row_rech_lieu['COPYRIGHT'] == ""  ) { ?>
					 	<textarea name="COPYRIGHT" rows="3" class="textarealong40"><?php echo $_SESSION["musee"]; ?></textarea>
                    <?php } else { ?>
                   		<textarea name="COPYRIGHT" rows="3" class="textarealong40"><?php echo $row_rech_lieu['COPYRIGHT']; ?></textarea>
                    <?php } ?> <?php if ($noFiche != 0) { ?>
                    <input name="FICHE_CREEE_LE" type="hidden" value="<?php echo reverseDate($row_rech_lieu['FICHE_CREEE_LE']); ?>">
                    <?php } else { ?>
                    <input name="FICHE_CREEE_LE" type="hidden" value="<?php echo date("d.m.Y"); ?>">
                    <?php } ?> <?php if ($noFiche != 0) { ?>
                    <input name="FICHE_CREEE_PAR" type="hidden" value="<?php echo $row_rech_lieu['FICHE_CREEE_PAR']; ?>">
                    <?php } else { ?>
                    <input name="FICHE_CREEE_PAR" type="hidden" value="<?php echo $_SESSION["nom"]." ".$_SESSION["prenom"]; ?>">
                    <?php } ?> <?php if ($noFiche != 0) { ?>
                    <input name="NIVEAU_VISA" type="hidden" value="<?php echo $row_rech_lieu['NIVEAU_VISA']; ?>">
                    <?php } else { ?>
                    <input name="NIVEAU_VISA" type="hidden" value="0">
                    <?php } ?> <?php if ($noFiche != 0) { ?>
                    <input name="IDENTIFIANT_NATIONAL" type="hidden" value="<?php echo $row_rech_lieu['IDENTIFIANT_NATIONAL']; ?>">
                    <?php } else { ?>
                    <input name="IDENTIFIANT_NATIONAL" type="hidden" value="0">
                    <?php } ?> <?php if ($noFiche != 0) { ?>
                    <input name="CODEMUSEE" type="hidden" value="<?php echo $row_rech_lieu['CODEMUSEE']; ?>">
                    <?php } else { ?>
                    <input name="CODEMUSEE" type="hidden" value="<?php echo $_SESSION["code_musee"]; ?>">
                    <?php } ?> </td>
            </tr>
        </table>
        <?php } while ($row_rech_lieu = mysql_fetch_assoc($rech_lieu)); ?>
        <input type="hidden" name="MM_update" value="lieu">
        <div><a name="FIN_FORMULAIRE"></a></div>
    </form>
</div>
</body>
</html>
<?php
mysql_free_result($rech_lieu);
?>