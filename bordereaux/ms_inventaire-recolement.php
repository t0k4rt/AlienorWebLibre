<?php
$niveau_visa="";
$msg="";
$photo="";
$identifiant="";
$page = "inventaire-recolement";
//include('../Connections/alienorweblibre.php');
include('../include/base_objet.php');

if (!function_exists("GetSQLValueString")) {
	function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
	{
		$theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
		$theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);
		switch ($theType) {
			case "text":
				$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
				break;
			case "long":
			case "int":
				$theValue = ($theValue != "") ? intval($theValue) : "NULL";
				break;
			case "double":
				$theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
				break;
			case "date":
				$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
				break;
			case "defined":
				$theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
				break;
		}
	return $theValue;
	}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="fr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Language" content="fr">
<title>BORDEREAU D&#8217;INVENTAIRE - R&Eacute;COLEMENT</title>
<meta name="description" content="BORDEREAU D'INVENTAIRE - RECOLEMENT">
<link href="../style/tout.css" rel="stylesheet" type="text/css" media="all">
<link href="../style/imprime.css" rel="stylesheet" type="text/css" media="print">
<script language="JavaScript1.2" type="text/javascript" src="../include/RoboHelp_CSH.js"></script>
<script type="text/javascript">
<!--
<?php creerFenetreTheso(); ?>

function MM_validateForm() { //v4.0
  if (document.getElementById){
    var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
    for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=document.getElementById(args[i]);
      if (val) { nm=val.name; if ((val=val.value)!="") {
        if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
          if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
        } else if (test!='R') { num = parseFloat(val);
          if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
          if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
            min=test.substring(8,p); max=test.substring(p+1);
            if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
      } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
    } 
	chx =document.fiche.RECOLEMENT;
;	if (!chx[0].checked && !chx[1].checked && !chx[2].checked) errors += '- Lors d\'un récolement vous devez confirmer l\'emplacement de l\'objet. Préciser si l\'objet est localisé, détruit ou manquant';
	(errors) ? alert('Quelques omissions ou erreurs ont été trouvées :\n'+errors) : document.fiche.submit();
    document.MM_returnValue = (errors == '');
} }
//-->
</script>
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

</head>
<body>
<?php if ($msg != "") { ?>
<p style="color:#FF0000; font-weight:bold; text-align:center"><?php echo $msg; ?></p>
<?php } ?>
<?php do { ?>
    <form action="<?php echo $editFormAction; ?>" method="POST" name="fiche" id="fiche" title="Remplissage formulaire de recollement" enctype="multipart/form-data">
    <?php ($noFiche != 0) ? $index = $row_rech_objet['INDEX_OBJET'] : $index = ""; ?>
    <input name="INDEX_OBJET" type="hidden" value="<?php echo $index; ?>">
    <?php ($noFiche != 0) ? $code = $row_rech_objet['CODEMUSEE'] : $code = $_SESSION["code_musee"]; ?>
    <input name="CODEMUSEE" type="hidden" value="<?php echo $code ?>">
    <?php ($noFiche != 0) ? $creele = $row_rech_objet['FICHE_CREEE_LE'] : $creele = date("Y-m-d"); ?>
    <input name="FICHE_CREEE_LE" type="hidden" value="<?php echo $creele; ?>">
    <?php ($noFiche != 0) ? $creepar = $row_rech_objet['FICHE_CREEE_PAR'] : $creepar = $_SESSION["nom"]." ".$_SESSION["prenom"];; ?>
    <input name="FICHE_CREEE_PAR" type="hidden" value="<?php echo $creepar; ?>">
<table id="identification" >
    <tr>
        <td width="9%"><img src="../images/Logo_CIRM.jpg" alt="Logo du Conseil inter-r&eacute;gionnal des mus&eacute;es" name="logo" width="195" height="113" id="logo"></td>
        <td width="74%" class="centrage"><h1>Bordereau d&#8217;inventaire - R&eacute;colement</h1></td>
        <td width="17%" rowspan="7"><div>
                <!-- D&eacute;but de l'emplamcement de l'affichage image(s) -->
                <!-- Fin de l'emplamcement de l'affichage image(s) -->
                <?php
					mysql_select_db($database_alienorweblibre, $alienorweblibre);
					$query_docum = "SELECT IDENTIFIANT, documentation.INDEX_DOCUMENTATION, FICHIER FROM documentation,obj_doc WHERE obj_doc.INDEX_OBJET =".$noFiche." AND documentation.INDEX_DOCUMENTATION = obj_doc.INDEX_DOCUMENTATION AND obj_doc.QUALIFIANT = 'PHOTOGRAPHIE' ORDER BY INDEX_OBJ_DOC ASC";
					$docum = mysql_query($query_docum, $alienorweblibre) or die(mysql_error());
					$row_docum = mysql_fetch_assoc($docum);
					$totalRows_docum = mysql_num_rows($docum);
					$i = 0 ;
					if ($totalRows_docum != 0) {
						$photographie = $row_rech_objet['PHOTOGRAPHIE_PARAM'];
						do {
							if ($i != 0) {
							} 
							if ($photographie[$i] == 1) {
								echo " image de rep&eacute;rage";
							}
							// fabrication des tableaux d'images
							if ($row_docum['FICHIER'] != ""){
								if ($i == 0){
									$photo = $row_docum['FICHIER'];
									$identifiant = $row_docum['IDENTIFIANT'];
								}else{
									$photo = $photo."/".$row_docum['FICHIER'];
									$identifiant = $identifiant."/".$row_docum['IDENTIFIANT'];
								}
							}; //$row_docum['FICHIER'] != ""
							$i++;
						} while ($row_docum = mysql_fetch_assoc($docum)); 
					}?>
                <?php 
					$tabPhoto = split('/',$photo);
					$tabIdentifiant = split('/',$identifiant);
					$cpt = 0;
					foreach ($tabPhoto as $fichier){
						if ($fichier != ""){
						?>
                <br>
                <a href="<?php echo '../include/images.php?SRC='.$fichier.'&amp;LARG=980&amp;HAUT=700'; ?>" target="_blank"><img src="<?php echo "../include/images.php?SRC=".$fichier."&amp;CODMUS=".$row_rech_docum['CODEMUSEE']."&amp;LARG=150&amp;HAUT=150"; ?>" border="0" alt="visuel"></a><br>
                <?php
					echo $tabIdentifiant[$cpt]."<br><br>\n";
						$cpt++;
						};
					} ?>
            </div></td>
    </tr>
    <tr>
        <td>N&deg; d&#8217;inv.&nbsp; <a href="#" onClick="RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4122)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
        <td class="emphase"><?php (isset($_POST['NUMERO_INVENTAIRE'])) ? $valeur = $_POST['NUMERO_INVENTAIRE'] : $valeur = $row_rech_objet['NUMERO_INVENTAIRE']; ?>
            <input name="NUMERO_INVENTAIRE" type="text" value="<?php echo stripslashes($valeur); ?>" size="32">
            <input type="hidden" name="NUMERO_INVENTAIRE_INIT" id="NUMERO_INVENTAIRE_INIT" value="<?php echo stripslashes($valeur); ?>">
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td><?php 
			$valeur = $row_docum['COMMENTAIRES']; 
			$tableau_donnees = explode("/",$valeur);
			$champs_affiche = array("marqu&eacute;","etiquette fil","sur contenant");
			for($i = 0; $i < count($champs_affiche); $i++) { ?>
            <div class="caseAcocher">
                <label>
                <input name="MARQUAGE_CONSTATE" type="radio" value="<?php echo $champs_affiche[$i]; ?>"<?php
				$position = array_search($champs_affiche[$i],$tableau_donnees);
				if ($position === false) {
					;
				} else {?><?php } ?>>
                <?php echo $champs_affiche[$i]; ?></label>
            </div>
            <?php } ?></td>
    </tr>
    <tr>
        <td><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=DSCP&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=DISCIPLINE');"><span class="obligatoire">Discipline</span></a> <a href="#" onClick="RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1101)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
        <td class="emphase">
            <?php (isset($_POST['DISCIPLINE'])) ? $valeur = $_POST['DISCIPLINE'] : $valeur = $row_rech_objet['DISCIPLINE']; ?>
            <input name="DISCIPLINE" type="text" value="<?php echo stripslashes($valeur); ?>" size="32">
        </td>
    </tr>
    <tr>
        <td><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=DOMN&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=DOMAINE');"><span class="obligatoire">Domaine</span></a> <a href="#" onClick="RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1102)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
        <td class="emphase">
            <?php (isset($_POST['DOMAINE'])) ? $valeur = $_POST['DOMAINE'] : $valeur = $row_rech_objet['DOMAINE']; ?>
            <input name="DOMAINE" type="text" value="<?php echo stripslashes($valeur); ?>" size="32">
            </td>
    </tr>
    <tr>
        <td><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=DENO&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=DENOMINATION');">D&eacute;nomination</a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1103)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
        <td class="emphase"><?php (isset($_POST['DENOMINATION'])) ? $valeur = $_POST['DENOMINATION'] : $valeur = $row_rech_objet['DENOMINATION']; ?>
            <input name="DENOMINATION" type="text" value="<?php echo stripslashes($valeur); ?>" size="32"></td>
    </tr>
    <tr>
        <td>Titre&nbsp; <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1104)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
        <td class="emphase"><?php (isset($_POST['TITRE'])) ? $valeur = $_POST['TITRE'] : $valeur = $row_rech_objet['TITRE']; ?>
            <input name="TITRE" type="text" value="<?php echo stripslashes($valeur) ?>" size="32"></td>
    </tr>
