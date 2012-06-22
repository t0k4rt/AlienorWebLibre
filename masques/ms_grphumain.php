<?php
	session_start();
require_once('../config/config.php');
	$niveau_visa = $ms;
	$page = "grphumain";
	$msg = "";
	$result = "";
	include('../include/securite.php');
	include('../include/base_personne.php');
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="fr">
<head>
<title>Formulaire de saisie : Groupe humain</title>
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
  } (errors) ? alert('Quelques omissions ou erreurs ont été trouvées :\n'+errors) : document.personne.submit();
  document.MM_returnValue = (errors == '');
}


//-->
</script>
</head>
<body>
<?php include('../include/navigation.php'); ?>
<div id="haut">
    <h2>Formulaire de saisie : Groupe humain </h2>
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
            <tr valign="top">
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
            <tr valign="top">
                <td>
                    <label for="ETAT_CIVIL" class="obligatoire"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=AUT&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=ETAT_CIVIL');">Nom</a></label>
                    <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,2101)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a><br>
                    <br>
                    <?php isset($_POST['ETAT_CIVIL']) ? $valeur = $_POST['ETAT_CIVIL'] : $valeur = $row_rech_personne['ETAT_CIVIL']; ?>
                    <textarea name="ETAT_CIVIL" id="ETAT_CIVIL" rows="2" class="textarealong40"><?php echo stripslashes($valeur)?></textarea>
                    <?php ($duplication == 1) ? $num_ini = "" : $num_ini = $row_rech_personne['ETAT_CIVIL']; ?>
                    <input name="ETAT_CIVIL_INIT" type="hidden" class="motcles" id="ETAT_CIVIL_INIT" value="<?php echo stripslashes($valeur)?>">
                </td>
                <td>
                    <label for="SPHERE_INFLUENCE">&Eacute;tat</label>
                    <a href="javascript:RH_ShowHelp(0,'/Leconseiller/index.htm',HH_HELP_CONTEXT,2118)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a><br>
                    <br>
                    <?php isset($_POST['SPHERE_INFLUENCE']) ? $valeur = $_POST['SPHERE_INFLUENCE'] : $valeur = $row_rech_personne['SPHERE_INFLUENCE']; ?>
                    <textarea name="SPHERE_INFLUENCE" rows="2" class="textarealong40" id="SPHERE_INFLUENCE"><?php echo stripslashes($valeur)?></textarea>
                </td>
            </tr>
            <tr valign="top">
                <td colspan="2">
                    <label id="COMMENTAIRE">Historique</label>
                    <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,2107)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a><br>
                    <br>
                    <?php isset($_POST['COMMENTAIRE']) ? $valeur = $_POST['COMMENTAIRE'] : $valeur = $row_rech_personne['COMMENTAIRE']; ?>
                    <textarea name="COMMENTAIRE" id="COMMENTAIRE" cols="110" rows="8"><?php echo stripslashes($valeur)?></textarea>
                </td>
            </tr>
        </table>
        <div><a name="ADRESSE"></a></div>
        <p class="titre">ADRESSE</p>
        <table cellpadding="3" cellspacing="0" class="centpcent">
            <tr>
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
        <div><a name="DOCUMENTATION"></a></div>
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
                    <?php if ($noFiche == 0 || $row_rech_personne['COPYRIGHT']== "") { ?>
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
    </form>
</div>
<div><a name="FIN_FORMULAIRE"></a></div>
</body>
</html>
