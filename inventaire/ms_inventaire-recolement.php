<?php
	include('../Connections/alienorweb.php');
	include('../include/fonctions.php');
	include('base_objet.php');
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
<?php if ($msg != "") { ?>
<p style="color:#FF0000; font-weight:bold; text-align:center"><?php echo $msg; ?></p>
<?php } ?>
<?php do { ?>
<form action="<?php echo $editFormAction; ?>" method="POST" name="objets" id="objets" title="Remplissage formulaire de recollement" enctype="multipart/form-data">
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
            <td width="9%"><img src="/alienorweblibre/images/Logo_CIRM.jpg" alt="Logo du Conseil inter-r&eacute;gionnal des mus&eacute;es" name="logo" width="195" height="113" id="logo"></td>
            <td width="74%" class="centrage"><h1>Bordereau d&#8217;inventaire - R&eacute;colement</h1></td>
            <td width="17%" rowspan="5"><div>
                    <!-- D&eacute;but de l'emplamcement de l'affichage image(s) -->
                    <!-- Fin de l'emplamcement de l'affichage image(s) -->
                </div></td>
        </tr>
        <tr>
            <td>N&deg; d&#8217;inv.&nbsp;: </td>
            <td class="emphase"><?php (isset($_POST['NUMERO_INVENTAIRE'])) ? $valeur = $_POST['NUMERO_INVENTAIRE'] : $valeur = $row_rech_objet['NUMERO_INVENTAIRE']; ?>
                <input name="NUMERO_INVENTAIRE" type="text" value="<?php echo stripslashes($valeur); ?>" size="32">
            </td>
        </tr>
        <tr>
            <td colspan="2"><?php 
								$valeur = $row_rech_objet['COMMENTAIRES']; 
								$tableau_donnees = explode("/",$valeur);
								$champs_affiche = array("marqué","etiquette fil","sur contenant");
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
            <td class="emphase"><?php (isset($_POST['DENOMINATION'])) ? $valeur = $_POST['DENOMINATION'] : $valeur = $row_rech_objet['DENOMINATION']; ?>
                <input name="DENOMINATION" type="text" value="<?php echo stripslashes($valeur); ?>" size="32"></td>
        </tr>
        <tr>
            <td>Titre&nbsp;:</td>
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
                        <td width="21%">Mati&egrave;re&nbsp;:</td>
                        <td width="79%" class="lighter"><?php (isset($_POST['MATIERE'])) ? $valeur = $_POST['MATIERE'] : $valeur = $row_rech_objet['MATIERE']; ?>
                            <input name="MATIERE" type="text" value="<?php echo stripslashes($valeur); ?>" size="32"></td>
                    </tr>
                    <tr>
                        <td>Technique&nbsp;:</td>
                        <td class="lighter"><?php (isset($_POST['TECHNIQUE'])) ? $valeur = $_POST['TECHNIQUE'] : $valeur = $row_rech_objet['TECHNIQUE']; ?>
                            <input name="TECHNIQUE" type="text" value="<?php echo stripslashes($valeur); ?>" size="32"></td>
                    </tr>
                    <tr>
                        <td>Description&nbsp;:</td>
                        <td class="lighter" style="text-align:justify"><span class="lignes">
                            <?php (isset($_POST['TYPE_INSCRIPTION'])) ? $valeur = $_POST['TYPE_INSCRIPTION'] : $valeur = $row_rech_objet['TYPE_INSCRIPTION']; ?>
                            <input name="TYPE_INSCRIPTION" type="text" value="<?php echo stripslashes($valeur); ?>" size="32">
                            </span></td>
                    </tr>
                    <tr>
                        <td>Dimensions&nbsp;:</td>
                        <td class="lighter"><span class="lignes"> <?php echo $row_rech_objet['DIMENSIONS_FORMES']; ?>&nbsp;</span></td>
                    </tr>
                    <tr>
                        <td>Inscriptions&nbsp;:</td>
                        <td class="lighter"><span class="lighter" style="text-align:justify"><?php echo $row_rech_objet['TRANSCRIPTION_INSCRIPTION']; ?>&nbsp;</span></td>
                    </tr>
                    <tr>
                        <td colspan="2">&Eacute;tat&nbsp;:</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="justifie"><span class="lighter">
                            <?php 
						$tableDate = "";
						$query_gestion = "SELECT gestion.ETAT_CONSERVATION, gestion.DATE_CONSERVATION, gestion.EXPERT FROM gestion, obj_ges WHERE obj_ges.INDEX_GESTION = gestion.INDEX_GESTION AND obj_ges.INDEX_OBJET = ".(int)$row_rech_objet['INDEX_OBJET']."";
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
                        <td width="86%" class="lignes"><?php (isset($_POST['DIMENSIONS_FORMES'])) ? $valeur = $_POST['DIMENSIONS_FORMES'] : $valeur = $row_rech_objet['DIMENSIONS_FORMES']; ?>
                            <input type="text" name="DIMENSIONS_FORMES" value="<?php echo stripslashes($valeur); ?>" size="32"></td>
                    </tr>
                    <tr>
                        <td>Inscriptions&nbsp;:</td>
                        <td class="lignes"><?php (isset($_POST['TRANSCRIPTION_INSCRIPTION'])) ? $valeur = $_POST['TRANSCRIPTION_INSCRIPTION'] : $valeur = $row_rech_objet['TRANSCRIPTION_INSCRIPTION']; ?>
                            <input type="text" name="TRANSCRIPTION_INSCRIPTION" value="<?php echo stripslashes($valeur); ?>" size="32"></td>
                    </tr>
                    <tr>
                        <td>&Eacute;tat&nbsp;:</td>
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
									} else {?> checked="checked"<?php } ?>>
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
						$query_auteur = "SELECT personne.INDEX_PERSONNE, ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET = ".(int)$row_rech_objet['INDEX_OBJET']." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'COLLECTEUR' ORDER BY INDEX_OBJ_PER ASC";
						//echo("\$query_auteur : ".$query_auteur);
						$auteur = mysql_query($query_auteur, $alienorweb) or die(mysql_error());
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
                            <label for="COLLECTEUR">Collecteur</label>
                            <input type="text" name="COLLECTEUR" value="<?php echo stripslashes($valeur); ?>" size="32">
                            <br>
                            <?php
						// inventeur
						$query_auteur = "SELECT personne.INDEX_PERSONNE, ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET = ".(int)$row_rech_objet['INDEX_OBJET']." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'INVENTEUR' ORDER BY INDEX_OBJ_PER ASC";
						//echo("\$query_auteur : ".$query_auteur);
						$auteur = mysql_query($query_auteur, $alienorweb) or die(mysql_error());
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
                            <label for="INVENTEUR">Inventeur</label>
                            <input type="text" id="INVENTEUR" name="INVENTEUR" value="<?php echo stripslashes($valeur); ?>" size="32">
                        </td>
                    </tr>
                    <tr>
                        <td>Lieu de collecte&nbsp;:</td>
                        <td class="lighter"><?php