</table>
<table>
    <tr>
        <td width="40%" class="quarant"><h2>Description - &Eacute;tat (Inscrit sur l&#8217;inventaire)</h2>
            <table>
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td width="21%"><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=MAT&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=MATIERE');">Mati&egrave;re</a>&nbsp; <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1301)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
                    <td width="79%" class="lighter"><?php (isset($_POST['MATIERE'])) ? $valeur = $_POST['MATIERE'] : $valeur = $row_rech_objet['MATIERE']; ?>
                        <input name="MATIERE" type="text" value="<?php echo stripslashes($valeur); ?>" size="32"></td>
                </tr>
                <tr>
                    <td><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=TECHN&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=TECHNIQUE');">Technique</a>&nbsp; <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1309)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
                    <td class="lighter"><?php (isset($_POST['TECHNIQUE'])) ? $valeur = $_POST['TECHNIQUE'] : $valeur = $row_rech_objet['TECHNIQUE']; ?>
                        <input name="TECHNIQUE" id="TECHNIQUE" type="text" value="<?php echo stripslashes($valeur); ?>" size="32"></td>
                </tr>
                <tr>
                    <td><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=TYPIN&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=TYPE_INSCRIPTION');">Type&nbsp;d&#8217;inscription</a><a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1304)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
                    <td class="lighter" style="text-align:justify"><span class="lignes">
                        <?php (isset($_POST['TYPE_INSCRIPTION'])) ? $valeur = $_POST['TYPE_INSCRIPTION'] : $valeur = $row_rech_objet['TYPE_INSCRIPTION']; ?>
                        <input name="TYPE_INSCRIPTION" type="text" value="<?php echo stripslashes($valeur); ?>" size="32">
                        </span></td>
                </tr>
                <tr>
                    <td>Dimensions&nbsp; <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1302)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
                    <td class="lighter"><span class="lignes"><?php echo $row_rech_objet['DIMENSIONS_FORMES']; ?>&nbsp;</span></td>
                </tr>
                <tr>
                    <td>Inscriptions&nbsp; </td>
                    <td class="lighter"><span class="lighter" style="text-align:justify"><?php echo $row_rech_objet['TRANSCRIPTION_INSCRIPTION']; ?>&nbsp;</span></td>
                </tr>
                <tr>
                    <td colspan="2" class="justifie"><span class="lignes">Description <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1308)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br>
                        <?php (isset($_POST['PRECISION_DESCRIPTION'])) ? $valeur = $_POST['PRECISION_DESCRIPTION'] : $valeur = $row_rech_objet['PRECISION_DESCRIPTION']; ?>
                        <textarea name="PRECISION_DESCRIPTION" cols="50" rows="4"><?php echo stripslashes($valeur); ?></textarea>
                        </span></td>
                </tr>
                <tr>
                    <td colspan="2">&Eacute;tat&nbsp;:</td>
                </tr>
                <tr>
                    <td colspan="2" class="justifie"><span class="lighter">
                        <?php 
						$tableDate = "";
						$query_gestion = "SELECT gestion.ETAT_CONSERVATION, gestion.DATE_CONSERVATION, gestion.EXPERT FROM gestion, obj_ges WHERE obj_ges.INDEX_GESTION = gestion.INDEX_GESTION AND gestion.ETAT_CONSERVATION != '' AND obj_ges.INDEX_OBJET = '".(int)$row_rech_objet['INDEX_OBJET']."' ORDER BY gestion.DATE_CONSERVATION DESC";
						$gestion = mysql_query($query_gestion, $alienorweblibre) or die(mysql_error());
						$row_gestion = mysql_fetch_assoc($gestion);
						$totalRows_gestion = mysql_num_rows($gestion);
						if ($totalRows_gestion != 0)
						{
							do
							{ 
								$tableEtat[] = $row_gestion['ETAT_CONSERVATION'];
								$tableDate[] = reverseDate($row_gestion['DATE_CONSERVATION']);
								$tableExpert[] = $row_gestion['EXPERT'];
							} while ($row_gestion = mysql_fetch_assoc($gestion));
							$dateRef = $tableDate[0];
							$select = 0;
							for($i = 0; $i < count($tableDate); $i++)
							{
								if ($tableDate[$i] > $dateRef)
								{
									$select++;
								}
							}
							if ($tableEtat[$select] != "") {
								if ($tableDate[$select] != "") {
									echo("Le ".$tableDate[$select]);
								}
								echo(" &agrave; &eacute;t&eacute; fait un &eacute;tat : ".$tableEtat[$select]);
							}
						}
						?>
                        &nbsp;</span></td>
                </tr>
            </table>
            <span class="lighter"><span class="lignes">&nbsp;</span></span></td>
        <td width="60%" class="soixant"><h2>Description - &Eacute;tat (constat&eacute; au r&eacute;colement)</h2>
            <table>
                <tr>
                    <td width="14%" height="20">Dimensions&nbsp; <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1302)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
                    <td width="86%" class="lignes"><?php (isset($_POST['DIMENSIONS_FORMES'])) ? $valeur = $_POST['DIMENSIONS_FORMES'] : $valeur = $row_rech_objet['DIMENSIONS_FORMES']; ?>
                        <input type="text" name="DIMENSIONS_FORMES" value="<?php echo stripslashes($valeur); ?>" size="32"></td>
                </tr>
                <tr>
                    <td colspan="2">Inscriptions&nbsp; <br>
                        <?php (isset($_POST['TRANSCRIPTION_INSCRIPTION'])) ? $valeur = $_POST['TRANSCRIPTION_INSCRIPTION'] : $valeur = $row_rech_objet['TRANSCRIPTION_INSCRIPTION']; ?>
                        <textarea name="TRANSCRIPTION_INSCRIPTION" cols="50" rows="3"><?php echo stripslashes($valeur); ?></textarea></td>
                </tr>
                <tr>
                    <td>&Eacute;tat&nbsp;</td>
                    <td class="lignes">&nbsp;</td>
                </tr>
                <tr>
                    <td height="72" colspan="2" id="etat"><?php 
						$valeur = "";
						if (isset($_POST['ETAT'])) {
							foreach($_POST['ETAT'] as $value) {
								$valeur .= $value."/";
							}
						}
						$tableau_donnees = explode("/",$valeur);
						$champs_affiche = array("sciure","trous","taches","dépigmenté","manques","humidité","désassembler","insectes","cassé, fêlé","moisi, sels","corrodé","poussière","déchiré");
						for($i = 0; $i < count($champs_affiche); $i++) { ?>
                        <div class="caseAcocher">
                            <label>
                            <input name="ETAT[]" type="checkbox" value="<?php echo $champs_affiche[$i]; ?>"<?php
							$position = array_search($champs_affiche[$i],$tableau_donnees);
							if ($position === false) {
								;
							} else {?><?php } ?>>
                            <?php echo $champs_affiche[$i]; ?></label>
                        </div>
                        <?php } ?></td>
                </tr>
                <tr>
                    <td>Conditionnement&nbsp;:</td>
                    <td><?php
						$valeur = "";
						if (isset($_POST['COMMENTAIRES'])) {
							foreach($_POST['COMMENTAIRES'] as $value) {
								$valeur .= $value."/";
							}
						}
						$tableau_donnees = explode("/",$valeur);
						$champs_affiche = array("immeuble","meuble");
							for($i = 0; $i < count($champs_affiche); $i++) { ?>
                        <div class="caseAcocher">
                            <label>
                            <input name="CONDITIONNEMENT" type="radio" value="<?php echo $champs_affiche[$i]; ?>"<?php
								$position = array_search($champs_affiche[$i],$tableau_donnees);
								if ($position === false) {
									;
								} else {?><?php } ?>>
                            <?php echo $champs_affiche[$i]; ?></label>
                        </div>
                        <?php } ?></td>
                </tr>
                <tr>
                    <td > Contenant&nbsp;:</td>
                    <td id="contenant"><?php
						$valeur = "";
						if (isset($_POST['COMMENTAIRES'])) {
							foreach($_POST['COMMENTAIRES'] as $value) {
								$valeur .= $value."/";
							}
						}
						$tableau_donnees = explode("/",$valeur);
						$champs_affiche = array("bois","plastique","papier","métal","carton","verre","tissu","sans");
						for($i = 0; $i < count($champs_affiche); $i++) { ?>
                        <div class="caseAcocher">
                            <label>
                            <input name="CONTENANT[]" type="checkbox" value="<?php echo $champs_affiche[$i]; ?>"<?php
							$position = array_search($champs_affiche[$i],$tableau_donnees);
							if ($position === false) {
								;
							} else {?><?php } ?>>
                            <?php echo $champs_affiche[$i]; ?></label>
                        </div>
                        <?php } ?></td>
                </tr>
            </table></td>
    </tr>
