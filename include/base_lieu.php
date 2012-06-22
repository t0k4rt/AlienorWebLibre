<?php
	include('fonctions.php');
	include('../include/securite.php');
	$date = date("Y.m.d");
	(isset($_GET['noFiche']) && $_GET['noFiche'] != 0) ? $noFiche = $_GET['noFiche']  : $noFiche = 0 ;
	
// ----------------- Détection pour duplication -----------------
	(isset($_GET['duplication']) && $_GET['duplication'] != 0) ? $duplication = $_GET['duplication']  : $duplication = 0 ;
// --------------------------------------------------------------		
	
	$creation = 0;
	$doublon = 0;
	require_once('../Connections/alienorweblibre.php');

// Début affichage de tous les champs de la fiche
	mysql_select_db($database_alienorweblibre, $alienorweblibre);
	$query_rech_lieu = "SELECT * FROM lieu WHERE INDEX_LIEU = ".$noFiche;
	$rech_lieu = mysql_query($query_rech_lieu, $alienorweblibre) or die(mysql_error());
	$row_rech_lieu = mysql_fetch_assoc($rech_lieu);
	$totalRows_rech_lieu = mysql_num_rows($rech_lieu);
// Fin affichage de tous les champs de la fiche




$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == 'lieu')) {
	$noFiche = intval($_POST['INDEX_LIEU']);
	$totalRows_rech_doublon = 0;
	$requete = "";	
	if ($_POST['SITE'] != $_POST['SITE_INIT']) {	
		// Recherche si doubon de numéro d'inventaire sur un même musée
		mysql_select_db($database_alienorweblibre, $alienorweblibre);
		$query_rech_doublon = "SELECT * FROM lieu WHERE SITE = '".addslashes($_POST['SITE'])."'";
		$rech_doublon = mysql_query($query_rech_doublon, $alienorweblibre) or die(mysql_error());
		$row_rech_doublon = mysql_fetch_assoc($rech_doublon);
		$totalRows_rech_doublon = mysql_num_rows($rech_doublon);
		// echo("Nb résultat = ".$totalRows_rech_personne."<br>");
	}
	
	if ($totalRows_rech_doublon != 0) {	
		$msg = "Ce lieu existe déjà";
		$doublon = 1;		
	} else {	
		if ($noFiche == 0 && $_POST['SITE'] != '') {						
			// Début création de fiche */
			$IDENTIFIANT_national = ident_nat("lieux");
			$insertSQL = sprintf("INSERT INTO lieu (SITE,FICHE_CREEE_LE,IDENTIFIANT_NATIONAL) VALUES (%s,%s,%s)",
								GetSQLValueString($_POST['SITE'], "text"),
								GetSQLValueString($date, "date"),
								GetSQLValueString($IDENTIFIANT_national, "text"));
			// echo ("Insertion = ".$insertSQL);
			mysql_select_db($database_alienorweblibre, $alienorweblibre);
			$Result1 = mysql_query($insertSQL, $alienorweblibre) or die(mysql_error());
			$creation = 1;
			// fin création fiches
			 
			// Récuperation du numéro de la fiche créée
			mysql_select_db($database_alienorweblibre, $alienorweblibre);
			$query_lieu = "SELECT INDEX_LIEU FROM lieu WHERE SITE = '".$_POST['SITE']."'";
			$lieu = mysql_query($query_lieu, $alienorweblibre) or die(mysql_error());
			$row_lieu = mysql_fetch_assoc($lieu);
			$totalRows_lieu = mysql_num_rows($lieu);
			do {
				$noFiche = intval($row_lieu['INDEX_LIEU']);
			} while ($row_lieu = mysql_fetch_assoc($lieu));
			$_POST['IDENTIFIANT_NATIONAL'] = $IDENTIFIANT_national;
			// Fin de récupération de la fiche créée */
		}
		
		// ----------------- Construction dynamique de la requête de mise à jour -----------------
		
		foreach($_POST as $key=>$val) {
			//echo("<b>Rubrique =</b> ".$key." <b>Valeur =</b> ".$val."<br>");
			$val = trim($val);
			$val = addslashes($val);
			if ($key != 'valider_x' && $key != 'valider_y' && $key != 'MM_update' && $key != 'SITE_INIT' ) {	
			// Séparation des valeurs
			$tableau = split("/",$val);
			
				for ($i=0; $i < count($tableau); $i++) {
					// ----------------- Début de traitement des champs personnes -----------------
					if ($key == 'OCCUPANT') {
						// Recherche des personne
						mysql_select_db($database_alienorweblibre, $alienorweblibre);
						$query_liaison_debut = "SELECT INDEX_PERSONNE FROM lie_per WHERE QUALIFIANT = '".$key."' AND INDEX_LIEU = ".$noFiche;
						$liaison_debut = mysql_query($query_liaison_debut, $alienorweblibre) or die(mysql_error());
						$row_liaison_debut = mysql_fetch_assoc($liaison_debut);
						$totalRows_liaison_debut = mysql_num_rows($liaison_debut);
						$execution_liaison_debut = array();
						$i = 0;
						do {
							$execution_liaison_debut[$i] = $row_liaison_debut['INDEX_PERSONNE'];
							$i++;
						} while ($row_liaison_debut = mysql_fetch_assoc($liaison_debut));
						$execution_liaison_fin = array();
						// fin de recherche des personne
						
						// Création, affectation, et liaison de la personne
						$tableau = split("/",$val);
							
						for ($i=0; $i < count($tableau); $i++) {
							$personne_exe = $tableau[$i];	
							// Recherche si la personne existe déjà
							mysql_select_db($database_alienorweblibre, $alienorweblibre);
							$query_personne = "SELECT INDEX_PERSONNE FROM personne WHERE ETAT_CIVIL = '".$personne_exe."'";
							$personne = mysql_query($query_personne, $alienorweblibre) or die(mysql_error());
							$row_personne = mysql_fetch_assoc($personne);
							$totalRows_personne_exe = mysql_num_rows($personne);			
							do {
								$personne_exe_trouve = intval($row_personne['INDEX_PERSONNE']);
							} while ($row_personne = mysql_fetch_assoc($personne));	
							$execution_liaison_fin[$i] = $personne_exe_trouve;
							// fin de recherche
							
							// Si lieu_exe non existant, la fiche est créée			
							if ($personne_exe_trouve == "" && $val != "") {
								// Début création de fiche personne
								$IDENTIFIANT_national = ident_nat("personnes");
								$insertSQL = sprintf("INSERT INTO personne (ETAT_CIVIL,FICHE_CREEE_LE,FICHE_CREEE_PAR,CODEMUSEE,NIVEAU_VISA,IDENTIFIANT_NATIONAL) VALUES ('".$personne_exe."',%s,'".$_POST['FICHE_CREEE_PAR']."','".$_POST['CODEMUSEE']."','".$_POST['NIVEAU_VISA']."', '".$IDENTIFIANT_national."')",GetSQLValueString($date, "date"));
								mysql_select_db($database_alienorweblibre, $alienorweblibre);
								$Result1 = mysql_query($insertSQL, $alienorweblibre) or die(mysql_error());
								// fin création fiche personne
								
								// Recherche de l'id de la personne créée
								mysql_select_db($database_alienorweblibre, $alienorweblibre);
								$query_personne = "SELECT INDEX_PERSONNE FROM personne WHERE ETAT_CIVIL = '".$personne_exe."'";
								$personne = mysql_query($query_personne, $alienorweblibre) or die(mysql_error());
								$row_personne = mysql_fetch_assoc($personne);
								$totalRows_personne_exe = mysql_num_rows($personne);			
								do {
									$personne_exe_trouve = intval($row_personne['INDEX_PERSONNE']);
								} while ($row_personne = mysql_fetch_assoc($personne));
								$execution_liaison_fin[$i] = $personne_exe_trouve;
								// fin de recherche de l'id de la personne créée	
										
								// Début liaison de la fiche personne avec la fiche lieu
								$insertSQL = sprintf("INSERT INTO lie_per (INDEX_LIEU,INDEX_PERSONNE,QUALIFIANT) VALUES (".$noFiche.",".$personne_exe_trouve.",'".$key."')");
								mysql_select_db($database_alienorweblibre, $alienorweblibre);
								$Result1 = mysql_query($insertSQL, $alienorweblibre) or die(mysql_error());
								// Fin liaison de la fiche lieu avec la fiche personne
							} else {
								
								// Recherche si liaison existante
								mysql_select_db($database_alienorweblibre, $alienorweblibre);
								$query_liaison = "SELECT INDEX_LIE_PER FROM lie_per WHERE INDEX_PERSONNE = ".$personne_exe_trouve." AND INDEX_LIEU = ".$noFiche." AND QUALIFIANT = '".$key."'";
								$liaison = mysql_query($query_liaison, $alienorweblibre) or die(mysql_error());
								$row_liaison = mysql_fetch_assoc($liaison);
								$totalRows_liaison = mysql_num_rows($liaison);
								do {
									$index_liaison = intval($row_liaison['INDEX_LIE_PER']);
								} while ($row_liaison = mysql_fetch_assoc($liaison));	
								// fin de recherche de la liaison
								
								if ($index_liaison == "" && $val != "") {
									// Début liaison de la fiche lieu avec la fiche personne
									$insertSQL = sprintf("INSERT INTO lie_per (INDEX_LIEU,INDEX_PERSONNE,QUALIFIANT) VALUES (".$noFiche.",".$personne_exe_trouve.",'".$key."')",
									GetSQLValueString($_POST['INDEX_LIEU'], "num"));
									mysql_select_db($database_alienorweblibre, $alienorweblibre);
									$Result1 = mysql_query($insertSQL, $alienorweblibre) or die(mysql_error());
									// Fin liaison de la fiche lieu avec la fiche personne
								}
							}
						}
						$difference = array_diff($execution_liaison_debut,$execution_liaison_fin);
						while (list($keyb,$valb)=each($difference)) {
							if ($valb != 0) {
								$deleteSQL = sprintf("DELETE FROM lie_per WHERE INDEX_PERSONNE = ".intval($valb)." AND INDEX_LIEU = ".$noFiche." AND QUALIFIANT = '".$key."'");
								mysql_select_db($database_alienorweblibre, $alienorweblibre);
								$Result1 = mysql_query($deleteSQL, $alienorweblibre) or die(mysql_error());
							}
						}	
					// ----------------- Fin traitement des champs lieu -----------------
					} else {
						// ----------------- traitement des champs documentation -----------------
						if ($key == 'BIBLIOGRAPHIE' || $key == 'PHOTOGRAPHIE' || $key == 'EXPOSITION' || $key == 'CEDEROM' || $key == 'INTERNET' || $key == 'TAPUSCRIT' || $key == 'MANUSCRIT' || $key == 'VIDEO' || $key == 'REPRODUCTION') {
							// Recherche de documentation
							mysql_select_db($database_alienorweblibre, $alienorweblibre);
							$query_liaison_debut = "SELECT INDEX_DOCUMENTATION FROM lie_doc WHERE QUALIFIANT = '".$key."' AND INDEX_LIEU = ".$noFiche."";
							$liaison_debut = mysql_query($query_liaison_debut, $alienorweblibre) or die(mysql_error());
							$row_liaison_debut = mysql_fetch_assoc($liaison_debut);
							$totalRows_liaison_debut = mysql_num_rows($liaison_debut);
							$execution_liaison_debut = array();
							$i = 0;
							do {
								$execution_liaison_debut[$i] = $row_liaison_debut['INDEX_DOCUMENTATION'];
								$i++;
							} while ($row_liaison_debut = mysql_fetch_assoc($liaison_debut));						
							$execution_liaison_fin = array();
							// Fin de recherche documentation	
							
							// Création ou liaison de la documentation avec la fiche personne
							$tableau = split("/",$val);
							
							for ($i=0; $i < count($tableau); $i++) {
								$docum_exe = $tableau[$i];	
								/* Recherche si la documentation existe déjà */
								mysql_select_db($database_alienorweblibre, $alienorweblibre);
								$query_docum = "SELECT INDEX_DOCUMENTATION FROM documentation WHERE IDENTIFIANT = '".$docum_exe."'";
								$docum = mysql_query($query_docum, $alienorweblibre) or die(mysql_error());
								$row_docum = mysql_fetch_assoc($docum);
								$totalRows_docum_exe = mysql_num_rows($docum);			
								do {
									$docum_exe_trouve = intval($row_docum['INDEX_DOCUMENTATION']);
								} while ($row_docum = mysql_fetch_assoc($docum));	
								$execution_liaison_fin[$i] = $docum_exe_trouve;
								// fin de recherche de  la documentation
								
								// Si la document est non existant la fiche est créée			
								if ($docum_exe_trouve == "" && $val != "") {
									// Début création de fiche documentation
									$IDENTIFIANT_national = ident_nat("documentations");
									$insertSQL = sprintf("INSERT INTO documentation (IDENTIFIANT,FICHE_CREEE_LE,FICHE_CREEE_PAR,CODEMUSEE,NIVEAU_VISA,IDENTIFIANT_NATIONAL) VALUES ('".$docum_exe."',%s,'".$_POST['FICHE_CREEE_PAR']."','".$_POST['CODEMUSEE']."','".$_POST['NIVEAU_VISA']."','".$IDENTIFIANT_national."')",GetSQLValueString($date, "date"));
									mysql_select_db($database_alienorweblibre, $alienorweblibre);
									$Result1 = mysql_query($insertSQL, $alienorweblibre) or die(mysql_error());
									// Fin de création de la fiche documentation
									
									// Recherche de l'id de la fiche documention créée
									mysql_select_db($database_alienorweblibre, $alienorweblibre);
									$query_docum = "SELECT INDEX_DOCUMENTATION FROM documentation WHERE IDENTIFIANT = '".$docum_exe."'";
									$docum = mysql_query($query_docum, $alienorweblibre) or die(mysql_error());
									$row_docum = mysql_fetch_assoc($docum);
									$totalRows_docum_exe = mysql_num_rows($docum);			
									do {
										$docum_exe_trouve = intval($row_docum['INDEX_DOCUMENTATION']);
									} while ($row_docum = mysql_fetch_assoc($docum));
									$execution_liaison_fin[$i] = $docum_exe_trouve;
									// Fin de recherche de l'id de la fiche documention créée	
											
									// Début liaison de la fiche documentation avec la fiche personne
									$insertSQL = sprintf("INSERT INTO lie_doc (INDEX_LIEU,INDEX_DOCUMENTATION,QUALIFIANT) VALUES (".$noFiche.",".$docum_exe_trouve.",'".$key."')");
									mysql_select_db($database_alienorweblibre, $alienorweblibre);
									$Result1 = mysql_query($insertSQL, $alienorweblibre) or die(mysql_error());
									// Fin liaison de la fiche documentation avec la fiche personne
								} else {								
									// Recherche si liaison existante
									mysql_select_db($database_alienorweblibre, $alienorweblibre);
									$query_liaison = "SELECT INDEX_LIE_DOC FROM lie_doc WHERE INDEX_DOCUMENTATION = ".$docum_exe_trouve." AND INDEX_LIEU = ".$noFiche." AND QUALIFIANT = '".$key."'";
									$liaison = mysql_query($query_liaison, $alienorweblibre) or die(mysql_error());
									$row_liaison = mysql_fetch_assoc($liaison);
									$totalRows_liaison = mysql_num_rows($liaison);
									do {
										$index_liaison = $row_liaison['INDEX_LIE_DOC'];
									} while ($row_liaison = mysql_fetch_assoc($liaison));	
									// Fin de recherche
									
									if ($index_liaison == "" && $val != "") {
										// Début liaison de la fiche documentation avec la fiche personne
										$insertSQL = sprintf("INSERT INTO lie_doc (INDEX_LIEU,INDEX_DOCUMENTATION,QUALIFIANT) VALUES (".$noFiche.",".$docum_exe_trouve.",'".$key."')");
										mysql_select_db($database_alienorweblibre, $alienorweblibre);
										$Result1 = mysql_query($insertSQL, $alienorweblibre) or die(mysql_error());
										// Fin liaison de la fiche documentation avec la fiche personne
									}
								}
							}
							$difference = array_diff($execution_liaison_debut,$execution_liaison_fin);
							while (list($keyc,$valc)=each($difference)) {
								if ($valc != 0) {
									$deleteSQL = sprintf("DELETE FROM lie_doc WHERE INDEX_DOCUMENTATION=".intval($valc)." AND INDEX_LIEU=".$noFiche." AND QUALIFIANT = '".$key."'");
									mysql_select_db($database_alienorweblibre, $alienorweblibre);
									$Result1 = mysql_query($deleteSQL, $alienorweblibre) or die(mysql_error());
								}
							}				
						} else {	
							// ----------------- traitement des champs personnes -----------------
							if ($requete == "") {
								if ($key != 'INDEX_LIEU'){$requete = $requete." ".$key." = '".$val."'";};
							} else {
							// ----------------- si la valeur est une date la convertir -----------------
								if (ereg("([0-9]{2}).([0-9]{2}).([0-9]{4})", $val)) {
									$val = preg_replace('/^(.{2}).(.{2}).(.{4})$/','$3-$2-$1', $val);
								}
							// ---------------------------------------------------------------------------
								$requete = $requete.", ".$key." = '".$val."'";
							}
						}
					}
				}	
			}
		}
		// Reqêtes des mise à jour de la fiche
		$val = date('Y.m.d');
		$key = "MISE_A_JOUR";
		$requete = $requete.", ".$key." = '".$val."'";
		$requete = preg_replace('#(\'\')#','NULL', $requete);
		$updateSQL = sprintf("UPDATE lieu SET ".$requete." WHERE INDEX_LIEU = ".$noFiche);
		// echo("Mise à jour de la fiche personne = ".$updateSQL."<br>");
							   
		mysql_select_db($database_alienorweblibre, $alienorweblibre);
		$Result1 = mysql_query($updateSQL, $alienorweblibre) or die(mysql_error());
	
	// Fin mise à jour de la fiche
	
	// Redirection vers l'affichage de la page modifiée ou vers la page de gestion si nouvelle fiche
	
	redirection($creation,$noFiche,$doublon,$page,$isobjet);
	}
}
?>