<?php
	session_start();
require_once('../config/config.php');
	$niveau_visa = $ms;
	$page = "exposition";
	$msg = "";
	$result = "";
	include('../include/securite.php');
	include('../include/base_documentation.php');
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="fr">
<head>
<title>Formulaire de saisie : Exposition</title>
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
  } (errors) ? alert('Quelques omissions ou erreurs ont été trouvées :\n'+errors) : document.documentation.submit();
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
    <h2>Formulaire de saisie Exposition </h2>
</div>
<div id="s-menuDoc">
    <div id="menuDoc"><a href="#GENERALE">G&eacute;n&eacute;rale</a> <span class="invisible">|</span> <a href="#SUPPORT">Support</a> <span class="invisible">|</span> <a href="#PHOTO">Photographie</a> <span class="invisible">|</span> <a href="#LIVRE">Livre</a> <span class="invisible">|</span> <a href="#INFORMATIQUE">Gestion&nbsp;informatique</a></div>
    <div id="btnvalid">
        <input name="image" type="image" onClick="MM_validateForm('TYPE_DOCUMENT','','R','IDENTIFIANT','','R');return document.MM_returnValue" src="/alienorweblibre/images/valider.gif">
    </div>
</div>
<div class="spacer"> </div>
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
		echo "../include/images.php?SRC=visuel_de_remplacement.jpg&LARG=300&HAUT=300";
		}else{
			echo "../include/images.php?SRC=".$valeurFichier."&LARG=300&HAUT=300";
		}
		?>"></div>