</table>
<table>
    <tr>
        <td class="unDemi"><h2>Donn&eacute;es sur la collecte / d&eacute;couverte</h2>
            <table>
                <tr>
                    <td width="31%">Collecteur,&nbsp;inventeur&nbsp;</td>
                    <td width="69%" class="lighter"><?php
						$query_auteur = "SELECT personne.INDEX_PERSONNE, ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET = ".(int)$row_rech_objet['INDEX_OBJET']." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'COLLECTEUR' ORDER BY INDEX_OBJ_PER ASC";
						//echo("\$query_auteur : ".$query_auteur);
						$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
						$row_auteur = mysql_fetch_assoc($auteur);
						$totalRows_auteur = mysql_num_rows($auteur);
						$i = 0;
						$result = "";
						if ($totalRows_auteur != 0)
						{ 
							do {
								if ($i !=0 ) {
									$result .= "/";
								}
								$result .= $row_auteur['ETAT_CIVIL'];
								$i++;
							} while ($row_auteur = mysql_fetch_assoc($auteur));
						} ?>
                        <?php (isset($_POST['COLLECTEUR'])) ? $valeur = $_POST['COLLECTEUR'] : $valeur = $result; ?>
                        <label for="COLLECTEUR"><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=AUT&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=COLLECTEUR');">Collecteur</a></label>
                        <span class="lighter">
                        <input type="text" name="COLLECTEUR" id="COLLECTEUR" value="<?php echo stripslashes($valeur); ?>" size="32">
                        </span> <br>
                        <?php
						// inventeur
						$query_auteur = "SELECT personne.INDEX_PERSONNE, ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET = ".(int)$row_rech_objet['INDEX_OBJET']." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'INVENTEUR' ORDER BY INDEX_OBJ_PER ASC";
						//echo("\$query_auteur : ".$query_auteur);
						$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
						$row_auteur = mysql_fetch_assoc($auteur);
						$totalRows_auteur = mysql_num_rows($auteur);
						$i = 0;
						$result = "";
						if ($totalRows_auteur != 0)
						{ 
							do {
								if ($i !=0 ) {
									$result .= "/";
								}
								$result .= $row_auteur['ETAT_CIVIL'];
								$i++;
							} while ($row_auteur = mysql_fetch_assoc($auteur));
						} ?>
                        <?php (isset($_POST['INVENTEUR'])) ? $valeur = $_POST['INVENTEUR'] : $valeur = $result; ?>
                        <label for="INVENTEUR"><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=AUT&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=INVENTEUR');">Inventeur</a></label>
                        <input type="text" id="INVENTEUR" name="INVENTEUR" value="<?php echo stripslashes($valeur); ?>" size="32">
                    </td>
                </tr>
                <tr>
                    <td><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=TLIEU&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=LIEUX_DECOUVERTE');">Lieu de collecte</a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1201)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
                    <td class="lighter"><?php
