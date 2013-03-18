<?php

require_once('../config/config.php');
	$niveau_visa = $ms;
	$page = "docphoto";
	$msg = "";
	$result = "";
	include('../include/base_documentation.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="fr">
<head>
<title>Formulaire de saisie : Photo</title>
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
<?php creerFenetreTheso(); ?>

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
  } (errors) ? alert('Quelques omissions ou erreurs ont été trouvées :\n'+errors) : document.fiche.submit();
  document.MM_returnValue = (errors == '');
}


//-->
</script>
</head>
<body>
<div id="navigationDoc">
<?php include('../include/navigation.php'); ?>
</div>
<div id="hautDoc">
    <h2>Formulaire de saisie Photo </h2>
</div>
<div id="s-menuDoc">
    <div id="menuDoc"><a href="#GENERALE">G&eacute;n&eacute;rale</a> <span class="invisible">|</span> <a href="#SUPPORT">Support</a> <span class="invisible">|</span> <a href="#PHOTO">Photographie</a> <span class="invisible">|</span> <a href="#INFORMATIQUE">Gestion&nbsp;informatique</a></div>
    <div id="btnvalid">
        <input name="image" type="image" onClick="MM_validateForm('TYPE_DOCUMENT','','R','IDENTIFIANT','','R');return document.MM_returnValue" src="../images/valider.gif">
    </div>
</div>
<div class="spacer"></div>
<div align="center">
    <p style="color:#FF0000; font-weight:bold"> <?php echo $msg?> </p>
</div>
<!-- ----------------------------- -->
<!-- debut traitement de l'image   -->
<!-- ----------------------------- -->
<div id="imagesDoc">
				<?php
				if ($duplication == 0){
					isset($_POST['FICHIER']) ? $valeurFichier = $_POST['FICHIER'] : $valeurFichier = $row_rech_docum['FICHIER']; 
				}else{
					$valeurFichier = "";
				}
				?>
	<img src="<?php if ($valeurFichier==""){
		echo "../include/images.php?SRC=visuel_de_remplacement.jpg&amp;LARG=300&amp;HAUT=300";
		}else{
			echo "../include/images.php?SRC=".addslashes($valeurFichier)."&amp;LARG=300&amp;HAUT=300";
		}
		?>" alt="visuel"></div>
