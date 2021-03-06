<?php
	include('../Connections/alienorweb.php');
	include('../include/fonctions.php');
?>
<?php
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


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

// traiter les valeurs envoyer en tableau
if (is_array($_POST['ETAT'])) {
	foreach($_POST['ETAT'] as $value) {
		$etat .= $value."/";
	}
	$etat = substr(trim($etat),0,strlen($etat)-1);
}
if (is_array($_POST['COMMENTAIRES'])) {
	foreach($_POST['COMMENTAIRES'] as $value) {
		$commentaires .= $value."/";
	}
	$commentaires = substr(trim($commentaires),0,strlen($commentaires)-1);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "ins_inventaire")) {
// Modification des champs dans la table objet
  $updateSQL = sprintf("UPDATE objet SET DENOMINATION=%s, TITRE=%s, PRECISION_GENESE=%s, PRECISION_DECOUVERTE=%s, MODE_ACQUISITION=%s, UTILISATION=%s, NUMERO_INVENTAIRE=%s, MATIERE=%s, DIMENSIONS_FORMES=%s, TYPE_INSCRIPTION=%s, TRANSCRIPTION_INSCRIPTION=%s, TECHNIQUE=%s, LOCALISATION=%s WHERE INDEX_OBJET=%s",
                       GetSQLValueString($_POST['DENOMINATION'], "text"),
                       GetSQLValueString($_POST['TITRE'], "text"),
                       GetSQLValueString($_POST['PRECISION_GENESE'], "text"),
                       GetSQLValueString($_POST['PRECISION_DECOUVERTE'], "text"),
                       GetSQLValueString($_POST['MODE_ACQUISITION'], "text"),
                       GetSQLValueString($_POST['UTILISATION'], "text"),
                       GetSQLValueString($_POST['NUMERO_INVENTAIRE'], "text"),
                       GetSQLValueString($_POST['MATIERE'], "text"),
                       GetSQLValueString($_POST['DIMENSIONS_FORMES'], "text"),
                       GetSQLValueString($_POST['TYPE_INSCRIPTION'], "text"),
                       GetSQLValueString($_POST['TRANSCRIPTION_INSCRIPTION'], "text"),
                       GetSQLValueString($_POST['TECHNIQUE'], "text"),
                       GetSQLValueString($_POST['LOCALISATION'], "text"),
                       GetSQLValueString($_POST['INDEX_OBJET'], "int"));

  mysql_select_db($database_alienorweb, $alienorweb);
  $Result1 = mysql_query($updateSQL, $alienorweb) or die(mysql_error());

// Cr�ation de la gestion ETAT
	if ($etat != "") {
		// D�but cr�ation de fiche de gestion
		$insertSQL = sprintf("INSERT INTO gestion (ETAT_CONSERVATION,DATE_CONSERVATION,FICHE_CREEE_LE,CODEMUSEE) VALUES (%s,%s,%s,%s)",
								GetSQLValueString($etat, "text"),
								GetSQLValueString($_POST['FICHE_CREEE_LE'], "date"),
								GetSQLValueString($_POST['FICHE_CREEE_LE'], "date"),
								GetSQLValueString($_POST['CODEMUSEE'], "text"));
		mysql_select_db($database_alienorweb, $alienorweb);
		echo ("\$insertSQL = ".$insertSQL."<br>\n");
		$Result = mysql_query($insertSQL, $alienorweb) or die(mysql_error());
		// fin cr�ation fiches
		
		// R�cuperation du num�ro de la fiche cr��e
		mysql_select_db($database_alienorweb, $alienorweb);
		$query_gestion = "SELECT DISTINCT INDEX_GESTION FROM gestion WHERE ETAT_CONSERVATION = '".$etat."' AND DATE_CONSERVATION = '".$_POST['FICHE_CREEE_LE']."'";
		echo ("\$query_gestion = ".$query_gestion."<br>\n");
		$gestion = mysql_query($query_gestion, $alienorweb) or die(mysql_error());
		$row_gestion = mysql_fetch_assoc($gestion);
		$totalRows_gestion = mysql_num_rows($gestion);
		echo ("\$totalRows_gestion = ".$totalRows_gestion."<br>\n");
		
		$noGestion = intval($row_gestion['INDEX_GESTION']);
		
		// Liaison de la table objte avec la table gestion
		$insertSQL = sprintf("INSERT INTO obj_ges (INDEX_OBJET,INDEX_GESTION) VALUES (".intval($_POST['INDEX_OBJET']).",".$noGestion.")");
		echo ("\$insertSQL = ".$insertSQL."<br>\n");
		$Result = mysql_query($insertSQL, $alienorweb) or die(mysql_error());
	}

	if ($commentaires != "") {
		// D�but cr�ation de fiche de gestion COMEMTAIRES
		$insertSQL = sprintf("INSERT INTO gestion (COMMENTAIRES,FICHE_CREEE_LE,CODEMUSEE) VALUES (%s,%s,%s)",
								GetSQLValueString($commentaires, "text"),
								GetSQLValueString($_POST['FICHE_CREEE_LE'], "date"),
								GetSQLValueString($_POST['CODEMUSEE'], "text"));
		mysql_select_db($database_alienorweb, $alienorweb);
		echo ("\$insertSQL = ".$insertSQL."<br>\n");
		$Result = mysql_query($insertSQL, $alienorweb) or die(mysql_error());
		// fin cr�ation fiches
		
		// R�cuperation du num�ro de la fiche cr��e
		mysql_select_db($database_alienorweb, $alienorweb);
		$query_gestion = "SELECT DISTINCT INDEX_GESTION FROM gestion WHERE COMMENTAIRES = '".$commentaires."' AND FICHE_CREEE_LE = '".$_POST['FICHE_CREEE_LE']."'";
		echo ("\$query_gestion = ".$query_gestion."<br>\n");
		$gestion = mysql_query($query_gestion, $alienorweb) or die(mysql_error());
		$row_gestion = mysql_fetch_assoc($gestion);
		$totalRows_gestion = mysql_num_rows($gestion);
		echo ("\$totalRows_gestion = ".$totalRows_gestion."<br>\n");
		
		$noGestion = intval($row_gestion['INDEX_GESTION']);
		
		// Liaison de la table objte avec la table gestion
		$insertSQL = sprintf("INSERT INTO obj_ges (INDEX_OBJET,INDEX_GESTION) VALUES (".intval($_POST['INDEX_OBJET']).",".$noGestion.")");
		echo ("\$insertSQL = ".$insertSQL."<br>\n");
		$Result = mysql_query($insertSQL, $alienorweb) or die(mysql_error());
	}
//  $updateGoTo = "/alienorweblibre/etats/ms_inventaire-recolement.php";
//  if (isset($_SERVER['QUERY_STRING'])) {
//    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
//    $updateGoTo .= $_SERVER['QUERY_STRING'];
//  }
//	  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_alienorweb, $alienorweb);
$query_objet = "SELECT * FROM objet";
$objet = mysql_query($query_objet, $alienorweb) or die(mysql_error());
$row_objet = mysql_fetch_assoc($objet);
$totalRows_objet = mysql_num_rows($objet);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="fr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Language" content="fr">
<title>BORDEREAU D&#8217;INVENTAIRE - R&Eacute;COLEMENT</title>
<meta name="description" content="BORDEREAU D'INVENTAIRE - RECOLEMENT">
<link href="/alienorweblibre/style/tout.css" rel="stylesheet" type="text/css" media="all">
<link href="/alienorweblibre/style/imprime.css" rel="stylesheet" type="text/css" media="print">
</head>
<body>
<?php do { ?>
    <form action="<?php echo $editFormAction; ?>" method="POST" name="ins_inventaire" id="ins_inventaire" title="Remplissage formulaire de recollement">
        <input name="INDEX_OBJET" type="hidden" value="<?php echo $row_objet['INDEX_OBJET']; ?>">
        <input name="CODEMUSEE" type="hidden" value="<?php echo $row_objet['CODEMUSEE']; ?>">
        <input name="FICHE_CREEE_LE" type="hidden" value="<?php echo date("Y-m-d")?>">
        <input name="FICHE_CREEE_PAR" type="hidden" value="<?php echo $_SESSION["nom"]." ".$_SESSION["prenom"]; ?>">
        <table id="identification" >
            <tr>
                <td width="9%"><img src="/alienorweblibre/images/Logo_CIRM.jpg" alt="Logo du Conseil inter-r&eacute;gionnal des mus&eacute;es" name="logo" width="195" height="113" id="logo"></td>
                <td width="74%" class="centrage"><h1>Bordereau d&#8217;inventaire - R&eacute;colement</h1></td>
                <td width="17%" rowspan="5"><div>
                        <!-- D&eacute;but de l'emplamcement de l'affichage image(s) -->
                        <!-- Fin de l'emplamcement de l'affichage image(s) -->
                    </div></td>
            </tr>
            <tr>
                <td>N&deg; d&#8217;inv.&nbsp;: </td>
                <td class="emphase"><b><?php echo $row_objet['NUMERO_INVENTAIRE']; ?>&nbsp;</b>
                    <input name="NUMERO_INVENTAIRE" type="text" value="<?php echo $row_objet['NUMERO_INVENTAIRE']; ?>" size="32">
                </td>
            </tr>
            <tr>
                <td colspan="2"><?php 
								$champs_recupere = $row_gestion['COMMENTAIRES'];
								$tableau_donnees = explode("/",$champs_recupere);
								$champs_affiche = array("marqu�","etiquette fil","sur contenant");
								for($i = 0; $i < count($champs_affiche); $i++) { ?>
                    <div class="caseAcocher">
                        <label>
                        <input name="COMMENTAIRES[]" type="checkbox" value="<?php echo $champs_affiche[$i]; ?>"<?php
									$position = array_search($champs_affiche[$i],$tableau_donnees);
									if ($position === false) {
										;
									} else {?> checked="checked"<?php } ?>>
                        <?php echo $champs_affiche[$i]; ?></label>
                    </div>
                    <?php } ?></td>
            </tr>
            <tr>
                <td>D&eacute;nomination&nbsp;:</td>
                <td class="emphase"><?php echo $row_objet['DENOMINATION']; ?>&nbsp;
                    <input name="DENOMINATION" type="text" value="<?php echo $row_objet['DENOMINATION']; ?>" size="32"></td>
            </tr>
            <tr>
                <td>Titre&nbsp;:</td>
                <td class="emphase"><?php echo $row_objet['TITRE']; ?>&nbsp;
                    <input name="TITRE" type="text" value="<?php echo $row_objet['TITRE']; ?>" size="32"></td>
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
                            <td width="21%">Mati&egrave;re&nbsp;:</td>
                            <td width="79%" class="lighter"><input name="MATIERE" type="text" value="<?php echo $row_objet['MATIERE']; ?>" size="32"></td>
                        </tr>
                        <tr>
                            <td>Technique&nbsp;:</td>
                            <td class="lighter"><input name="TECHNIQUE" type="text" value="<?php echo $row_objet['TECHNIQUE']; ?>" size="32"></td>
                        </tr>
                        <tr>
                            <td>Description&nbsp;:</td>
                            <td class="lighter" style="text-align:justify"><span class="lignes">
                                <input name="TYPE_INSCRIPTION" type="text" value="<?php echo $row_objet['TYPE_INSCRIPTION']; ?>" size="32">
                                </span></td>
                        </tr>
                        <tr>
                            <td>Dimensions&nbsp;:</td>
                            <td class="lighter"><span class="lignes"> <?php echo $row_objet['DIMENSIONS_FORMES']; ?> </span></td>
                        </tr>
                        <tr>
                            <td>Inscriptions&nbsp;:</td>
                            <td class="lighter"><span class="lighter" style="text-align:justify"><?php echo $row_objet['TRANSCRIPTION_INSCRIPTION']; ?></span></td>
                        </tr>
                        <tr>
                            <td colspan="2">&Eacute;tat&nbsp;:</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="justifie"><span class="lighter">
                                <?php 
						$tableDate = "";
						$query_gestion = "SELECT gestion.ETAT_CONSERVATION, gestion.DATE_CONSERVATION, gestion.EXPERT FROM gestion, obj_ges WHERE obj_ges.INDEX_GESTION = gestion.INDEX_GESTION AND obj_ges.INDEX_OBJET = ".(int)$row_objet['INDEX_OBJET']."";
						$gestion = mysql_query($query_gestion, $alienorweb) or die(mysql_error());
						$row_gestion = mysql_fetch_assoc($gestion);
						$totalRows_gestion = mysql_num_rows($gestion);
						if ($totalRows_gestion != 0)
						{
							do
							{ 
								$tableEtat[] = $row_gestion['ETAT_CONSERVATION'];
								$tableDate[] = $row_gestion['DATE_CONSERVATION'];
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
                    </table></td>
                <td width="60%" class="soixant"><h2>Description - &Eacute;tat (constat&eacute; au r&eacute;colement)</h2>
                    <table>
                        <tr>
                            <td width="14%" height="20">Dimensions&nbsp;:</td>
                            <td width="86%" class="lignes"><input type="text" name="DIMENSIONS_FORMES" value="<?php echo $row_objet['DIMENSIONS_FORMES']; ?>" size="32"></td>
                        </tr>
                        <tr>
                            <td>Inscriptions&nbsp;:</td>
                            <td class="lignes"><input type="text" name="TRANSCRIPTION_INSCRIPTION" value="<?php echo $row_objet['TRANSCRIPTION_INSCRIPTION']; ?>" size="32"></td>
                        </tr>
                        <tr>
                            <td>&Eacute;tat&nbsp;:</td>
                            <td class="lignes">&nbsp;</td>
                        </tr>
                        <tr>
                            <td height="72" colspan="2" id="etat"><?php 
								$champs_recupere = $row_gestion['ETAT'];
								$tableau_donnees = explode("/",$champs_recupere);
								$champs_affiche = array("sciure","trous","taches","d�pigment�","manques","humidit�","d�sassembler","insectes","cass�, f�l�","moisi, sels","corrod�","poussi�re","d�chir�");
								for($i = 0; $i < count($champs_affiche); $i++) { ?>
                                <div class="caseAcocher">
                                    <label>
                                    <input name="ETAT[]" type="checkbox" value="<?php echo $champs_affiche[$i]; ?>"<?php
									$position = array_search($champs_affiche[$i],$tableau_donnees);
									if ($position === false) {
										;
									} else {?> checked="checked"<?php } ?>>
                                    <?php echo $champs_affiche[$i]; ?></label>
                                </div>
                                <?php } ?></td>
                        </tr>
                        <tr>
                            <td>Conditionnement&nbsp;:</td>
                            <td><?php
							$champs_affiche = array("immeuble","meuble");
								for($i = 0; $i < count($champs_affiche); $i++) { ?>
                                <div class="caseAcocher">
                                    <label>
                                    <input name="COMMENTAIRES[]" type="checkbox" value="<?php echo $champs_affiche[$i]; ?>"<?php
									$position = array_search($champs_affiche[$i],$tableau_donnees);
									if ($position === false) {
										;
									} else {?> checked="checked"<?php } ?>>
                                    <?php echo $champs_affiche[$i]; ?></label>
                                </div>
                                <?php } ?></td>
                        </tr>
                        <tr>
                            <td > Contenant&nbsp;:</td>
                            <td id="contenant"><?php
							$champs_affiche = array("bois","plastique","papier","m�tal","carton","verre","tissu","sans");
								for($i = 0; $i < count($champs_affiche); $i++) { ?>
                                <div class="caseAcocher">
                                    <label>
                                    <input name="COMMENTAIRES[]" type="checkbox" value="<?php echo $champs_affiche[$i]; ?>"<?php
									$position = array_search($champs_affiche[$i],$tableau_donnees);
									if ($position === false) {
										;
									} else {?> checked="checked"<?php } ?>>
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
                            <td width="31%">Collecteur,&nbsp;inventeur&nbsp;:</td>
                            <td width="69%" class="lighter"><?php
						$query_auteur = "SELECT personne.INDEX_PERSONNE, ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET = ".(int)$row_objet['INDEX_OBJET']." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'COLLECTEUR' ORDER BY INDEX_OBJ_PER ASC";
						//echo("\$query_auteur : ".$query_auteur);
						$auteur = mysql_query($query_auteur, $alienorweb) or die(mysql_error());
						$row_auteur = mysql_fetch_assoc($auteur);
						$totalRows_auteur = mysql_num_rows($auteur);
						$i = 0;
						if ($totalRows_auteur != 0)
						{ 
							do {
								if ($i != 0) {
									echo ("<br>\n");
								}
								echo ($row_auteur['ETAT_CIVIL']." (collecteur)");
								$i++;
							} while ($row_auteur = mysql_fetch_assoc($auteur));
						echo("<br>");
						}
						// inventeur
						$query_auteur = "SELECT personne.INDEX_PERSONNE, ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET = ".(int)$row_objet['INDEX_OBJET']." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'INVENTEUR' ORDER BY INDEX_OBJ_PER ASC";
						//echo("\$query_auteur : ".$query_auteur);
						$auteur = mysql_query($query_auteur, $alienorweb) or die(mysql_error());
						$row_auteur = mysql_fetch_assoc($auteur);
						$totalRows_auteur = mysql_num_rows($auteur);
						$i = 0;
						if ($totalRows_auteur != 0)
						{ 
							do {
								if ($i != 0) {
									echo ("<br>\n");
								}
								echo ($row_auteur['ETAT_CIVIL']." (inventeur)");
								$i++;
							} while ($row_auteur = mysql_fetch_assoc($auteur));
						}
						?></td>
                        </tr>
                        <tr>
                            <td>Lieu de collecte&nbsp;:</td>
                            <td class="lighter"><?php
$query_lieu = "SELECT lieu.INDEX_LIEU, SITE FROM lieu,obj_lie WHERE obj_lie.INDEX_OBJET =".(int)$row_objet['INDEX_OBJET']." AND lieu.INDEX_LIEU = obj_lie.INDEX_LIEU AND obj_lie.QUALIFIANT = 'LIEUX_DECOUVERTE' ORDER BY INDEX_OBJ_LIE ASC";
						$lieu = mysql_query($query_lieu, $alienorweb) or die(mysql_error());
						$row_lieu = mysql_fetch_assoc($lieu);
						$totalRows_lieu = mysql_num_rows($lieu);
						$i = 0 ;
						if ($totalRows_lieu != 0) {
							do {
								if ($i != 0) {
									echo ("<br>");
								}
								echo $row_lieu['SITE'];
								$i++;
							} while ($row_lieu = mysql_fetch_assoc($lieu));
						}
						?></td>
                        </tr>
                        <tr>
                            <td>Date de collecte&nbsp;:</td>
                            <td class="lighter"><input type="text" name="TXT_DATE_DECOUVERTE" value="<?php echo $row_objet['TXT_DATE_DECOUVERTE']; ?>" size="10">
                                &nbsp;
                                <input type="text" name="DEB_DATE_DECOUVERTE" value="<?php echo reverseDate($row_objet['DEB_DATE_DECOUVERTE']); ?>" size="10">
                                &nbsp;
                                <input type="text" name="FIN_DATE_DECOUVERTE" value="<?php echo reverseDate($row_objet['FIN_DATE_DECOUVERTE']); ?>" size="10">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">Pr&eacute;cision&nbsp;sur&nbsp;la&nbsp;collecte&nbsp;:</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="justifie"><span class="lignes">
                                <textarea name="PRECISION_DECOUVERTE" cols="50" rows="4"><?php echo $row_objet['PRECISION_DECOUVERTE']; ?></textarea>
                                </span></td>
                        </tr>
                    </table></td>
                <td class="unDemi"><h2>Donn&eacute;es sur l&#8217;ex&eacute;cution </h2>
                    <table>
                        <tr>
                            <td width="30%">Auteur,&nbsp;attribution&nbsp;:</td>
                            <td width="70%" class="lighter"><?php
						$query_auteur = "SELECT personne.INDEX_PERSONNE, ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET = ".(int)$row_objet['INDEX_OBJET']." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'AUTEUR' ORDER BY INDEX_OBJ_PER ASC";
						$auteur = mysql_query($query_auteur, $alienorweb) or die(mysql_error());
						$row_auteur = mysql_fetch_assoc($auteur);
						$totalRows_auteur = mysql_num_rows($auteur);
						$i = 0;
						if ($totalRows_auteur != 0)
						{ 
							do {
								if ($i != 0) {
									echo ("<br>\n");
								}
								echo ($row_auteur['ETAT_CIVIL']);
								$i++;
							} while ($row_auteur = mysql_fetch_assoc($auteur));
						echo("<br>");
						}
						// *********************************************
						// Traitement des attibtions et des attributeurs
						// *********************************************
						$tableDate = "";
						if ($row_objet['DEB_DATE_ATTRIBUTION'] != "") {
							$dateRef = "";
							$tableDate[] = explode("/",$row_objet['DEB_DATE_ATTRIBUTION']);
							$dateRef = $tableDate[0];
							$select = 0;
							for($i = 0; $i < count($tableDate); $i++)
							{
								if ($tableDate[$i] > $dateRef)
								{
									$select++;
								}
							}
						}
						// Attribution
						$query_auteur = "SELECT personne.INDEX_PERSONNE, ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET = ".(int)$row_objet['INDEX_OBJET']." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'ATTRIBUTION' ORDER BY INDEX_OBJ_PER ASC";
						$auteur = mysql_query($query_auteur, $alienorweb) or die(mysql_error());
						$row_auteur = mysql_fetch_assoc($auteur);
						$totalRows_auteur = mysql_num_rows($auteur);
						if ($totalRows_auteur != 0)
						{ 
							do 
							{
								$tableAttribution[] = $row_auteur['ETAT_CIVIL'];
							} while ($row_auteur = mysql_fetch_assoc($auteur));
						}
						
						// Attributeur
						$query_auteur1 = "SELECT personne.INDEX_PERSONNE, ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET = ".(int)$row_objet['INDEX_OBJET']." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'ATTRIBUTEUR' ORDER BY INDEX_OBJ_PER ASC";
						$auteur1 = mysql_query($query_auteur1, $alienorweb) or die(mysql_error());
						$row_auteur1 = mysql_fetch_assoc($auteur1);
						$totalRows_auteur1 = mysql_num_rows($auteur1);
						if ($totalRows_auteur1 != 0)
						{ 
							do 
							{
								$tableAttributeur[] = $row_auteur1['ETAT_CIVIL'];
							} while ($row_auteur1 = mysql_fetch_assoc($auteur1));
						}
						if (is_array($tableDate)) 
						{
							if (is_array($tableAttribution) && $select <= count($tableAttribution)) {
								echo("attribu&eacute; &agrave; ".$tableAttribution[$select]);
							}
							if (is_array($tableAttributeur) && $select <= count($tableAttributeur)) {
								echo(" par ".$tableAttributeur[$select]."<br>\n");
							}
						} else {
							for($i = 0; $i < count($tableAttribution); $i++)
							{
								echo("attribu&eacute; &agrave; ".$tableAttribution[$i]);
								if (is_array($tableAttributeur) && $i <= count($tableAttributeur))
								{
									echo(" par ".$tableAttributeur[$i]);
								}
								echo("<br>\n");
							}
						}
						?></td>
                        </tr>
                        <tr>
                            <td width="30%">Lieu&nbsp;d&#8217;ex&eacute;cution&nbsp;:</td>
                            <td width="70%" class="lighter"><?php
						$query_lieu = "SELECT lieu.INDEX_LIEU, SITE FROM lieu,obj_lie WHERE obj_lie.INDEX_OBJET =".(int)$row_objet['INDEX_OBJET']." AND lieu.INDEX_LIEU = obj_lie.INDEX_LIEU AND obj_lie.QUALIFIANT = 'LIEUX_EXECUTION' ORDER BY INDEX_OBJ_LIE ASC";
						$lieu = mysql_query($query_lieu, $alienorweb) or die(mysql_error());
						$row_lieu = mysql_fetch_assoc($lieu);
						$totalRows_lieu = mysql_num_rows($lieu);
						$i = 0 ;
						if ($totalRows_lieu != 0)
						{
							do 
							{
								if ($i != 0)
								{
									echo ("<br>");
								}
								echo $row_lieu['SITE'];
								$i++;
							} while ($row_lieu = mysql_fetch_assoc($lieu));
						}
						?></td>
                        </tr>
                        <tr>
                            <td width="30%">Date&nbsp;d&#8217;ex&eacute;cution&nbsp;:</td>
                            <td width="70%" class="lighter"><input type="text" name="TXT_DATE_EXECUTION" value="<?php echo $row_objet['TXT_DATE_EXECUTION']; ?>" size="10">
                                &nbsp;
                                <input type="text" name="DEB_DATE_EXECUTION" value="<?php echo reverseDate($row_objet['DEB_DATE_EXECUTION']); ?>" size="10">
                                &nbsp;
                                <input type="text" name="FIN_DATE_EXECUTION" value="<?php echo reverseDate($row_objet['FIN_DATE_EXECUTION']); ?>" size="10"></td>
                        </tr>
                        <tr>
                            <td colspan="2">Pr&eacute;cision&nbsp;sur&nbsp;la&nbsp;gen&egrave;se&nbsp;:</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="justifie"><span class="lighter">
                                <textarea name="PRECISION_GENESE" cols="50" rows="4"><?php echo $row_objet['PRECISION_GENESE']; ?></textarea>
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
                            <td width="15%">Utilisation&nbsp;: </td>
                            <td width="85%" class="lighter"><input type="text" name="UTILISATION" value="<?php echo $row_objet['UTILISATION']; ?>" size="32">
                            </td>
                        </tr>
                    </table></td>
                <td class="unDemi"><h2>Gestion</h2>
                    <table>
                        <tr>
                            <td width="20%">Valeur&nbsp;d&#8217;achat&nbsp;:</td>
                            <td  width="80%" class="lighter"><?php 
						$query_gestion = "SELECT gestion.VALEUR, gestion.DATE_VALEUR FROM gestion, obj_ges WHERE obj_ges.INDEX_GESTION = gestion.INDEX_GESTION AND obj_ges.INDEX_OBJET = ".(int)$row_objet['INDEX_OBJET']."";
						$gestion = mysql_query($query_gestion, $alienorweb) or die(mysql_error());
						$row_gestion = mysql_fetch_assoc($gestion);
						$totalRows_gestion = mysql_num_rows($gestion);
						if ($totalRows_gestion != 0)
						$tableDate = "";
						$tableValeur = "";
						$dateRef = "";
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
							echo($tableValeur[$select]);
						}
						?>
                            </td>
                        </tr>
                    </table></td>
            </tr>
        </table>
        <h2>Administration</h2>
        <table>
            <tr>
                <td width="13%">Propri&eacute;taire&nbsp;:</td>
                <td width="37%" class="lighter"><?php
			$query_auteur = "SELECT personne.INDEX_PERSONNE, ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET = ".(int)$row_objet['INDEX_OBJET']." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'PROPRIETAIRE' ORDER BY INDEX_OBJ_PER ASC";
			//echo("\$query_auteur : ".$query_auteur);
			$auteur = mysql_query($query_auteur, $alienorweb) or die(mysql_error());
			$row_auteur = mysql_fetch_assoc($auteur);
			$totalRows_auteur = mysql_num_rows($auteur);
			$i = 0;
			if ($totalRows_auteur != 0)
			{ 
				do
				{
					if ($i != 0)
					{
						echo ("<br>\n");
					}
					echo ($row_auteur['ETAT_CIVIL']);
					$i++;
				} while ($row_auteur = mysql_fetch_assoc($auteur));
			echo("<br>");
			}
			?></td>
                <td width="14%">Mode d&#8217;acquisition&nbsp;:</td>
                <td width="36%" class="lighter"><input type="text" name="MODE_ACQUISITION" value="<?php echo $row_objet['MODE_ACQUISITION']; ?>" size="32"></td>
            </tr>
            <tr>
                <td>Date&nbsp;de&nbsp;l&#8217;acquisition&nbsp;:</td>
                <td class="lighter"><?php echo traitementDate($row_objet['PROPRIETAIRE_TXT_DATE_PATRIMONIALE'],reverseDate($row_objet['PROPRIETAIRE_DEB_DATE_PATRIMONIALE']),reverseDate($row_objet['PROPRIETAIRE_FIN_DATE_PATRIMONIALE'])); ?></td>
                <td>Date&nbsp;de&nbsp;la&nbsp;commission&nbsp;:</td>
                <td class="lighter" style="text-align:justify"><?php echo traitementDate($row_objet['COMMISSAIRE_PRISEUR_TXT_DATE_PATRIMONIALE'],reverseDate($row_objet['COMMISSAIRE_PRISEUR_DEB_DATE_PATRIMONIALE']),reverseDate($row_objet['COMMISSAIRE_PRISEUR_FIN_DATE_PATRIMONIALE'])); ?></td>
            </tr>
            <tr>
                <td>Agent d&#8217;acquisition&nbsp;:</td>
                <td class="lighter"><?php
			// Ancienne appartenance ***************************************************************
			$tableDate = "";
			if ($row_objet['ANCIENNE_APPARTENANCE_DEB_DATE_PATRIMONIALE'] != "") {
				$dateRef = "";
				$tableDate[] = explode("/",$row_objet['ANCIENNE_APPARTENANCE_DEB_DATE_PATRIMONIALE']);
				$dateRef = $tableDate[0];
				$select = 0;
				for($i = 0; $i < count($tableDate); $i++)
				{
					if ($tableDate[$i] > $dateRef)
					{
						$select++;
					}
				}
			}
			
			$query_auteur = "SELECT personne.INDEX_PERSONNE, personne.ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET = ".(int)$row_objet['INDEX_OBJET']." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'ANCIENNE_APPARTENANCE' ORDER BY INDEX_OBJ_PER ASC";
			$auteur = mysql_query($query_auteur, $alienorweb) or die(mysql_error());
			$row_auteur = mysql_fetch_assoc($auteur);
			$totalRows_auteur = mysql_num_rows($auteur);
			$i = 0;
			if ($totalRows_auteur != 0)
			{ 
				$tableAuteur = "";
				do
				{
					$tableAuteur[] = $row_auteur['ETAT_CIVIL'];
				} while ($row_auteur = mysql_fetch_assoc($auteur));
			}
			if (is_array($tableDate)) 
			{
				if (is_array($tableAuteur) && $select <= count($tableAuteur)) {
					echo($tableAuteur[$select]);
					echo("<br>\n");
				}
			} else {
				for($i = 0; $i < count($tableAuteur); $i++)
				{
					echo($tableAuteur[$i]);
					echo("<br>\n");
				}
			}
			// Commissaire priseur ***************************************************************
			$tableDate = "";
			if ($row_objet['COMMISSAIRE_PRISEUR_DEB_DATE_PATRIMONIALE'] != "") {
				$dateRef = "";
				$tableDate[] = explode("/",$row_objet['COMMISSAIRE_PRISEUR_DEB_DATE_PATRIMONIALE']);
				$dateRef = $tableDate[0];
				$select = 0;
				for($i = 0; $i < count($tableDate); $i++)
				{
					if ($tableDate[$i] > $dateRef)
					{
						$select++;
					}
				}
			}
			
			$query_auteur = "SELECT personne.INDEX_PERSONNE, personne.ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET = ".(int)$row_objet['INDEX_OBJET']." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'COMMISSAIRE_PRISEUR' ORDER BY INDEX_OBJ_PER ASC";
			$auteur = mysql_query($query_auteur, $alienorweb) or die(mysql_error());
			$row_auteur = mysql_fetch_assoc($auteur);
			$totalRows_auteur = mysql_num_rows($auteur);
			$i = 0;
			if ($totalRows_auteur != 0)
			{
				$tableAuteur = "";
				do
				{
					$tableAuteur[] = $row_auteur['ETAT_CIVIL'];
				} while ($row_auteur = mysql_fetch_assoc($auteur));
			}
			if (is_array($tableDate)) 
			{
				if (is_array($tableAuteur) && $select <= count($tableAuteur)) {
					echo($tableAuteur[$select]);
					echo("<br>\n");
				}
			} else {
				for($i = 0; $i < count($tableAuteur); $i++)
				{
					echo($tableAuteur[$i]);
					echo("<br>\n");
				}
			}
			// Galerie ***************************************************************
			$tableDate = "";
			if ($row_objet['GALERIE_DEB_DATE_PATRIMONIALE'] != "") {
				$dateRef = "";
				$tableDate[] = explode("/",$row_objet['GALERIE_DEB_DATE_PATRIMONIALE']);
				$dateRef = $tableDate[0];
				$select = 0;
				for($i = 0; $i < count($tableDate); $i++)
				{
					if ($tableDate[$i] > $dateRef)
					{
						$select++;
					}
				}
			}
			
			$query_auteur = "SELECT personne.INDEX_PERSONNE, personne.ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET = ".(int)$row_objet['INDEX_OBJET']." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'GALERIE' ORDER BY INDEX_OBJ_PER ASC";
			$auteur = mysql_query($query_auteur, $alienorweb) or die(mysql_error());
			$row_auteur = mysql_fetch_assoc($auteur);
			$totalRows_auteur = mysql_num_rows($auteur);
			$i = 0;
			if ($totalRows_auteur != 0)
			{ 
				$tableAuteur = "";
				do
				{
					$tableAuteur[] = $row_auteur['ETAT_CIVIL'];
				} while ($row_auteur = mysql_fetch_assoc($auteur));
			}
			if (is_array($tableDate)) 
			{
				if (is_array($tableAuteur) && $select <= count($tableAuteur)) {
					echo($tableAuteur[$select]);
				}
			} else {
				for($i = 0; $i < count($tableAuteur); $i++)
				{
					echo($tableAuteur[$i]);
					echo("<br>\n");
				}
			}
			?></td>
                <td>Emplacement&nbsp;:</td>
                <td class="lighter"><?php 
			$query_gestion = "SELECT gestion.EMPLACEMENT, gestion.DATE_EMPLACEMENT FROM gestion, obj_ges WHERE obj_ges.INDEX_GESTION = gestion.INDEX_GESTION AND obj_ges.INDEX_OBJET = ".(int)$row_objet['INDEX_OBJET']."";
			$gestion = mysql_query($query_gestion, $alienorweb) or die(mysql_error());
			$row_gestion = mysql_fetch_assoc($gestion);
			$totalRows_gestion = mysql_num_rows($gestion);
			if ($totalRows_gestion != 0)
			$tableDate = "";
			$tableEmplacement = "";
			$dateRef = "";
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
				echo($tableEmplacement[$select]);
			}
			?>
                </td>
            </tr>
            <tr>
                <td>Localisation&nbsp;:</td>
                <td class="lighter"><input type="text" name="LOCALISATION" value="<?php echo $row_objet['LOCALISATION']; ?>" size="32"></td>
                <td>&nbsp;</td>
                <td><?php
							$champs_affiche = array("localis�","d�truit","manquant");
								for($i = 0; $i < count($champs_affiche); $i++) { ?>
                    <div class="caseAcocher">
                        <label>
                        <input name="COMMENTAIRES[]" type="checkbox" value="<?php echo $champs_affiche[$i]; ?>"<?php
									$position = array_search($champs_affiche[$i],$tableau_donnees);
									if ($position === false) {
										;
									} else {?> checked="checked"<?php } ?>>
                        <?php echo $champs_affiche[$i]; ?></label>
                    </div>
                    <?php } ?></td>
            </tr>
        </table>
        <h2>Actions men&eacute;es lors du r&eacute;colement</h2>
        <table id="action">
            <tr>
                <td width="10%" height="24">Photographi&eacute;&nbsp;le&nbsp;:</td>
                <td width="25%" class="lighter lignes"><img src="/alienorweblibre/images/espaceur.gif" alt="" width="100" height="1"></td>
                <td width="3%">Par&nbsp;: </td>
                <td width="40%" class="lighter lignes"><img src="/alienorweblibre/images/espaceur.gif" alt="" width="220" height="1"></td>
                <td width="17%">N&deg; d&#8217;ordre &agrave;&nbsp;la prise de vue&nbsp;: </td>
                <td width="5%" class="lighter lignes"><img src="/alienorweblibre/images/espaceur.gif" alt="" width="50" height="1"></td>
            </tr>
            <tr>
                <td>Marquage&nbsp;:</td>
                <td colspan="5"><?php 
								$champs_recupere = $row_gestion['COMMENTAIRES'];
								$tableau_donnees = explode("/",$champs_recupere);
								$champs_affiche = array("marqu�","etiquette fil","sur contenant");
								for($i = 0; $i < count($champs_affiche); $i++) { ?>
                    <div class="caseAcocher">
                        <label>
                        <input name="COMMENTAIRES[]" type="checkbox" value="<?php echo $champs_affiche[$i]; ?>"<?php
									$position = array_search($champs_affiche[$i],$tableau_donnees);
									if ($position === false) {
										;
									} else {?> checked="checked"<?php } ?>>
                        <?php echo $champs_affiche[$i]; ?></label>
                    </div>
                    <?php } ?></td>
            </tr>
            <tr>
                <td>Autres actions&nbsp;: </td>
                <td colspan="5"><?php
							$champs_affiche = array("d�poussi�r�","consolidation","conditionn�","nettoyage l�ger","renouvellement du conditionnement");
								for($i = 0; $i < count($champs_affiche); $i++) { ?>
                    <div class="caseAcocher">
                        <label>
                        <input name="COMMENTAIRES[]" type="checkbox" value="<?php echo $champs_affiche[$i]; ?>"<?php
									$position = array_search($champs_affiche[$i],$tableau_donnees);
									if ($position === false) {
										;
									} else {?> checked="checked"<?php } ?>>
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
                <td class="lighter lignes">&nbsp;</td>
            </tr>
        </table>
        <input type="submit" name="Submit" value="Envoyer">
        <input type="hidden" name="MM_update" value="ins_inventaire">
    </form>
    <?php } while ($row_objet = mysql_fetch_assoc($objet)); ?>
<br class="pageEnd">
<p style="text-align:center">&copy; Fiche obtenue par AlienorWebLibre</p>
</body>
</html>
<?php
mysql_free_result($objet);
mysql_free_result($auteur);
mysql_free_result($auteur1);
mysql_free_result($lieu);
mysql_free_result($gestion);
?>