$query_lieu = "SELECT lieu.INDEX_LIEU, SITE FROM lieu,obj_lie WHERE obj_lie.INDEX_OBJET =".(int)$row_rech_objet['INDEX_OBJET']." AND lieu.INDEX_LIEU = obj_lie.INDEX_LIEU AND obj_lie.QUALIFIANT = 'LIEUX_DECOUVERTE' ORDER BY INDEX_OBJ_LIE ASC";
						$lieu = mysql_query($query_lieu, $alienorweblibre) or die(mysql_error());
						$row_lieu = mysql_fetch_assoc($lieu);
						$totalRows_lieu = mysql_num_rows($lieu);
						$result = "";
						$i = 0;
						if ($totalRows_lieu != 0) {
							do {
								if ($i !=0 ) {
									$result .= "/";
								}
								$result .= $row_lieu['SITE'];
								$i++;
							} while ($row_lieu = mysql_fetch_assoc($lieu));
						}
						?>
                        <?php (isset($_POST['LIEUX_DECOUVERTE'])) ? $valeur = $_POST['LIEUX_DECOUVERTE'] : $valeur = $result; ?>
                        <input type="text" name="LIEUX_DECOUVERTE" value="<?php echo stripslashes($valeur) ?>" size="32"></td>
                </tr>
                <tr>
                    <td>Date de collecte&nbsp;:</td>
                    <td class="lighter">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2"><table width="200" border="0" cellpadding="0" cellspacing="0" class="date">
                            <tr>
                                <td align="center"><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=AFFIXEDATE&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=TXT_DATE_DECOUVERTE');">Affixe</a></td>
                                <td align="center">date d&eacute;but</td>
                                <td align="center">date fin</td>
                            </tr>
                            <tr>
                                <td align="center"><span class="lighter">
                                    <?php (isset($_POST['TXT_DATE_DECOUVERTE'])) ? $valeur = $_POST['TXT_DATE_DECOUVERTE'] : $valeur = $row_rech_objet['TXT_DATE_DECOUVERTE']; ?>
                                    <input name="TXT_DATE_DECOUVERTE" type="text" value="<?php echo stripslashes($valeur); ?>" size="10">
                                    </span></td>
                                <td align="center"><span class="lighter">
                                    <?php (isset($_POST['DEB_DATE_DECOUVERTE'])) ? $valeur = $_POST['DEB_DATE_DECOUVERTE'] : $valeur = $row_rech_objet['DEB_DATE_DECOUVERTE']; ?>
                                    <input name="DEB_DATE_DECOUVERTE" type="text" value="<?php echo reverseDate(stripslashes($valeur)); ?>" size="10">
                                    </span></td>
                                <td align="center"><span class="lighter">
                                    <?php (isset($_POST['FIN_DATE_DECOUVERTE'])) ? $valeur = $_POST['FIN_DATE_DECOUVERTE'] : $valeur = $row_rech_objet['FIN_DATE_DECOUVERTE']; ?>
                                    <input name="FIN_DATE_DECOUVERTE" type="text" value="<?php echo reverseDate(stripslashes($valeur)); ?>" size="10">
                                    </span></td>
                            </tr>
                        </table></td>
                </tr>
                <tr>
                    <td colspan="2">Pr&eacute;cision&nbsp;sur&nbsp;la&nbsp;collecte&nbsp; <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1203)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
                </tr>
                <tr>
                    <td colspan="2" class="justifie"><span class="lignes">
                        <?php (isset($_POST['PRECISION_DECOUVERTE'])) ? $valeur = $_POST['PRECISION_DECOUVERTE'] : $valeur = $row_rech_objet['PRECISION_DECOUVERTE']; ?>
                        <textarea name="PRECISION_DECOUVERTE" cols="50" rows="3"><?php echo stripslashes($valeur); ?></textarea>
                        </span></td>
                </tr>
            </table></td>
        <td class="unDemi"><h2>Donn&eacute;es sur l&#8217;ex&eacute;cution </h2>
            <table>
                <tr>
                    <td width="30%"><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=AUT&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=AUTEUR');">Auteur</a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1413)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
                    <td width="70%" class="lighter"><?php
						$query_auteur = "SELECT personne.INDEX_PERSONNE, ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET = ".(int)$row_rech_objet['INDEX_OBJET']." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'AUTEUR' ORDER BY INDEX_OBJ_PER ASC";
						$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
						$row_auteur = mysql_fetch_assoc($auteur);
						$totalRows_auteur = mysql_num_rows($auteur);
						$result = "";
						$i = 0;
						if ($totalRows_auteur != 0)
						{ 
							do {
								if ($i !=0 ) {
									$result .= "/";
								}
								$result .= $row_auteur['ETAT_CIVIL'];
								$i++;
							} while ($row_auteur = mysql_fetch_assoc($auteur));
						} ?>
                        <?php (isset($_POST['AUTEUR'])) ? $valeur = $_POST['AUTEUR'] : $valeur = $result; ?>
                        <input type="text" name="AUTEUR" id="AUTEUR" value="<?php echo stripslashes($valeur); ?>" size="32">
                        <?php
						// Attribution
						$query_auteur = "SELECT personne.INDEX_PERSONNE, ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET = ".(int)$row_rech_objet['INDEX_OBJET']." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'ATTRIBUTION' ORDER BY INDEX_OBJ_PER ASC";
						$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
						$row_auteur = mysql_fetch_assoc($auteur);
						$totalRows_auteur = mysql_num_rows($auteur);
						$result = "";
						$i= 0;
						if ($totalRows_auteur != 0)
						{ 
							do 
							{
								if ($i !=0 ) {
									$result .= "/";
								}
								$result .= $row_auteur['ETAT_CIVIL'];
								$i++;
							} while ($row_auteur = mysql_fetch_assoc($auteur));
						} ?></td>
                </tr>
                <tr>
                    <td><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=ROLE&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=ROLE');">R&ocirc;le de l&#8217;auteur</a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1414)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a></td>
                    <td width="70%" class="lighter"><?php (isset($_POST['ROLE'])) ? $valeur = $_POST['ROLE'] : $valeur = $row_rech_objet['ROLE']; ?>
                        <input type="text" name="ROLE" value="<?php echo stripslashes($valeur); ?>" size="32"></td>
                </tr>
                <tr>
                    <td><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=AUT&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=ATTRIBUTION');">Attribution</a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1416)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
                    <td width="70%" class="lighter"><?php (isset($_POST['ATTRIBUTION'])) ? $valeur = $_POST['ATTRIBUTION'] : $valeur = $result; ?>
                        <input type="text" name="ATTRIBUTION" id="ATTRIBUTION" value="<?php echo stripslashes($valeur); ?>" size="32"></td>
                </tr>
                <tr>
                    <td><span class="lighter">
                        <label for="ATTRIBUTEUR"><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=AUT&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=ATTRIBUTEUR');">Attributeur</a></label>
                        </span><a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1417)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
                    <td width="70%" class="lighter"><?php
						//Attributeur
						$query_auteur = "SELECT personne.INDEX_PERSONNE, ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET = ".(int)$row_rech_objet['INDEX_OBJET']." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'ATTRIBUTEUR' ORDER BY INDEX_OBJ_PER ASC";
						$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
						$row_auteur = mysql_fetch_assoc($auteur);
						$totalRows_auteur = mysql_num_rows($auteur);
						$result = "";
						$i= 0;
						if ($totalRows_auteur != 0)
						{ 
							do 
							{
								if ($i !=0 ) {
									$result .= "/";
								}
								$result .= $row_auteur['ETAT_CIVIL'];
								$i++;
							} while ($row_auteur = mysql_fetch_assoc($auteur));
						} ?>
                        <?php (isset($_POST['ATTRIBUTEUR'])) ? $valeur = $_POST['ATTRIBUTEUR'] : $valeur = $result; ?>
                        <input type="text" name="ATTRIBUTEUR" id="ATTRIBUTEUR" value="<?php echo stripslashes($valeur); ?>" size="32"></td>
                </tr>
                <tr>
                    <td>Date d&#8217;attribution <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1418)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
                    <td class="lighter"><table width="200" border="0" cellpadding="0" cellspacing="0" class="date">
                            <tr>
                                <td align="center"><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=AFFIXEDATE&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=TXT_DATE_ATTRIBUTION');">Affixe</a></td>
                                <td align="center">date d&eacute;but</td>
                                <td align="center">date fin</td>
                            </tr>
                            <tr>
                                <td align="center"><?php (isset($_POST['TXT_DATE_ATTRIBUTION'])) ? $valeur = $_POST['TXT_DATE_ATTRIBUTION'] : $valeur = $row_rech_objet['TXT_DATE_ATTRIBUTION']; ?>
                                    <input name="TXT_DATE_ATTRIBUTION" type="text" value="<?php echo stripslashes($valeur); ?>" size="10"></td>
                                <td align="center"><?php (isset($_POST['DEB_DATE_ATTRIBUTION'])) ? $valeur = $_POST['DEB_DATE_ATTRIBUTION'] : $valeur = $row_rech_objet['DEB_DATE_ATTRIBUTION']; ?>
                                    <input name="DEB_DATE_ATTRIBUTION" type="text" value="<?php echo reverseDate(stripslashes($valeur)); ?>" size="10"></td>
                                <td align="center"><?php (isset($_POST['FIN_DATE_ATTRIBUTION'])) ? $valeur = $_POST['FIN_DATE_ATTRIBUTION'] : $valeur = $row_rech_objet['FIN_DATE_ATTRIBUTION']; ?>
                                    <input name="FIN_DATE_ATTRIBUTION" type="text" value="<?php echo reverseDate(stripslashes($valeur)); ?>" size="10"></td>
                            </tr>
                        </table></td>
                </tr>
                <tr>
                    <td width="30%"><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=TLIEU&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=LIEUX_EXECUTION');">Lieu d&#8217;ex&eacute;cution</a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1401)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a></td>
                    <td width="70%" class="lighter"><?php
						$query_lieu = "SELECT lieu.INDEX_LIEU, SITE FROM lieu,obj_lie WHERE obj_lie.INDEX_OBJET =".(int)$row_rech_objet['INDEX_OBJET']." AND lieu.INDEX_LIEU = obj_lie.INDEX_LIEU AND obj_lie.QUALIFIANT = 'LIEUX_EXECUTION' ORDER BY INDEX_OBJ_LIE ASC";
						$lieu = mysql_query($query_lieu, $alienorweblibre) or die(mysql_error());
						$row_lieu = mysql_fetch_assoc($lieu);
						$totalRows_lieu = mysql_num_rows($lieu);
						$result = "";
						$i = 0 ;
						if ($totalRows_lieu != 0)
						{
							do 
							{
								if ($i !=0 ) {
									$result .= "/";
								}
								$result .= $row_lieu['SITE'];
								$i++;
							} while ($row_lieu = mysql_fetch_assoc($lieu));
						}
						?>
                        <?php (isset($_POST['LIEUX_EXECUTION'])) ? $valeur = $_POST['LIEUX_EXECUTION'] : $valeur = $result; ?>
                        <input type="text" name="LIEUX_EXECUTION" value="<?php echo stripslashes($valeur); ?>" size="32"></td>
                </tr>
                <tr>
                    <td width="30%">Date&nbsp;d&#8217;ex&eacute;cution&nbsp; <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1406)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a></td>
                    <td width="70%" class="lighter"><table width="200" border="0" cellpadding="0" cellspacing="0" class="date">
                            <tr>
                                <td align="center"><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=AFFIXEDATE&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=TXT_DATE_EXECUTION');">Affixe</a></td>
                                <td align="center">date d&eacute;but</td>
                                <td align="center">date fin</td>
                            </tr>
                            <tr>
                                <td align="center"><?php (isset($_POST['TXT_DATE_EXECUTION'])) ? $valeur = $_POST['TXT_DATE_EXECUTION'] : $valeur = $row_rech_objet['TXT_DATE_EXECUTION']; ?>
                                    <input name="TXT_DATE_EXECUTION" type="text" value="<?php echo stripslashes($valeur); ?>" size="10"></td>
                                <td align="center"><?php (isset($_POST['DEB_DATE_EXECUTION'])) ? $valeur = $_POST['DEB_DATE_EXECUTION'] : $valeur = $row_rech_objet['DEB_DATE_EXECUTION']; ?>
                                    <input name="DEB_DATE_EXECUTION" type="text" value="<?php echo reverseDate(stripslashes($valeur)); ?>" size="10"></td>
                                <td align="center"><?php (isset($_POST['FIN_DATE_EXECUTION'])) ? $valeur = $_POST['FIN_DATE_EXECUTION'] : $valeur = $row_rech_objet['FIN_DATE_EXECUTION']; ?>
                                    <input name="FIN_DATE_EXECUTION" type="text" value="<?php echo reverseDate(stripslashes($valeur)); ?>" size="10"></td>
                            </tr>
                        </table></td>
                </tr>
                <tr>
                    <td colspan="2">Pr&eacute;cision&nbsp;sur&nbsp;la&nbsp;gen&egrave;se&nbsp; <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1405)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a></td>
                </tr>
                <tr>
                    <td colspan="2" class="justifie"><span class="lighter">
                        <?php (isset($_POST['PRECISION_GENESE'])) ? $valeur = $_POST['PRECISION_GENESE'] : $valeur = $row_rech_objet['PRECISION_GENESE']; ?>
                        <textarea name="PRECISION_GENESE" cols="50" rows="3"><?php echo stripslashes($valeur); ?></textarea>
                        </span></td>
                </tr>
            </table></td>
    </tr>