$query_lieu = "SELECT lieu.INDEX_LIEU, SITE FROM lieu,obj_lie WHERE obj_lie.INDEX_OBJET =".(int)$row_rech_objet['INDEX_OBJET']." AND lieu.INDEX_LIEU = obj_lie.INDEX_LIEU AND obj_lie.QUALIFIANT = 'LIEUX_DECOUVERTE' ORDER BY INDEX_OBJ_LIE ASC";
						$lieu = mysql_query($query_lieu, $alienorweb) or die(mysql_error());
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
                        <td class="lighter"><?php (isset($_POST['TXT_DATE_DECOUVERTE'])) ? $valeur = $_POST['TXT_DATE_DECOUVERTE'] : $valeur = $row_rech_objet['TXT_DATE_DECOUVERTE']; ?>
                            <input name="TXT_DATE_DECOUVERTE" type="text" value="<?php echo stripslashes($valeur); ?>" size="10">
                            <?php (isset($_POST['DEB_DATE_DECOUVERTE'])) ? $valeur = $_POST['DEB_DATE_DECOUVERTE'] : $valeur = $row_rech_objet['DEB_DATE_DECOUVERTE']; ?>
                            <input name="DEB_DATE_DECOUVERTE" type="text" value="<?php echo reverseDate(stripslashes($valeur)); ?>" size="10">
                            <?php (isset($_POST['FIN_DATE_DECOUVERTE'])) ? $valeur = $_POST['FIN_DATE_DECOUVERTE'] : $valeur = $row_rech_objet['FIN_DATE_DECOUVERTE']; ?>
                            <input name="FIN_DATE_DECOUVERTE" type="text" value="<?php echo reverseDate(stripslashes($valeur)); ?>" size="10"></td>
                    </tr>
                    <tr>
                        <td colspan="2">Pr&eacute;cision&nbsp;sur&nbsp;la&nbsp;collecte&nbsp;:</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="justifie"><span class="lignes">
                            <?php (isset($_POST['PRECISION_DECOUVERTE'])) ? $valeur = $_POST['PRECISION_DECOUVERTE'] : $valeur = $row_rech_objet['PRECISION_DECOUVERTE']; ?>
                            <textarea name="PRECISION_DECOUVERTE" cols="50" rows="4"><?php echo stripslashes($valeur); ?></textarea>
                            </span></td>
                    </tr>
                </table></td>
            <td class="unDemi"><h2>Donn&eacute;es sur l&#8217;ex&eacute;cution </h2>
                <table>
                    <tr>
                        <td width="30%">Auteur,&nbsp;attribution&nbsp;:</td>
                        <td width="70%" class="lighter"><?php
						$query_auteur = "SELECT personne.INDEX_PERSONNE, ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET = ".(int)$row_rech_objet['INDEX_OBJET']." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'AUTEUR' ORDER BY INDEX_OBJ_PER ASC";
						$auteur = mysql_query($query_auteur, $alienorweb) or die(mysql_error());
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
                            <label for="AUTEUR">Auteur</label>
                            <input type="text" name="AUTEUR" id="AUTEUR" value="<?php echo stripslashes($valeur); ?>" size="32">
                            <?php
						// Attribution
						$query_auteur = "SELECT personne.INDEX_PERSONNE, ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET = ".(int)$row_rech_objet['INDEX_OBJET']." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'ATTRIBUTION' ORDER BY INDEX_OBJ_PER ASC";
						$auteur = mysql_query($query_auteur, $alienorweb) or die(mysql_error());
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
                            <?php (isset($_POST['ATTRIBUTION'])) ? $valeur = $_POST['ATTRIBUTION'] : $valeur = $result; ?>
                            <label for="ATTRIBUTION">Attribution</label>
                            <input type="text" name="ATTRIBUTION" id="ATTRIBUTION" value="<?php echo stripslashes($valeur); ?>" size="32">
                            <?php
						//Attributeur
						$query_auteur = "SELECT personne.INDEX_PERSONNE, ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET = ".(int)$row_rech_objet['INDEX_OBJET']." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'ATTRIBUTEUR' ORDER BY INDEX_OBJ_PER ASC";
						$auteur = mysql_query($query_auteur, $alienorweb) or die(mysql_error());
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
                            <label for="ATTRIBUTEUR">Attributeur</label>
                            <input type="text" name="ATTRIBUTEUR" id="ATTRIBUTEUR" value="<?php echo stripslashes($valeur); ?>" size="32">
                        </td>
                    </tr>
                    <tr>
                        <td width="30%">Lieu&nbsp;d&#8217;ex&eacute;cution&nbsp;:</td>
                        <td width="70%" class="lighter"><?php
						$query_lieu = "SELECT lieu.INDEX_LIEU, SITE FROM lieu,obj_lie WHERE obj_lie.INDEX_OBJET =".(int)$row_rech_objet['INDEX_OBJET']." AND lieu.INDEX_LIEU = obj_lie.INDEX_LIEU AND obj_lie.QUALIFIANT = 'LIEUX_EXECUTION' ORDER BY INDEX_OBJ_LIE ASC";
						$lieu = mysql_query($query_lieu, $alienorweb) or die(mysql_error());
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
                        <td width="30%">Date&nbsp;d&#8217;ex&eacute;cution&nbsp;:</td>
                        <td width="70%" class="lighter"><?php (isset($_POST['TXT_DATE_EXECUTION'])) ? $valeur = $_POST['TXT_DATE_EXECUTION'] : $valeur = $row_rech_objet['TXT_DATE_EXECUTION']; ?>
                            <input name="TXT_DATE_EXECUTION" type="text" value="<?php echo stripslashes($valeur); ?>" size="10">
                            <?php (isset($_POST['DEB_DATE_EXECUTION'])) ? $valeur = $_POST['DEB_DATE_EXECUTION'] : $valeur = $row_rech_objet['DEB_DATE_EXECUTION']; ?>
                            <input name="DEB_DATE_EXECUTION" type="text" value="<?php echo reverseDate(stripslashes($valeur)); ?>" size="10">
                            <?php (isset($_POST['FIN_DATE_EXECUTION'])) ? $valeur = $_POST['FIN_DATE_EXECUTION'] : $valeur = $row_rech_objet['FIN_DATE_EXECUTION']; ?>
                            <input name="FIN_DATE_EXECUTION" type="text" value="<?php echo reverseDate(stripslashes($valeur)); ?>" size="10">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">Pr&eacute;cision&nbsp;sur&nbsp;la&nbsp;gen&egrave;se&nbsp;:</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="justifie"><span class="lighter">
                            <?php (isset($_POST['PRECISION_GENESE'])) ? $valeur = $_POST['PRECISION_GENESE'] : $valeur = $row_rech_objet['PRECISION_GENESE']; ?>
                            <textarea name="PRECISION_GENESE" cols="50" rows="4"><?php echo stripslashes($valeur); ?></textarea>
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
                        <td width="85%" class="lighter"><?php (isset($_POST['UTILISATION'])) ? $valeur = $_POST['UTILISATION'] : $valeur = $row_rech_objet['UTILISATION']; ?>
                            <input type="text" name="UTILISATION" value="<?php echo stripslashes($valeur); ?>" size="32">
                        </td>
                    </tr>
                </table></td>
            <td class="unDemi"><h2>Gestion</h2>
                <table>
                    <tr>
                        <td width="20%">Valeur&nbsp;d&#8217;achat&nbsp;:</td>
                        <td  width="80%" class="lighter"><?php 
						$query_gestion = "SELECT gestion.VALEUR, gestion.DATE_VALEUR FROM gestion, obj_ges WHERE obj_ges.INDEX_GESTION = gestion.INDEX_GESTION AND obj_ges.INDEX_OBJET = ".(int)$row_rech_objet['INDEX_OBJET']."";
						$gestion = mysql_query($query_gestion, $alienorweb) or die(mysql_error());
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
            <td width="13%">Propri&eacute;taire&nbsp;:</td>
            <td width="37%" class="lighter"><?php
			$query_auteur = "SELECT personne.INDEX_PERSONNE, ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET = ".(int)$row_rech_objet['INDEX_OBJET']." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'PROPRIETAIRE' ORDER BY INDEX_OBJ_PER ASC";
			//echo("\$query_auteur : ".$query_auteur);
			$auteur = mysql_query($query_auteur, $alienorweb) or die(mysql_error());
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
                <input type="text" name="PROPRIETAIRE" value="<?php echo $result; ?>" size="32">
            </td>
            <td width="14%">Mode d&#8217;acquisition&nbsp;:</td>
            <td width="36%" class="lighter"><?php (isset($_POST['MODE_ACQUISITION'])) ? $valeur = $_POST['MODE_ACQUISITION'] : $valeur = $row_rech_objet['MODE_ACQUISITION']; ?>
                <input type="text" name="MODE_ACQUISITION" value="<?php echo stripslashes($valeur); ?>" size="32"></td>
        </tr>
        <tr>
            <td>Date&nbsp;de&nbsp;l&#8217;acquisition&nbsp;:</td>
            <td class="lighter"><span class="lighter" style="text-align:justify">
                <?php (isset($_POST['PROPRIETAIRE_TXT_DATE_PATRIMONIALE'])) ? $valeur = $_POST['PROPRIETAIRE_TXT_DATE_PATRIMONIALE'] : $valeur = $row_rech_objet['PROPRIETAIRE_TXT_DATE_PATRIMONIALE']; ?>
                <input name="PROPRIETAIRE_TXT_DATE_PATRIMONIALE" type="text" value="<?php echo stripslashes($valeur); ?>" size="10">
                <?php (isset($_POST['PROPRIETAIRE_DEB_DATE_PATRIMONIALE'])) ? $valeur = $_POST['PROPRIETAIRE_DEB_DATE_PATRIMONIALE'] : $valeur = $row_rech_objet['PROPRIETAIRE_DEB_DATE_PATRIMONIALE']; ?>
                <input name="PROPRIETAIRE_DEB_DATE_PATRIMONIALE" type="text" value="<?php echo reverseDate(stripslashes($valeur)); ?>" size="10">
                <?php (isset($_POST['PROPRIETAIRE_FIN_DATE_PATRIMONIALE'])) ? $valeur = $_POST['PROPRIETAIRE_FIN_DATE_PATRIMONIALE'] : $valeur = $row_rech_objet['PROPRIETAIRE_FIN_DATE_PATRIMONIALE']; ?>
                <input name="PROPRIETAIRE_FIN_DATE_PATRIMONIALE" type="text" value="<?php echo reverseDate(stripslashes($valeur)); ?>" size="10">
                </span></td>
            <td>&nbsp;</td>
            <td class="lighter" style="text-align:justify">&nbsp;</td>
        </tr>
        <tr>
            <td><label for="label">Ancienne&nbsp;appartenance&nbsp;:</label></td>
            <td class="lighter"><?php
			// Ancienne appartenance ***************************************************************
			$query_auteur = "SELECT personne.INDEX_PERSONNE, personne.ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET = ".(int)$row_rech_objet['INDEX_OBJET']." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'ANCIENNE_APPARTENANCE' ORDER BY INDEX_OBJ_PER ASC";
			$auteur = mysql_query($query_auteur, $alienorweb) or die(mysql_error());
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
            <td rowspan="5">Emplacement&nbsp;:</td>
            <td rowspan="5" class="lighter"><?php 
			$query_gestion = "SELECT DISTINCT gestion.EMPLACEMENT, gestion.DATE_EMPLACEMENT FROM gestion, obj_ges WHERE obj_ges.INDEX_GESTION = gestion.INDEX_GESTION AND obj_ges.INDEX_OBJET = ".(int)$row_rech_objet['INDEX_OBJET']."";
			$gestion = mysql_query($query_gestion, $alienorweb) or die(mysql_error());
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
                <input type="text" name="EMPLACEMENT" value="<?php echo $result; ?>" size="32"></td>
        </tr>
        <tr>
            <td>Date d&#8217;entr&eacute;e&nbsp;:</td>
            <td class="lighter"><span class="lighter" style="text-align:justify">
                <?php (isset($_POST['ANCIENNE_APPARTENANCE_TXT_DATE_PATRIMONIALE'])) ? $valeur = $_POST['ANCIENNE_APPARTENANCE_TXT_DATE_PATRIMONIALE'] : $valeur = $row_rech_objet['ANCIENNE_APPARTENANCE_TXT_DATE_PATRIMONIALE']; ?>
                <input name="ANCIENNE_APPARTENANCE_TXT_DATE_PATRIMONIALE" type="text" value="<?php echo stripslashes($valeur); ?>" size="10">
                <?php (isset($_POST['ANCIENNE_APPARTENANCE_DEB_DATE_PATRIMONIALE'])) ? $valeur = $_POST['ANCIENNE_APPARTENANCE_DEB_DATE_PATRIMONIALE'] : $valeur = $row_rech_objet['ANCIENNE_APPARTENANCE_DEB_DATE_PATRIMONIALE']; ?>
                <input name="ANCIENNE_APPARTENANCE_DEB_DATE_PATRIMONIALE" type="text" value="<?php echo reverseDate(stripslashes($valeur)); ?>" size="10">
                <?php (isset($_POST['ANCIENNE_APPARTENANCE_FIN_DATE_PATRIMONIALE'])) ? $valeur = $_POST['ANCIENNE_APPARTENANCE_FIN_DATE_PATRIMONIALE'] : $valeur = $row_rech_objet['ANCIENNE_APPARTENANCE_FIN_DATE_PATRIMONIALE']; ?>
                <input name="ANCIENNE_APPARTENANCE_FIN_DATE_PATRIMONIALE" type="text" value="<?php echo reverseDate(stripslashes($valeur)); ?>" size="10">
                </span></td>
        </tr>
        <tr>
            <td><label for="label">Commissaire&nbsp;Priseur&nbsp;:</label></td>
            <td class="lighter"><?php
			// Commissaire priseur ***************************************************************
			$query_auteur = "SELECT personne.INDEX_PERSONNE, personne.ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET = ".(int)$row_rech_objet['INDEX_OBJET']." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'COMMISSAIRE_PRISEUR' ORDER BY INDEX_OBJ_PER ASC";
			$auteur = mysql_query($query_auteur, $alienorweb) or die(mysql_error());
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
            <td>Date d&#8217;entr&eacute;e&nbsp;:</td>
            <td class="lighter"><span class="lighter" style="text-align:justify">
                <?php (isset($_POST['COMMISSAIRE_PRISEUR_TXT_DATE_PATRIMONIALE'])) ? $valeur = $_POST['COMMISSAIRE_PRISEUR_TXT_DATE_PATRIMONIALE'] : $valeur = $row_rech_objet['COMMISSAIRE_PRISEUR_TXT_DATE_PATRIMONIALE']; ?>
                <input name="COMMISSAIRE_PRISEUR_TXT_DATE_PATRIMONIALE" type="text" value="<?php echo stripslashes($valeur); ?>" size="10">
                <?php (isset($_POST['COMMISSAIRE_PRISEUR_DEB_DATE_PATRIMONIALE'])) ? $valeur = $_POST['COMMISSAIRE_PRISEUR_DEB_DATE_PATRIMONIALE'] : $valeur = $row_rech_objet['COMMISSAIRE_PRISEUR_DEB_DATE_PATRIMONIALE']; ?>
                <input name="COMMISSAIRE_PRISEUR_DEB_DATE_PATRIMONIALE" type="text" value="<?php echo reverseDate(stripslashes($valeur)); ?>" size="10">
                <?php (isset($_POST['COMMISSAIRE_PRISEUR_FIN_DATE_PATRIMONIALE'])) ? $valeur = $_POST['COMMISSAIRE_PRISEUR_FIN_DATE_PATRIMONIALE'] : $valeur = $row_rech_objet['COMMISSAIRE_PRISEUR_FIN_DATE_PATRIMONIALE']; ?>
                <input name="ANCIENNE_APPARTENANCE_FIN_DATE_PATRIMONIALE" type="text" value="<?php echo reverseDate(stripslashes($valeur)); ?>" size="10">
                </span></td>
        </tr>
        <tr>
            <td><label for="label">Galerie&nbsp;:</label></td>
            <td class="lighter"><?php
			// Galerie ***************************************************************
			$query_auteur = "SELECT personne.INDEX_PERSONNE, personne.ETAT_CIVIL FROM personne,obj_per WHERE obj_per.INDEX_OBJET = ".(int)$row_rech_objet['INDEX_OBJET']." AND personne.INDEX_PERSONNE = obj_per.INDEX_PERSONNE AND obj_per.QUALIFIANT = 'GALERIE' ORDER BY INDEX_OBJ_PER ASC";
			$auteur = mysql_query($query_auteur, $alienorweb) or die(mysql_error());
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
            <td>Date d&#8217;entr&eacute;e&nbsp;:</td>
            <td class="lighter"><span class="lighter" style="text-align:justify">
                <?php (isset($_POST['GALERIE_TXT_DATE_PATRIMONIALE'])) ? $valeur = $_POST['GALERIE_TXT_DATE_PATRIMONIALE'] : $valeur = $row_rech_objet['GALERIE_TXT_DATE_PATRIMONIALE']; ?>
                <input name="GALERIE_TXT_DATE_PATRIMONIALE" type="text" value="<?php echo stripslashes($valeur); ?>" size="10">
                <?php (isset($_POST['GALERIE_DEB_DATE_PATRIMONIALE'])) ? $valeur = $_POST['GALERIE_DEB_DATE_PATRIMONIALE'] : $valeur = $row_rech_objet['GALERIE_DEB_DATE_PATRIMONIALE']; ?>
                <input name="GALERIE_DEB_DATE_PATRIMONIALE" type="text" value="<?php echo reverseDate(stripslashes($valeur)); ?>" size="10">
                <?php (isset($_POST['GALERIE_FIN_DATE_PATRIMONIALE'])) ? $valeur = $_POST['GALERIE_FIN_DATE_PATRIMONIALE'] : $valeur = $row_rech_objet['GALERIE_FIN_DATE_PATRIMONIALE']; ?>
                <input name="GALERIE_FIN_DATE_PATRIMONIALE" type="text" value="<?php echo reverseDate(stripslashes($valeur)); ?>" size="10">
                </span></td>
            <td>&nbsp;</td>
            <td class="lighter">&nbsp;</td>
        </tr>
        <tr>
            <td>Localisation&nbsp;:</td>
            <td class="lighter"><input type="text" name="LOCALISATION" value="<?php echo $row_rech_objet['LOCALISATION']; ?>" size="32"></td>
            <td>&nbsp;</td>
            <td><?php
							$valeur = "";
							if (isset($_POST['COMMENTAIRES'])) {
								foreach($_POST['COMMENTAIRES'] as $value) {
									$valeur .= $value."/";
								}
							}
							$tableau_donnees = explode("/",$valeur);
							$champs_affiche = array("localisé","détruit","manquant");
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
            <td width="37%" class="lighter lignes"><span class="lighter">
                <input type="text" name="TXT_DATE_PRISE_VUE" value="<?php echo $_POST['TXT_DATE_PRISE_VUE'] ?>" size="10">
                &nbsp;
                <input type="text" name="DEB_DATE_PRISE_VUE" value="<?php echo $_POST['DEB_DATE_PRISE_VUE'] ?>" size="10">
                &nbsp;
                <input type="text" name="FIN_DATE_PRISE_VUE" value="<?php echo $_POST['FIN_DATE_PRISE_VUE'] ?>" size="10">
                </span> </td>
            <td width="3%">Par&nbsp;:</td>
            <td width="20%" class="lighter lignes"><input name="PHOTOGRAPHE" class="inputlong40" type="text" value="<?php echo $_POST['PHOTOGRAPHE'] ?>"></td>
            <td width="23%">N&deg; d&#8217;ordre &agrave;&nbsp;la prise de vue (Identifiant Photo) </td>
            <td width="5%" class="lighter lignes"><input name="PHOTOGRAPHIE" class="inputlong40" value="<?php echo $_POST['PHOTOGRAPHIE'] ?>"></td>
        </tr>
        <tr>
            <td>Fichier photo </td>
            <td colspan="5">Fichier image :
                <input type="hidden" name="MAX_FILE_SIZE" value="1024000">
                <input name="FICHIER" type="file" value="">
                <br>
                attention format GIF, JPEG,PNG seulement et taille max. : 1M octets </td>
        </tr>
        <tr>
            <td>Marquage&nbsp;:</td>
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
            <td class="lighter lignes"><input type="text" name="EXPERT" value="<?php echo $_POST['EXPERT'] ?>" size="32">
                &nbsp;<span class="lighter">
                <label for="DATE_RECOLEMENT">Date de r&eacute;colement</label>
                &nbsp;
                <input type="text" id="DATE_RECOLEMENT" name="DATE_RECOLEMENT" value="<?php echo $_POST['DATE_RECOLEMENT'] ?>" size="10">
                </span></td>
        </tr>
    </table>
    <input type="submit" name="Submit" value="Envoyer">
    <input type="hidden" name="MM_update" value="objets">
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