<!-- ----------------------------- -->
<!--   fin traitement de l'image   -->
<!-- ----------------------------- -->
<div id="formulaireDoc" class="saisie">
    <form name="documentation" action="<?php echo $editFormAction; ?>" method="post" target="_self" enctype="multipart/form-data">
        <?php do { ?> <?php ($duplication == 1) ? $fiche = "" : $fiche = $row_rech_docum['INDEX_DOCUMENTATION']; ?>
        <input name="INDEX_DOCUMENTATION" type="hidden" value="<?php echo $fiche?>">
        <br>
        <div><a name="GENERALE"></a></div>
        <p class="titre">G&Eacute;N&Eacute;RALE</p>
        <table cellspacing="0" class="centpcent">
            <tr>
                <td valign="top">
                    <label for="" class="obligatoire"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=TYDOC&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=TYPE_DOCUMENT');">Type de document</a></label>
                    <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4123)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a><br>
                    <br>
                    <?php isset($_POST['TYPE_DOCUMENT']) ? $valeur = $_POST['TYPE_DOCUMENT'] : $valeur = $row_rech_docum['TYPE_DOCUMENT']; ?>
                    <input name="TYPE_DOCUMENT" class="inputlong40" value="<?php echo stripslashes($valeur)?>">
                </td>
                <td valign="top">
                    <label for="" class="obligatoire">Identifiant</label>
                    <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4101)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a><br>
                    <br>
                    <?php isset($_POST['IDENTIFIANT']) ? $valeur = $_POST['IDENTIFIANT'] : $valeur = $row_rech_docum['IDENTIFIANT']; ?>
                    <input name="IDENTIFIANT" class="inputlong40" value="<?php echo stripslashes($valeur)?>">
                    <?php ($duplication == 1) ? $num_ini = "" : $num_ini = $row_rech_docum['IDENTIFIANT']; ?>
                    <input name="IDENTIFIANT_INIT" type="hidden" value="<?php echo $num_ini ?>">
                </td>
            </tr>
            <tr>
                <td valign="top"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=TLIEU&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=LIEU_EDITION');">Lieu d&#8217;&eacute;dition ou d&#8217;exposition</a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4108)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a><br>
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
            <tr valign="top">
                <td>
                    <table cellspacing="0">
                        <tr>
                            <td colspan="4">Date d&#8217;&eacute;dition ou d&#8217;exposition <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4109)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a></td>
                        </tr>
                        <tr>
                            <td>Affixe<br>
                                <?php isset($_POST['TXTDATEEDITION']) ? $valeur = $_POST['TXTDATEEDITION'] : $valeur = $row_rech_docum['TXTDATEEDITION']; ?>
                                <input name="TXTDATEEDITION" type="text" class="inputnumerique" value="<?php echo stripslashes($valeur)?>">
                            </td>
                            <td>Date d&eacute;but<br>
                                <?php isset($_POST['DEBDATEEDITION']) ? $valeur = $_POST['DEBDATEEDITION'] : $valeur = $row_rech_docum['DEBDATEEDITION']; ?>
                                <input name="DEBDATEEDITION" type="text" class="inputnumerique" value="<?php echo stripslashes($valeur)?>">
                            </td>
                            <td valign="bottom">et</td>
                            <td>Date fin<br>
                                <?php isset($_POST['FINDATEEDITION']) ? $valeur = $_POST['FINDATEEDITION'] : $valeur = $row_rech_docum['FINDATEEDITION']; ?>
                                <input name="FINDATEEDITION" type="text" class="inputnumerique" value="<?php echo stripslashes($valeur)?>">
                            </td>
                        </tr>
                    </table>
                <td>&nbsp;</td>
            </tr>
            <tr valign="top">
                <td><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=AUT&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=EDITEUR');">Organisateur</a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4107)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a><br>
                    <br>
                    <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_auteur = "SELECT ETAT_CIVIL FROM personne,doc_per WHERE doc_per.INDEX_DOCUMENTATION =".$noFiche." AND personne.INDEX_PERSONNE = doc_per.INDEX_PERSONNE AND doc_per.QUALIFIANT = 'EDITEUR' ORDER BY INDEX_DOC_PER ASC";
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
} while ($row_auteur = mysql_fetch_assoc($auteur)); ?> <?php isset($_POST['EDITEUR']) ? $valeur = $_POST['EDITEUR'] : $valeur = $result; ?>
                    <input name="EDITEUR" class="inputlong40" type="text" value="<?php echo stripslashes($valeur)?>">
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr valign="top">
                <td><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=AUT&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=AUTEUR');">Commissaire</a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1413)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a><br>
                    <br>
                    <?php
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_auteur = "SELECT ETAT_CIVIL FROM personne,doc_per WHERE doc_per.INDEX_DOCUMENTATION =".$noFiche." AND personne.INDEX_PERSONNE = doc_per.INDEX_PERSONNE AND doc_per.QUALIFIANT = 'AUTEUR' ORDER BY INDEX_DOC_PER ASC";
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
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td valign="top">Commentaires <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4104)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a><br>
                    <br>
                    <?php isset($_POST['NOTE_LIBRE']) ? $valeur = $_POST['NOTE_LIBRE'] : $valeur = $row_rech_docum['NOTE_LIBRE']; ?>
                    <textarea name="NOTE_LIBRE" rows="4" class="textarealong60"><?php echo stripslashes($valeur)?></textarea>
                </td>
                <td valign="top">Commentaires&nbsp;techniques&nbsp;ou&nbsp;description&nbsp;physique&nbsp;<a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4106)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a><br>
                    <br>
                    <?php isset($_POST['COMMENTAIRE_TECHNIQUE']) ? $valeur = $_POST['COMMENTAIRE_TECHNIQUE'] : $valeur = $row_rech_docum['COMMENTAIRE_TECHNIQUE']; ?>
                    <textarea name="COMMENTAIRE_TECHNIQUE" rows="4" class="textarealong40"><?php echo stripslashes($valeur)?></textarea>
                </td>
            </tr>
            <tr>
                <td valign="top"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=PERIO&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=PERIODE_CONCERNE');">P&eacute;riode concern&eacute;e par le document</a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4110)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a><br>
                    <br>
                    <?php isset($_POST['PERIODE_CONCERNE']) ? $valeur = $_POST['PERIODE_CONCERNE'] : $valeur = $row_rech_docum['PERIODE_CONCERNE']; ?>
                    <textarea name="PERIODE_CONCERNE" rows="2" class="textarealong40"><?php echo stripslashes($valeur)?></textarea>
                </td>
                <td valign="top"><a href="javascript:FenetreTheso('fs_theso_hierar-sphinx.asp?__GroupId=286&amp;curtheso=MOCLE&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=MOTS_CLES');">Mots Cl&eacute;s</a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4112)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a><br>
                    <br>
                    <?php isset($_POST['MOTS_CLES']) ? $valeur = $_POST['MOTS_CLES'] : $valeur = $row_rech_docum['MOTS_CLES']; ?>
                    <textarea name="MOTS_CLES" rows="3" class="textarealong40"><?php echo stripslashes($valeur)?></textarea>
                </td>
            </tr>
        </table>
		<br>
        <div><a name="SUPPORT"></a></div>
        <p class="titre">SUPPORT</p>
        <table cellpadding="3" cellspacing="0" class="centpcent">
            <tr>
              <td colspan="3" align="center">
                <?php
					if ($valeurFichier != "") {?>
					Fichier image : <input name="FICHIER" type="text" value="<?php echo $valeurFichier ?>">
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
        <br>
        <div><a name="INFORMATIQUE"></a></div>
        <p class="titre">GESTION INFORMATIQUE</p>
        <table border="0" cellspacing="0" class="centpcent">
            <tr>
                <td valign="top">Copyright <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1902)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
                    <br>
					<?php ($duplication == 1) ? $noFiche = 0 : $noFiche = $noFiche; ?>
                    <?php if ($noFiche != 0 || $row_rech_docum['COPYRIGHT']=="") { ?>
                		<textarea name="COPYRIGHT" rows="3" class="textarealong40"><?php echo $_SESSION["musee"]?></textarea>
                    <?php } else { ?>
                    	<textarea name="COPYRIGHT" rows="3" class="textarealong40"><?php echo $row_rech_docum['COPYRIGHT']?></textarea>
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
                    <input name="CODEMUSEE" type="hidden" value="<?php echo $row_rech_docum['CODEMUSEE']?>">
                    <?php } else { ?>
                    <input name="CODEMUSEE" type="hidden" value="<?php echo($_SESSION["code_musee"]); ?>">
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