</table>
<table>
    <tr>
        <td class="unDemi"><h2>Donn&eacute;es sur l&#8217;utilisation</h2>
            <table width="100%">
                <tr>
                    <td width="15%"><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=UTIL&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=UTILISATION');">Utilisation</a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1501)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
                    <td width="85%" class="lighter"><?php (isset($_POST['UTILISATION'])) ? $valeur = $_POST['UTILISATION'] : $valeur = $row_rech_objet['UTILISATION']; ?>
                        <input type="text" name="UTILISATION" value="<?php echo stripslashes($valeur); ?>" size="32">
                    </td>
                </tr>
            </table></td>
        <td class="unDemi"><h2>Gestion</h2>
            <table>
                <tr>
                    <td width="20%">Valeur&nbsp;d&#8217;achat&nbsp;</td>
                    <td  width="80%" class="lighter"><?php 
						$query_gestion = "SELECT gestion.VALEUR, gestion.DATE_VALEUR FROM gestion, obj_ges WHERE obj_ges.INDEX_GESTION = gestion.INDEX_GESTION AND gestion.VALEUR != '' AND obj_ges.INDEX_OBJET = '".(int)$row_rech_objet['INDEX_OBJET']."' ORDER BY gestion.DATE_VALEUR DESC";
						$gestion = mysql_query($query_gestion, $alienorweblibre) or die(mysql_error());
						$row_gestion = mysql_fetch_assoc($gestion);
						$totalRows_gestion = mysql_num_rows($gestion);
						$result = "";
						$tableDate = "";
						$tableValeur = "";
						$dateRef = "";
						if ($totalRows_gestion != 0)
						{
							do
							{ 
								$tableValeur[] = $row_gestion['VALEUR'];
								$tableDate[] = $row_gestion['DATE_VALEUR'];
							} while ($row_gestion = mysql_fetch_assoc($gestion));
							$dateRef = $tableDate[0];
							$select = 0;
							for($i = 0; $i < count($tableDate); $i++)
							{
								if ($tableDate[$i] > $dateRef)
								{
									$select++;
								}
							}
							$result = $tableValeur[$select];
						}
						?>
                        <?php (isset($_POST['VALEUR'])) ? $valeur = $_POST['VALEUR'] : $valeur = $result; ?>
                        <input type="text" name="VALEUR" value="<?php echo stripslashes($valeur) ?>" size="32"></td>
                </tr>
            </table></td>
    </tr>