<!--
fin traitement de l'image
-->
<div id="formulaireDoc" class="saisie">
    <form name="fiche" action="<?php echo $editFormAction; ?>" method="post" target="_self" enctype="multipart/form-data">
        <?php do { ?> <?php ($duplication == 1) ? $fiche = "" : $fiche = $row_rech_docum['INDEX_DOCUMENTATION']; ?>
        <input name="INDEX_DOCUMENTATION" type="hidden" value="<?php echo $fiche?>">
        
        <br>
        <div><a name="GENERALE"></a></div>
        <p class="titre">G&Eacute;N&Eacute;RALE</p>
        <table cellspacing="0" class="centpcent">
            <tr>
                <td valign="top">
                    <label for="TYPE_DOCUMENT" class="obligatoire"><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=TYDOC&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=TYPE_DOCUMENT');">Type de document</a></label>
                    <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4123)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a><br>
                    <br>
                    <?php isset($_POST['TYPE_DOCUMENT']) ? $valeur = $_POST['TYPE_DOCUMENT'] : $valeur = $row_rech_docum['TYPE_DOCUMENT']; ?>
                    <input name="TYPE_DOCUMENT" id="TYPE_DOCUMENT" class="inputlong40" value="<?php echo stripslashes($valeur)?>">
                </td>
                <td valign="top">
                    <label for="IDENTIFIANT" class="obligatoire">Identifiant</label>
                    <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4101)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a><br>
                    <br>
                    <?php isset($_POST['IDENTIFIANT']) ? $valeur = $_POST['IDENTIFIANT'] : $valeur = $row_rech_docum['IDENTIFIANT']; ?>
                    <input name="IDENTIFIANT" id="IDENTIFIANT" class="inputlong40" value="<?php echo stripslashes($valeur)?>">
                    <?php ($duplication == 1) ? $num_ini = "" : $num_ini = $row_rech_docum['IDENTIFIANT']; ?>
                    <input name="IDENTIFIANT_INIT" type="hidden" value="<?php echo $num_ini ?>">
                </td>
            </tr>
            <tr valign="top">
                <td valign="top"><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=TLIEU&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=LIEU_EDITION');">Lieu d&#8217;&eacute;dition ou d&#8217;exposition</a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4108)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a><br>
                    <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_lieu = "SELECT SITE FROM lieu,doc_lie WHERE doc_lie.INDEX_DOCUMENTATION =".$noFiche." AND lieu.INDEX_LIEU = doc_lie.INDEX_LIEU AND doc_lie.QUALIFIANT = 'LIEU_EDITION' ORDER BY INDEX_DOC_LIE ASC";
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
} while ($row_lieu = mysql_fetch_assoc($lieu)); ?> <?php isset($_POST['LIEU_EDITION']) ? $valeur = $_POST['LIEU_EDITION'] : $valeur = $result; ?>
            <input name="LIEU_EDITION" class="inputlong40" type="text" value="<?php echo stripslashes($valeur)?>">
            </td>
            
            <td valign="top">&nbsp;</td>
            </tr>
            <tr>
                <td valign="top"><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=PERIO&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=PERIODE_CONCERNE');">P&eacute;riode concern&eacute;e par le document</a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4110)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a><br>
                    <br>
                    <?php isset($_POST['PERIODE_CONCERNE']) ? $valeur = $_POST['PERIODE_CONCERNE'] : $valeur = $row_rech_docum['PERIODE_CONCERNE']; ?>
                    <textarea cols="10" name="PERIODE_CONCERNE" rows="2" class="textarealong40"><?php echo stripslashes($valeur)?></textarea>
                </td>
                <td valign="top">Collection <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4111)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a><br>
                    <br>
                    <?php isset($_POST['COLLECTION']) ? $valeur = $_POST['COLLECTION'] : $valeur = $row_rech_docum['COLLECTION']; ?>
                    <textarea cols="10" name="COLLECTION" rows="3" class="textarealong40"><?php echo stripslashes($valeur)?></textarea>
                </td>
            </tr>
            <tr>
                <td valign="top"><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=MOCLE&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=MOTS_CLES');">Mots Cl&eacute;s</a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4112)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a><br>
                    <br>
                    <?php isset($_POST['MOTS_CLES']) ? $valeur = $_POST['MOTS_CLES'] : $valeur = $row_rech_docum['MOTS_CLES']; ?>
                    <textarea cols="10" name="MOTS_CLES" rows="3" class="textarealong40"><?php echo stripslashes($valeur)?></textarea>
                </td>
                <td valign="top"><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=TLIEU&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=LOCALISATION_DOCUMENT');">Localisation</a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4113)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a><br>
                    <br>
                    <?php isset($_POST['LOCALISATION_DOCUMENT']) ? $valeur = $_POST['LOCALISATION_DOCUMENT'] : $valeur = $row_rech_docum['LOCALISATION_DOCUMENT']; ?>
                    <textarea cols="10" name="LOCALISATION_DOCUMENT" rows="3" class="textarealong40"><?php echo stripslashes($valeur)?></textarea>
                </td>
            </tr>
            <tr>
                <td valign="top"><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=DTECH&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=DESCRIPTION_TECHNIQUE');">Description technique</a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4105)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a><br>
                    <br>
                    <?php isset($_POST['DESCRIPTION_TECHNIQUE']) ? $valeur = $_POST['DESCRIPTION_TECHNIQUE'] : $valeur = $row_rech_docum['DESCRIPTION_TECHNIQUE']; ?>
                    <textarea cols="10" name="DESCRIPTION_TECHNIQUE" rows="4" class="textarealong40"><?php echo stripslashes($valeur)?></textarea>
                </td>
                <td valign="top">Commentaires&nbsp;techniques&nbsp;<a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4106)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a><br>
                    <br>
                    <?php isset($_POST['COMMENTAIRE_TECHNIQUE']) ? $valeur = $_POST['COMMENTAIRE_TECHNIQUE'] : $valeur = $row_rech_docum['COMMENTAIRE_TECHNIQUE']; ?>
                    <textarea cols="10" name="COMMENTAIRE_TECHNIQUE" rows="4" class="textarealong40"><?php echo stripslashes($valeur)?></textarea>
                </td>
            <tr>
                <td valign="top"><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=DROIT&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=TYPE_DROIT');">Type de Droits</a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4115)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a><br>
                    <br>
                    <?php isset($_POST['TYPE_DROIT']) ? $valeur = $_POST['TYPE_DROIT'] : $valeur = $row_rech_docum['TYPE_DROIT']; ?>
                    <textarea cols="10" name="TYPE_DROIT" rows="3" class="textarealong40"><?php echo stripslashes($valeur)?></textarea>
                </td>
                <td valign="top"><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=ACCESS&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=ACCESSIBILITE');">Accessibilit&eacute;</a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4114)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a><br>
                    <br>
                    <?php isset($_POST['ACCESSIBILITE']) ? $valeur = $_POST['ACCESSIBILITE'] : $valeur = $row_rech_docum['ACCESSIBILITE']; ?>
                    <textarea cols="10" name="ACCESSIBILITE" rows="3" class="textarealong40"><?php echo stripslashes($valeur)?></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2" valign="top">Notes libres ou commentaires <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4104)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a><br>
                    <br>
                    <?php isset($_POST['NOTE_LIBRE']) ? $valeur = $_POST['NOTE_LIBRE'] : $valeur = $row_rech_docum['NOTE_LIBRE']; ?>
                    <textarea cols="10" name="NOTE_LIBRE" rows="3" class="textarealong90"><?php echo stripslashes($valeur)?></textarea>
                </td>
            </tr>
        </table>
        <br>
        <div><a name="SUPPORT"></a></div>
        <p class="titre">SUPPORT</p>
        <table cellpadding="3" cellspacing="0" class="centpcent">
            <tr>
                <td>Num&eacute;ro de Support.<a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4215)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a><br>
                    <br>
                    <?php isset($_POST['NUMERO_SUPPORT']) ? $valeur = $_POST['NUMERO_SUPPORT'] : $valeur = $row_rech_docum['NUMERO_SUPPORT']; ?>
                    <textarea cols="10" name="NUMERO_SUPPORT" rows="2" class="textarealong20"><?php echo stripslashes($valeur)?></textarea>
                </td>
                <td>Pr&eacute;cision ou adresse sur le Support <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4216)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a><br>
                    <br>
                    <?php isset($_POST['PRECISION_SUPPORT']) ? $valeur = $_POST['PRECISION_SUPPORT'] : $valeur = $row_rech_docum['PRECISION_SUPPORT']; ?>
                    <textarea name="PRECISION_SUPPORT" cols="30" rows="2"><?php echo stripslashes($valeur)?></textarea>
                </td>
            </tr>
			 <tr>
              <td colspan="3" align="center">
                <?php
					if ($valeurFichier != "") {?>
					Fichier image : <input name="FICHIER" type="text" value="<?php echo addslashes($valeurFichier) ?>">
					<input name="EFFACER" type="hidden" value="<?php echo $valeurFichier ?>">
					<?php }else{?>
						Nouveau fichier image :
						<input name="nouv_image" type="file">
						<br>
						attention format GIF, JPEG,PNG seulement et taille max. : <?php echo $_SESSION['max_transfert'] ?> octets
						<input name="FICHIER" type="hidden" value="<?php echo $valeurFichier ?>">
						<?php
					}?>
	<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $_SESSION['max_transfert'] ?>"> 
	</td>
            </tr>
        </table>
        <div><a name="PHOTO"></a></div>
        <p class="titre">PHOTO</p>
        <table class="centpcent">
            <tr>
                <td valign="top"><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=AUT&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=PHOTOGRAPHE');">Photographe</a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4318)"><img src="../images/infos.gif" alt="aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a><br>
                    <br>
                    <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_auteur = "SELECT ETAT_CIVIL FROM personne,doc_per WHERE doc_per.INDEX_DOCUMENTATION =".$noFiche." AND personne.INDEX_PERSONNE = doc_per.INDEX_PERSONNE AND doc_per.QUALIFIANT = 'PHOTOGRAPHE' ORDER BY INDEX_DOC_PER ASC";
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
} while ($row_auteur = mysql_fetch_assoc($auteur)); ?> <?php isset($_POST['PHOTOGRAPHE']) ? $valeur = $_POST['PHOTOGRAPHE'] : $valeur = $result; ?>
                    <input name="PHOTOGRAPHE" class="inputlong40" type="text" value="<?php echo stripslashes($valeur)?>">
                </td>
                <td valign="top">Num&eacute;ro d&#8217;inventaire du document dans le mus&eacute;e <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4122)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a><br>
                    <br>
                    <?php isset($_POST['NUMERO_INVENTAIRE_INTERNE']) ? $valeur = $_POST['NUMERO_INVENTAIRE_INTERNE'] : $valeur = $row_rech_docum['NUMERO_INVENTAIRE_INTERNE']; ?>
                    <input name="NUMERO_INVENTAIRE_INTERNE" type="text" class="inputlong40" value="<?php echo stripslashes($valeur)?>">
                </td>
            </tr>
            <tr valign="top">
                <td><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=TLIEU&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=LIEU_PRISE_VUE');">Lieu de prise de vue</a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4301)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a><br>
                    <br>
                    <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_lieu = "SELECT SITE FROM lieu,doc_lie WHERE doc_lie.INDEX_DOCUMENTATION =".$noFiche." AND lieu.INDEX_LIEU = doc_lie.INDEX_LIEU AND doc_lie.QUALIFIANT = 'LIEU_PRISE_VUE' ORDER BY INDEX_DOC_LIE ASC";
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
} while ($row_lieu = mysql_fetch_assoc($lieu)); ?> <?php isset($_POST['LIEU_PRISE_VUE']) ? $valeur = $_POST['LIEU_PRISE_VUE'] : $valeur = $result; ?>
                    <input name="LIEU_PRISE_VUE" class="inputlong40" type="text" value="<?php echo stripslashes($valeur)?>">
                </td>
                <td>
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td colspan="4">Date de Prise de Vue <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4319)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a></td>
                        </tr>
                        <tr>
                            <td>Affixe</td>
                            <td>Date d&eacute;but</td>
                            <td>&nbsp;</td>
                            <td>Date fin</td>
                        </tr>
                        <tr>
                            <td> <?php isset($_POST['TXT_DATE_PRISE_VUE']) ? $valeur = $_POST['TXT_DATE_PRISE_VUE'] : $valeur = $row_rech_docum['TXT_DATE_PRISE_VUE']; ?>
                                <select name="TXT_DATE_PRISE_VUE">
                                    <option value=""<?php if ($valeur == "") {?> selected<?php ;} ?>>--</option>
                                    <option value="le"<?php if ($valeur == "le") {?> selected<?php ;} ?>>Le</option>
                                    <option value="avant"<?php if ($valeur == "avant") {?> selected<?php ;} ?>>Avant</option>
                                    <option value="après"<?php if ($valeur == "après") {?> selected<?php ;} ?>>Apr&egrave;s</option>
                                    <option value="entre"<?php if ($valeur == "entre") {?> selected<?php ;} ?>>Entre</option>
                                    <option value="année"<?php if ($valeur == "année") {?> selected<?php ;} ?>>Ann&eacute;e</option>
                                    <option value="mois"<?php if ($valeur == "mois") {?> selected<?php ;} ?>>Mois</option>
                                </select>
                            </td>
                            <td> <?php isset($_POST['DEB_DATE_PRISE_VUE']) ? $valeur = $_POST['DEB_DATE_PRISE_VUE'] : $valeur = $row_rech_docum['DEB_DATE_PRISE_VUE']; ?>
                                <input name="DEB_DATE_PRISE_VUE" type="text" class="inputnumerique" onBlur="champDat(this);" value="<?php echo reverseDate($valeur)?>">
                            </td>
                            <td>et</td>
                            <td> <?php isset($_POST['FIN_DATE_PRISE_VUE']) ? $valeur = $_POST['FIN_DATE_PRISE_VUE'] : $valeur = $row_rech_docum['FIN_DATE_PRISE_VUE']; ?>
                                <input name="FIN_DATE_PRISE_VUE" type="text" class="inputnumerique" onBlur="champDat(this);" value="<?php echo reverseDate($valeur)?>">
                            </td>
                        </tr>
                    </table>
                </td>
            <tr valign="top">
                <td colspan="2">L&eacute;gende <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4323)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a><br>
                    <br>
                    <?php isset($_POST['LEGENDE']) ? $valeur = $_POST['LEGENDE'] : $valeur = $row_rech_docum['LEGENDE']; ?>
                    <textarea name="LEGENDE" cols="55" rows="4"><?php echo stripslashes($valeur)?></textarea>
                </td>
            </tr>
            <tr valign="top">
                <td>Copyright de la photo <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4321)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a><br>
                    <br>
                    <?php isset($_POST['COPYRIGHT_PHOTO']) ? $valeur = $_POST['COPYRIGHT_PHOTO'] : $valeur = $row_rech_docum['COPYRIGHT_PHOTO']; ?>
                    <textarea cols="10" name="COPYRIGHT_PHOTO" rows="3" class="textarealong40"><?php echo stripslashes($valeur)?></textarea>
                </td>
                <td>&nbsp;</td>
            </tr>
        </table>
        <div><a name="INFORMATIQUE"></a></div>
        <p class="titre">GESTION INFORMATIQUE</p>
        <table border="0" cellspacing="0" class="centpcent">
            <tr>
                <td valign="top">Copyright <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1902)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
                    <br>
					<?php ($duplication == 1) ? $noFiche = 0 : $noFiche = $noFiche; ?>
                    <?php if ($noFiche == 0 || $row_rech_docum['COPYRIGHT']=="") { ?>
                    	<textarea cols="10" id="copyrightNewPage" name="COPYRIGHT" rows="3" class="textarealong40"><?php if ($_SESSION['droit']!=60){echo $_SESSION["musee"];} ?></textarea>
                    <?php } else { ?>
					      <textarea cols="10" id="copyright" name="COPYRIGHT" rows="3" class="textarealong40"><?php echo $row_rech_docum['COPYRIGHT']?></textarea>
                    <?php } ?> <?php if ($noFiche != 0) { ?>
                    <input name="FICHE_CREEE_LE" type="hidden" value="<?php echo reverseDate($row_rech_docum['FICHE_CREEE_LE'])?>">
                    <?php } else { ?>
                    <input name="FICHE_CREEE_LE" type="hidden" value="<?php echo date("d.m.Y")?>">
                    <?php } ?> <?php if ($noFiche != 0) { ?>
                    <input name="FICHE_CREEE_PAR" type="hidden" value="<?php echo $row_rech_docum['FICHE_CREEE_PAR']?>">
                    <?php } else { ?>
                    <input name="FICHE_CREEE_PAR" type="hidden" value="<?php echo $_SESSION["nom"]." ".$_SESSION["prenom"]; ?>">
                    <?php } ?> <?php if ($noFiche != 0) { ?>
                    <input name="NIVEAU_VISA" type="hidden" value="<?php echo $row_rech_docum['NIVEAU_VISA']?>">
                    <?php } else { ?>
                    <input name="NIVEAU_VISA" type="hidden" value="0">
                    <?php } ?> <?php if ($noFiche != 0) { ?>
                    <input name="IDENTIFIANT_NATIONAL" type="hidden" value="<?php echo $row_rech_docum['IDENTIFIANT_NATIONAL']?>">
                    <?php } else { ?>
                    <input name="IDENTIFIANT_NATIONAL" type="hidden" value="0">
                    <?php } ?> <?php if ($noFiche != 0) { ?>
                    <input id="codeMuseeHidden" name="CODEMUSEE" type="hidden" value="<?php echo $row_rech_docum['CODEMUSEE']?>">
                    <?php } else { ?>
                    <input id="codeMuseeHidden" name="CODEMUSEE" type="hidden" value="<?php if ($_SESSION['droit']!=60){echo $_SESSION['code_musee'];} ?>">
                    <?php } ?> </td>
            </tr>
        </table>
        <?php } while ($row_rech_docum = mysql_fetch_assoc($rech_docum)); ?>
        <input type="hidden" name="MM_update" value="documentation">
    </form>
</div>
<div><a name="FIN_FORMULAIRE"></a></div>
</body>
</html>