</table>
<h2>Administration</h2>
<table>
    <tr>
        <td><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=AUT&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=SERVICE_GESTIONNAIRE');"><span class="obligatoire">Service gestionnaire</span></a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1624)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
        <td class="lighter"><?php
			$query_auteur = "SELECT personne.INDEX_PERSONNE, ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET = ".(int)$row_rech_objet['INDEX_OBJET']." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'SERVICE_GESTIONNAIRE' ORDER BY INDEX_OBJ_PER ASC";
			//echo("\$query_auteur : ".$query_auteur);
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
			} while ($row_auteur = mysql_fetch_assoc($auteur));
			?>
            <?php (isset($_POST['SERVICE_GESTIONNAIRE'])) ? $valeur = $_POST['SERVICE_GESTIONNAIRE'] : $valeur = $result; ?>
            <input type="text" name="SERVICE_GESTIONNAIRE" value="<?php echo stripslashes($valeur); ?>" size="32"></td>
        <td><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=TYPRO&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=TYPE_PROPRIETE');"><span class="obligatoire">Type de propri&eacute;t&eacute;</span></a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1618)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a><br></td>
        <td class="lighter"><?php isset($_POST['TYPE_PROPRIETE']) ? $valeur = $_POST['TYPE_PROPRIETE'] : $valeur = $row_rech_objet['TYPE_PROPRIETE']; ?>
            <input type="text"  name="TYPE_PROPRIETE" class="inputlong40" value="<?php echo stripslashes($valeur)?>"></td>
    </tr>
    <tr>
        <td width="13%"><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=AUT&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=PROPRIETAIRE');"><span class="obligatoire">Propri&eacute;taire</span></a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1617)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
        <td width="37%" class="lighter"><?php
			$query_auteur = "SELECT personne.INDEX_PERSONNE, ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET = ".(int)$row_rech_objet['INDEX_OBJET']." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'PROPRIETAIRE' ORDER BY INDEX_OBJ_PER ASC";
			//echo("\$query_auteur : ".$query_auteur);
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
			} while ($row_auteur = mysql_fetch_assoc($auteur));
			?>
            <?php (isset($_POST['PROPRIETAIRE'])) ? $valeur = $_POST['PROPRIETAIRE'] : $valeur = $result; ?>
            <input type="text" name="PROPRIETAIRE" value="<?php echo stripslashes($valeur); ?>" size="32">
        </td>
        <td width="14%"><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=MACQ&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=MODE_ACQUISITION');"><span class="obligatoire">Mode&nbsp;d&#8217;acquisition</span></a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1603)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
        <td width="36%" class="lighter"><?php (isset($_POST['MODE_ACQUISITION'])) ? $valeur = $_POST['MODE_ACQUISITION'] : $valeur = $row_rech_objet['MODE_ACQUISITION']; ?>
            <input type="text" name="MODE_ACQUISITION" value="<?php echo stripslashes($valeur); ?>" size="32"></td>
    </tr>
    <tr>
        <td>Date&nbsp;de&nbsp;l&#8217;acquisition&nbsp; <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1619)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
        <td class="lighter"><span class="lighter" style="text-align:justify">&nbsp;</span>
            <table width="200" border="0" cellpadding="0" cellspacing="0" class="date">
                <tr>
                    <td align="center"><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=AFFIXEDATE&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=PROPRIETAIRE_TXT_DATE_PATRIMONIALE');">Affixe</a></td>
                    <td align="center">date d&eacute;but</td>
                    <td align="center">date fin</td>
                </tr>
                <tr>
                    <td align="center"><?php (isset($_POST['PROPRIETAIRE_TXT_DATE_PATRIMONIALE'])) ? $valeur = $_POST['PROPRIETAIRE_TXT_DATE_PATRIMONIALE'] : $valeur = $row_rech_objet['PROPRIETAIRE_TXT_DATE_PATRIMONIALE']; ?>
                        <input name="PROPRIETAIRE_TXT_DATE_PATRIMONIALE" type="text" value="<?php echo stripslashes($valeur); ?>" size="10"></td>
                    <td align="center"><?php (isset($_POST['PROPRIETAIRE_DEB_DATE_PATRIMONIALE'])) ? $valeur = $_POST['PROPRIETAIRE_DEB_DATE_PATRIMONIALE'] : $valeur = $row_rech_objet['PROPRIETAIRE_DEB_DATE_PATRIMONIALE']; ?>
                        <input name="PROPRIETAIRE_DEB_DATE_PATRIMONIALE" type="text" value="<?php echo reverseDate(stripslashes($valeur)); ?>" size="10"></td>
                    <td align="center"><?php (isset($_POST['PROPRIETAIRE_FIN_DATE_PATRIMONIALE'])) ? $valeur = $_POST['PROPRIETAIRE_FIN_DATE_PATRIMONIALE'] : $valeur = $row_rech_objet['PROPRIETAIRE_FIN_DATE_PATRIMONIALE']; ?>
                        <input name="PROPRIETAIRE_FIN_DATE_PATRIMONIALE" type="text" value="<?php echo reverseDate(stripslashes($valeur)); ?>" size="10"></td>
                </tr>
            </table></td>
        <td>Date de la commission <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1613)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
        <td class="lighter" style="text-align:justify"><span class="lignes">
            <?php (isset($_POST['PRECISION_ADMINISTRATIVE'])) ? $valeur = $_POST['PRECISION_ADMINISTRATIVE'] : $valeur = reverseDate($row_rech_objet['PRECISION_ADMINISTRATIVE']); ?>
            <input type="text" name="PRECISION_ADMINISTRATIVE" value="<?php echo stripslashes($valeur); ?>" size="32">
            </span></td>
    </tr>
    <tr>
        <td><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=AUT&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=ANCIENNE_APPARTENANCE');">Ancienne&nbsp;appartenance</a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1614)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
        <td class="lighter"><?php
			// Ancienne appartenance ***************************************************************
			$query_auteur = "SELECT personne.INDEX_PERSONNE, personne.ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET = ".(int)$row_rech_objet['INDEX_OBJET']." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'ANCIENNE_APPARTENANCE' ORDER BY INDEX_OBJ_PER ASC";
			$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
			$row_auteur = mysql_fetch_assoc($auteur);
			$totalRows_auteur = mysql_num_rows($auteur);
			$result = "";
			$i = 0;
			if ($totalRows_auteur != 0)
			{ 
				do
				{
					if ($i !=0 ) {
						$result .= "/";
					}
					$result .= $row_auteur['ETAT_CIVIL'];
					$i++;
				} while ($row_auteur = mysql_fetch_assoc($auteur));
			}
			?>
            <input type="text" name="ANCIENNE_APPARTENANCE" id="ANCIENNE_APPARTENANCE" value="<?php echo $result; ?>" size="32"></td>
        <td rowspan="5">Emplacement&nbsp;<a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,5217)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
        <td rowspan="5" class="lighter"><?php 
			$query_gestion = "SELECT DISTINCT gestion.EMPLACEMENT, gestion.DATE_EMPLACEMENT FROM gestion, obj_ges WHERE obj_ges.INDEX_GESTION = gestion.INDEX_GESTION AND gestion.EMPLACEMENT != '' AND obj_ges.INDEX_OBJET = '".(int)$row_rech_objet['INDEX_OBJET']."' ORDER BY gestion.DATE_EMPLACEMENT DESC";
			$gestion = mysql_query($query_gestion, $alienorweblibre) or die(mysql_error());
			$row_gestion = mysql_fetch_assoc($gestion);
			$totalRows_gestion = mysql_num_rows($gestion);
			$result = "";
			$tableDate = "";
			$tableEmplacement = "";
			$dateRef = "";
			if ($totalRows_gestion != 0)
			{
				do
				{ 
					$tableEmplacement[] = $row_gestion['EMPLACEMENT'];
					$tableDate[] = $row_gestion['DATE_EMPLACEMENT'];
				} while ($row_gestion = mysql_fetch_assoc($gestion));
				$dateRef = $tableDate[0];
				$select = 0;
				for($i = 0; $i < count($tableDate); $i++)
				{
					if ($tableDate[$i] > $dateRef)
					{
						$select++;
					}
				}
				$result = $tableEmplacement[$select];
			}
			?>
            <input type="text" name="EMPLACEMENT" value="<?php echo $result; ?>" size="32">
            <br>
            <div class="caseAcocher">
                <?php
				$valeur = "";
				$champs_affiche = array("localis&eacute;","d&eacute;truit","manquant");
				
				for($i = 0; $i < count($champs_affiche); $i++) { ?>
                <input name="RECOLEMENT" type="radio" value="<?php echo $champs_affiche[$i]; ?>"<?php
					$position = array_search($champs_affiche[$i],$tableau_donnees);
					if ($position === false) {
						;
					} else {?><?php } ?>>
                <?php echo $champs_affiche[$i]; ?>
                <?php } ?>
            </div></td>
    </tr>
    <tr>
        <td>Date d&#8217;entr&eacute;e&nbsp;: <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1614)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
        <td class="lighter"><span class="lighter" style="text-align:justify">&nbsp;</span>
            <table width="200" border="0" cellpadding="0" cellspacing="0" class="date">
                <tr>
                    <td align="center"><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=AFFIXEDATE&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=ANCIENNE_APPARTENANCE_TXT_DATE_PATRIMONIALE');">Affixe</a></td>
                    <td align="center">date d&eacute;but</td>
                    <td align="center">date fin</td>
                </tr>
                <tr>
                    <td align="center"><?php (isset($_POST['ANCIENNE_APPARTENANCE_TXT_DATE_PATRIMONIALE'])) ? $valeur = $_POST['ANCIENNE_APPARTENANCE_TXT_DATE_PATRIMONIALE'] : $valeur = $row_rech_objet['ANCIENNE_APPARTENANCE_TXT_DATE_PATRIMONIALE']; ?>
                        <input name="ANCIENNE_APPARTENANCE_TXT_DATE_PATRIMONIALE" type="text" value="<?php echo stripslashes($valeur); ?>" size="10"></td>
                    <td align="center"><?php (isset($_POST['ANCIENNE_APPARTENANCE_DEB_DATE_PATRIMONIALE'])) ? $valeur = $_POST['ANCIENNE_APPARTENANCE_DEB_DATE_PATRIMONIALE'] : $valeur = $row_rech_objet['ANCIENNE_APPARTENANCE_DEB_DATE_PATRIMONIALE']; ?>
                        <input name="ANCIENNE_APPARTENANCE_DEB_DATE_PATRIMONIALE" type="text" value="<?php echo reverseDate(stripslashes($valeur)); ?>" size="10"></td>
                    <td align="center"><?php (isset($_POST['ANCIENNE_APPARTENANCE_FIN_DATE_PATRIMONIALE'])) ? $valeur = $_POST['ANCIENNE_APPARTENANCE_FIN_DATE_PATRIMONIALE'] : $valeur = $row_rech_objet['ANCIENNE_APPARTENANCE_FIN_DATE_PATRIMONIALE']; ?>
                        <input name="ANCIENNE_APPARTENANCE_FIN_DATE_PATRIMONIALE" type="text" value="<?php echo reverseDate(stripslashes($valeur)); ?>" size="10"></td>
                </tr>
            </table></td>
    </tr>
    <tr>
        <td><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=AUT&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=COMMISSAIRE_PRISEUR');">Commissaire priseur</a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1620)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
        <td class="lighter"><?php
			// Commissaire priseur ***************************************************************
			$query_auteur = "SELECT personne.INDEX_PERSONNE, personne.ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET = ".(int)$row_rech_objet['INDEX_OBJET']." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'COMMISSAIRE_PRISEUR' ORDER BY INDEX_OBJ_PER ASC";
			$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
			$row_auteur = mysql_fetch_assoc($auteur);
			$totalRows_auteur = mysql_num_rows($auteur);
			$result = "";
			$i = 0;
			if ($totalRows_auteur != 0)
			{ 
				do
				{
					if ($i !=0 ) {
						$result .= "/";
					}
					$result .= $row_auteur['ETAT_CIVIL'];
					$i++;
				} while ($row_auteur = mysql_fetch_assoc($auteur));
			}
			?>
            <input type="text" name="COMMISSAIRE_PRISEUR" id="COMMISSAIRE_PRISEUR" value="<?php echo $result; ?>" size="32"></td>
    </tr>
    <tr>
        <td>Date d&#8217;entr&eacute;e&nbsp; <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1615)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
        <td class="lighter"><span class="lighter" style="text-align:justify">&nbsp;</span>
            <table width="200" border="0" cellpadding="0" cellspacing="0" class="date">
                <tr>
                    <td align="center"><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=AFFIXEDATE&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=COMMISSAIRE_PRISEUR_TXT_DATE_PATRIMONIALE');">Affixe</a></td>
                    <td align="center">date d&eacute;but</td>
                    <td align="center">date fin</td>
                </tr>
                <tr>
                    <td align="center"><?php (isset($_POST['COMMISSAIRE_PRISEUR_TXT_DATE_PATRIMONIALE'])) ? $valeur = $_POST['COMMISSAIRE_PRISEUR_TXT_DATE_PATRIMONIALE'] : $valeur = $row_rech_objet['COMMISSAIRE_PRISEUR_TXT_DATE_PATRIMONIALE']; ?>
                        <input name="COMMISSAIRE_PRISEUR_TXT_DATE_PATRIMONIALE" type="text" value="<?php echo stripslashes($valeur); ?>" size="10"></td>
                    <td align="center"><?php (isset($_POST['COMMISSAIRE_PRISEUR_DEB_DATE_PATRIMONIALE'])) ? $valeur = $_POST['COMMISSAIRE_PRISEUR_DEB_DATE_PATRIMONIALE'] : $valeur = $row_rech_objet['COMMISSAIRE_PRISEUR_DEB_DATE_PATRIMONIALE']; ?>
                        <input name="COMMISSAIRE_PRISEUR_DEB_DATE_PATRIMONIALE" type="text" value="<?php echo reverseDate(stripslashes($valeur)); ?>" size="10"></td>
                    <td align="center"><?php (isset($_POST['COMMISSAIRE_PRISEUR_FIN_DATE_PATRIMONIALE'])) ? $valeur = $_POST['COMMISSAIRE_PRISEUR_FIN_DATE_PATRIMONIALE'] : $valeur = $row_rech_objet['COMMISSAIRE_PRISEUR_FIN_DATE_PATRIMONIALE']; ?>
                        <input name="COMMISSAIRE_PRISEUR_FIN_DATE_PATRIMONIALE" type="text" value="<?php echo reverseDate(stripslashes($valeur)); ?>" size="10"></td>
                </tr>
            </table></td>
    </tr>
    <tr>
        <td><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=AUT&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=GALERIE');">Galerie</a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1623)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
        <td class="lighter"><?php
			// Galerie ***************************************************************
			$query_auteur = "SELECT personne.INDEX_PERSONNE, personne.ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET = ".(int)$row_rech_objet['INDEX_OBJET']." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'GALERIE' ORDER BY INDEX_OBJ_PER ASC";
			$auteur = mysql_query($query_auteur, $alienorweblibre) or die(mysql_error());
			$row_auteur = mysql_fetch_assoc($auteur);
			$totalRows_auteur = mysql_num_rows($auteur);
			$result = "";
			$i = 0;
			if ($totalRows_auteur != 0)
			{ 
				do
				{
					if ($i !=0 ) {
						$result .= "/";
					}
					$result .= $row_auteur['ETAT_CIVIL'];
					$i++;
				} while ($row_auteur = mysql_fetch_assoc($auteur));
			}
			?>
            <input type="text" name="GALERIE" id="GALERIE" value="<?php echo $result; ?>" size="32"></td>
    </tr>
    <tr>
        <td>Date d&#8217;entr&eacute;e&nbsp; <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1615)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
        <td class="lighter"><span class="lighter" style="text-align:justify">&nbsp;</span>
            <table width="200" border="0" cellpadding="0" cellspacing="0" class="date">
                <tr>
                    <td align="center"><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=AFFIXEDATE&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=GALERIE_TXT_DATE_PATRIMONIALE');">Affixe</a></td>
                    <td align="center">date d&eacute;but</td>
                    <td align="center">date fin</td>
                </tr>
                <tr>
                    <td align="center"><?php (isset($_POST['GALERIE_TXT_DATE_PATRIMONIALE'])) ? $valeur = $_POST['GALERIE_TXT_DATE_PATRIMONIALE'] : $valeur = $row_rech_objet['GALERIE_TXT_DATE_PATRIMONIALE']; ?>
                        <input name="GALERIE_TXT_DATE_PATRIMONIALE" type="text" value="<?php echo stripslashes($valeur); ?>" size="10"></td>
                    <td align="center"><?php (isset($_POST['GALERIE_DEB_DATE_PATRIMONIALE'])) ? $valeur = $_POST['GALERIE_DEB_DATE_PATRIMONIALE'] : $valeur = $row_rech_objet['GALERIE_DEB_DATE_PATRIMONIALE']; ?>
                        <input name="GALERIE_DEB_DATE_PATRIMONIALE" type="text" value="<?php echo reverseDate(stripslashes($valeur)); ?>" size="10"></td>
                    <td align="center"><?php (isset($_POST['GALERIE_FIN_DATE_PATRIMONIALE'])) ? $valeur = $_POST['GALERIE_FIN_DATE_PATRIMONIALE'] : $valeur = $row_rech_objet['GALERIE_FIN_DATE_PATRIMONIALE']; ?>
                        <input name="GALERIE_FIN_DATE_PATRIMONIALE" type="text" value="<?php echo reverseDate(stripslashes($valeur)); ?>" size="10"></td>
                </tr>
            </table></td>
        <td>&nbsp;</td>
        <td class="lighter">&nbsp;</td>
    </tr>
    <tr>
        <td><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=TLIEU&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=LOCALISATION');"><span class="obligatoire">Localisation</span></a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1601)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
        <td class="lighter"><input type="text" name="LOCALISATION" value="<?php echo $row_rech_objet['LOCALISATION']; ?>" size="32"></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
</table>
<h2>Actions men&eacute;es lors du r&eacute;colement</h2>
<table id="action">
    <tr>
        <td width="15%" height="24"><p>Photographi&eacute;&nbsp;le : <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4319)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></p>
        </td>
<td width="25%" class="lighter lignes"><span class="lighter">&nbsp;</span>
<table width="200" border="0" cellpadding="0" cellspacing="0" class="date">
                <tr>
                    <td align="center"><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=AFFIXEDATE&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=TXT_DATE_PRISE_VUE');">Affixe</a></td>
                    <td align="center">date d&eacute;but</td>
                    <td align="center">date fin</td>
                </tr>
                <tr>
                    <td align="center"><input name="TXT_DATE_PRISE_VUE" type="text" id="TXT_DATE_PRISE_VUE" value="<?php if(isset($_POST['TXT_DATE_PRISE_VUE'])){echo $_POST['TXT_DATE_PRISE_VUE']; } ?>" size="10"></td>
                    <td align="center"><input type="text" name="DEB_DATE_PRISE_VUE" value="<?php if(isset($_POST['DEB_DATE_PRISE_VUE'])){ echo $_POST['DEB_DATE_PRISE_VUE']; } ?>" size="10"></td>
                    <td align="center"><input type="text" name="FIN_DATE_PRISE_VUE" value="<?php if(isset($_POST['FIN_DATE_PRISE_VUE'])){ echo $_POST['FIN_DATE_PRISE_VUE'] ;}?>" size="10"></td>
                </tr>
            </table></td>
      <td width="12%"><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=AUT&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=PHOTOGRAPHE');">Photographe </a><a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4318)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
      <td width="17%" class="lighter lignes"><input name="PHOTOGRAPHE" class="inputlong40" type="text" value="<?php if(isset($_POST['PHOTOGRAPHE'])){echo $_POST['PHOTOGRAPHE'];} ?>"></td>
      <td width="15%">Identifiant (cr&eacute;er un identifiant Photo) <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4101)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a> </td>
      <td width="13%" class="lighter lignes"><input name="PHOTOGRAPHIE" class="inputlong40" value=""></td>
  </tr>
    <tr>
        <td>Fichier photo </td>
        <td colspan="5">Fichier image :
            <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $_SESSION['max_transfert'] ?>">
            <input name="nouv_image" type="file">
            <br>
            attention format GIF, JPEG,PNG seulement et taille max. : <?php echo $_SESSION['max_transfert'] ?> octets </td>
    </tr>
    <tr>
        <td>Marquage&nbsp;</td>
        <td colspan="5"><?php 
							$valeur = "";
							if (isset($_POST['COMMENTAIRES'])) {
								foreach($_POST['COMMENTAIRES'] as $value) {
									$valeur .= $value."/";
								}
							}
								$tableau_donnees = explode("/",$valeur);
								$champs_affiche = array("marqué","etiquette fil","sur contenant");
								for($i = 0; $i < count($champs_affiche); $i++) { ?>
            <div class="caseAcocher">
                <label>
                <input name="MARQUAGE_EFFECTUE" type="radio" value="<?php echo $champs_affiche[$i]; ?>"<?php
									$position = array_search($champs_affiche[$i],$tableau_donnees);
									if ($position === false) {
										;
									} else {?><?php } ?>>
                <?php echo $champs_affiche[$i]; ?></label>
            </div>
            <?php } ?></td>
    </tr>
    <tr>
        <td>Autres actions&nbsp; </td>
        <td colspan="5"><?php 
							$valeur = "";
							if (isset($_POST['COMMENTAIRES'])) {
								foreach($_POST['COMMENTAIRES'] as $value) {
									$valeur .= $value."/";
								}
							}
							$tableau_donnees = explode("/",$valeur);
							$champs_affiche = array("dépoussièré","consolidation","conditionné","nettoyage léger","renouvellement du conditionnement");
								for($i = 0; $i < count($champs_affiche); $i++) { ?>
            <div class="caseAcocher">
                <label>
                <input name="ACTIONS[]" type="checkbox" value="<?php echo $champs_affiche[$i]; ?>"<?php
									$position = array_search($champs_affiche[$i],$tableau_donnees);
									if ($position === false) {
										;
									} else {?><?php } ?>>
                <?php echo $champs_affiche[$i]; ?></label>
            </div>
            <?php } ?></td>
    </tr>
</table>
<table>
    <tr>
        <td class="unDemi"><h2>Nom de l&#8217;agent de r&eacute;colement, Date et signature</h2></td>
    </tr>
    <tr>
        <td class="lighter lignes">Agent de r&eacute;colement :
            <input name="EXPERT" type="text" id="EXPERT" value="<?php if(isset($_POST['EXPERT'])){echo $_POST['EXPERT'];} ?>" size="32">
            &nbsp;<span class="lighter">
            <label for="DATE_RECOLEMENT">Date de r&eacute;colement</label>
            &nbsp;
            <input type="text" id="DATE_RECOLEMENT" onBlur="champDat(this);" name="DATE_RECOLEMENT" value="<?php if(isset($_POST['DATE_RECOLEMENT'])){echo $_POST['DATE_RECOLEMENT'];} ?>" size="10">
            </span>
            <input type="hidden" name="MM_update" value="objets"></td>
    </tr>
    
    
    <tr>
        <td align="right"><p >
                <input name="image" type="image" onClick="MM_validateForm('EXPERT','','R','DATE_RECOLEMENT','','R');return document.MM_returnValue" src="../images/valider.gif">
            </p></td>
    </tr>
</table>
</form>
<?php } while ($row_rech_objet = mysql_fetch_assoc($rech_objet)); ?>
<br class="pageEnd">
<p style="text-align:center">&copy; Fiche obtenue par AlienorWebLibre</p>
</body>
</html>
<?php
mysql_free_result($rech_objet);
mysql_free_result($auteur);
mysql_free_result($lieu);
mysql_free_result($gestion);
?>
