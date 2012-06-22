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
	$query_rech_docum = "SELECT * FROM documentation WHERE INDEX_DOCUMENTATION = ".$noFiche."";
	$rech_docum = mysql_query($query_rech_docum, $alienorweblibre) or die(mysql_error());
	$row_rech_docum = mysql_fetch_assoc($rech_docum);
	$totalRows_rech_docum = mysql_num_rows($rech_docum);	
// Fin affichage de tous les champs de la fiche




$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == 'documentation')) {
	$noFiche = intval($_POST['INDEX_DOCUMENTATION']);
	$totalRows_rech_doublon = 0;
	$requete = "";	
	if (isset($_POST['EFFACER'])) {
		$effacer = $_POST['EFFACER'];
	}else{
		$effacer = "";
	}
	if ($_POST['IDENTIFIANT'] != $_POST['IDENTIFIANT_INIT']) {	
		// Recherche si doubon de numéro d'inventaire sur un même musée
		mysql_select_db($database_alienorweblibre, $alienorweblibre);
		$query_rech_doublon = "SELECT * FROM documentation WHERE IDENTIFIANT = '".$_POST['IDENTIFIANT']."'";
		$rech_doublon = mysql_query($query_rech_doublon, $alienorweblibre) or die(mysql_error());
		$row_rech_doublon = mysql_fetch_assoc($rech_doublon);
		$totalRows_rech_doublon = mysql_num_rows($rech_doublon);
		// echo("Nb résultat = ".$totalRows_rech_objet."<br>");
	}
	
	if ($totalRows_rech_doublon != 0) {	
		$msg = "Ce numéro d'inventaire existe déjà";
		$doublon = 1;		
	} else {	
		if ($noFiche == 0 && $_POST['IDENTIFIANT'] != '') {						
			// Début création de fiche */
			$IDENTIFIANT_national = ident_nat("documentations");
			$insertSQL = sprintf("INSERT INTO documentation (IDENTIFIANT,FICHE_CREEE_LE,IDENTIFIANT_NATIONAL) VALUES (%s,%s,%s)",
								GetSQLValueString($_POST['IDENTIFIANT'], "text"),
								GetSQLValueString($date, "date"),
								GetSQLValueString($IDENTIFIANT_national, "text"));
			mysql_select_db($database_alienorweblibre, $alienorweblibre);
			$Result1 = mysql_query($insertSQL, $alienorweblibre) or die(mysql_error());
			$creation = 1;
			// fin création fiches
			 
			// Récuperation du numéro de la fiche créée
			mysql_select_db($database_alienorweblibre, $alienorweblibre);
			$query_objets = "SELECT INDEX_DOCUMENTATION FROM documentation WHERE IDENTIFIANT = '".$_POST['IDENTIFIANT']."'";
			$objets = mysql_query($query_objets, $alienorweblibre) or die(mysql_error());
			$row_objets = mysql_fetch_assoc($objets);
			$totalRows_objets = mysql_num_rows($objets);
			do {
				$noFiche = intval($row_objets['INDEX_DOCUMENTATION']);
			} while ($row_objets = mysql_fetch_assoc($objets));
			$_POST['IDENTIFIANT_NATIONAL'] = $IDENTIFIANT_national;
			// Fin de récupération de la fiche créée */
		}
		
		// ----------------- Construction dynamique de la requête de mise à jour -----------------
		
		foreach($_POST as $key=>$val){
			//echo("<b>Rubrique =</b> ".$key." <b>Valeur =</b> ".$val."<br>");
			$val = trim($val);
			$val = addslashes($val);
			if ($key != 'valider_x' && $key != 'valider_y' && $key != 'MM_update' && $key != 'IDENTIFIANT_INIT' )
			{	
			// Séparation des valeurs
			$tableau = split("/",$val);
				for ($i=0; $i < count($tableau); $i++) {
					// ----------------- Début traitement image --------------------
					if ($key == 'FICHIER'){
						// on ne fait rien cela sera traiter en même temps que le fichier image
						$conserveFichier = strToLower($val);
					}else{
						if ($key == 'nouv_image'){
							// on ne fait rien cela sera traiter en même temps que le fichier image
						}else{
							if ($key == 'MAX_FILE_SIZE'){
								// maintenant on traite les trois fichier, nouv_image et max_file_size
								$tmp = integreImage($_FILES['nouv_image'],$conserveFichier,$effacer);
								if ($tmp[0] != ""){
									$msg .= $tmp[0];
									$doublon = 1;
								}else{
									$requete .= ",FICHIER = '".$tmp[1]."'";
								}
							}else{
							// ----------------- fin traitement images
							// ----------------- Début de traitement des personnes -----------------
							if ($key == 'AUTEUR'|| $key == 'EDITEUR' || $key == 'PHOTOGRAPHE' || $key == 'WEBMESTRE') {
								// Recherche des personnes
								mysql_select_db($database_alienorweblibre, $alienorweblibre);
								$query_liaison_debut = "SELECT INDEX_PERSONNE FROM doc_per WHERE INDEX_DOCUMENTATION = ".$noFiche." AND QUALIFIANT = '".$key."'";
								$liaison_debut = mysql_query($query_liaison_debut, $alienorweblibre) or die(mysql_error());
								$row_liaison_debut = mysql_fetch_assoc($liaison_debut);
								$totalRows_liaison_debut = mysql_num_rows($liaison_debut);
								$auteur_liaison_debut = array();
								$i = 0;
								do {
									$auteur_liaison_debut[$i] = $row_liaison_debut['INDEX_PERSONNE'];
									$i++;
								} while ($row_liaison_debut = mysql_fetch_assoc($liaison_debut));					
								$auteur_liaison_fin = array();
								// Fin de recherche des personnes	
								
								// Création et liaison de l'auteur
								$tableau = split("/",$val);
								for ($i=0; $i < count($tableau); $i++) {
								
									$auteur = $tableau[$i];	
									// Recherche si l'auteur existe déjà
									mysql_select_db($database_alienorweblibre, $alienorweblibre);
									$query_personne = "SELECT INDEX_PERSONNE FROM personne WHERE ETAT_CIVIL = '".$auteur."'";
									$personne = mysql_query($query_personne, $alienorweblibre) or die(mysql_error());
									$row_personne = mysql_fetch_assoc($personne);
									$totalRows_auteur = mysql_num_rows($personne);			
									do {
										$auteur_trouve = intval($row_personne['INDEX_PERSONNE']);
									} while ($row_personne = mysql_fetch_assoc($personne));	
									$auteur_liaison_fin[$i] = $auteur_trouve;
									// fin de la recherche
										
									// Si personne non existante, la fiche est créée			
									if ($auteur_trouve == "" && $val != "") {
									
										// Création de fiche personne
										$IDENTIFIANT_national = ident_nat("personnes");
										$insertSQL = sprintf("INSERT INTO personne (ETAT_CIVIL,FICHE_CREEE_LE,FICHE_CREEE_PAR,CODEMUSEE,NIVEAU_VISA,IDENTIFIANT_NATIONAL) VALUES ('".$auteur."',%s,'".$_POST['FICHE_CREEE_PAR']."','".$_POST['CODEMUSEE']."','".$_POST['NIVEAU_VISA']."','".$IDENTIFIANT_national."')",GetSQLValueString($date, "date"));
										mysql_select_db($database_alienorweblibre, $alienorweblibre);
										$Result1 = mysql_query($insertSQL, $alienorweblibre) or die(mysql_error());
										// Fin création fiche
										
										// Recherche de l'id de la personne créée
										mysql_select_db($database_alienorweblibre, $alienorweblibre);
										$query_personne = "SELECT INDEX_PERSONNE FROM personne WHERE ETAT_CIVIL= '".$auteur."'";
										$personne = mysql_query($query_personne, $alienorweblibre) or die(mysql_error());
										$row_personne = mysql_fetch_assoc($personne);
										$totalRows_auteur = mysql_num_rows($personne);			
										do {
											$auteur_trouve = intval($row_personne['INDEX_PERSONNE']);
										} while ($row_personne = mysql_fetch_assoc($personne));
										$auteur_liaison_fin[$i] = $auteur_trouve;
										// Fin de recherche de l'id de la personne créée
												
										// Début liaison de la fiche personne avec la fiche objet
										$insertSQL = sprintf("INSERT INTO doc_per (INDEX_DOCUMENTATION,INDEX_PERSONNE,QUALIFIANT) VALUES (".$noFiche.",".$auteur_trouve.",'".$key."')");
										mysql_select_db($database_alienorweblibre, $alienorweblibre);
										$Result1 = mysql_query($insertSQL, $alienorweblibre) or die(mysql_error());
										// Fin liaison de la fiche auteur avec la fiche objet
										
									} else {
									
										// Recherche si liaison existante
										mysql_select_db($database_alienorweblibre, $alienorweblibre);
										$query_liaison = "SELECT INDEX_DOC_PER FROM doc_per WHERE INDEX_PERSONNE = ".$auteur_trouve." AND INDEX_DOCUMENTATION = ".$noFiche." AND QUALIFIANT = '".$key."'";
										$liaison = mysql_query($query_liaison, $alienorweblibre) or die(mysql_error());
										$row_liaison = mysql_fetch_assoc($liaison);
										$totalRows_liaison = mysql_num_rows($liaison);
										do {
											$index_liaison = $row_liaison['INDEX_DOC_PER'];
										} while ($row_liaison = mysql_fetch_assoc($liaison));	
										// fin de recherche
										
										if ($index_liaison == "" && $val != "") {
											// Début liaison de la fiche personne avec la fiche objet
											$insertSQL = sprintf("INSERT INTO doc_per (INDEX_DOCUMENTATION,INDEX_PERSONNE,QUALIFIANT) VALUES (".$noFiche.",".$auteur_trouve.",'".$key."')");
											mysql_select_db($database_alienorweblibre, $alienorweblibre);
											$Result1 = mysql_query($insertSQL, $alienorweblibre) or die(mysql_error());
											// Fin liaison de la fiche personne avec la fiche objet
										}
									// fin de création et affectation de la personne
									}	
								}
								$difference = array_diff($auteur_liaison_debut,$auteur_liaison_fin);
								while (list($keya,$vala) = each($difference)) {	
									if ($vala != 0) {					
										$deleteSQL = sprintf("DELETE FROM doc_per WHERE INDEX_PERSONNE=".intval($vala)." AND INDEX_DOCUMENTATION = ".$noFiche." AND QUALIFIANT = '".$key."'");
										mysql_select_db($database_alienorweblibre, $alienorweblibre);
										$Result1 = mysql_query($deleteSQL, $alienorweblibre) or die(mysql_error());
									}
								}
								// ----------------- Fin de traitement des personnes -----------------
							} else {
								// ----------------- Début de traitement des champs lieux -----------------
								if ($key == 'LIEU_EDITION' || $key == 'LIEU_PRISE_VUE') {
									// Recherche des lieux
									mysql_select_db($database_alienorweblibre, $alienorweblibre);
									$query_liaison_debut = "SELECT INDEX_LIEU FROM doc_lie WHERE QUALIFIANT = '".$key."' AND INDEX_DOCUMENTATION = ".$noFiche;
									$liaison_debut = mysql_query($query_liaison_debut, $alienorweblibre) or die(mysql_error());
									$row_liaison_debut = mysql_fetch_assoc($liaison_debut);
									$totalRows_liaison_debut = mysql_num_rows($liaison_debut);
									$execution_liaison_debut = array();
									$i = 0;
									do {
										$execution_liaison_debut[$i] = $row_liaison_debut['INDEX_LIEU'];
										$i++;
									} while ($row_liaison_debut = mysql_fetch_assoc($liaison_debut));
									$execution_liaison_fin = array();
									// fin de recherche des lieux
									
									// Création, affectation, et liaison de la lieu		
									$tableau = split("/",$val);
										
									for ($i=0; $i < count($tableau); $i++) {
										$lieu_exe = $tableau[$i];	
										// Recherche si la lieu existe déjà
										mysql_select_db($database_alienorweblibre, $alienorweblibre);
										$query_lieu = "SELECT INDEX_LIEU FROM lieu WHERE SITE= '".$lieu_exe."'";
										$lieu = mysql_query($query_lieu, $alienorweblibre) or die(mysql_error());
										$row_lieu = mysql_fetch_assoc($lieu);
										$totalRows_lieu_exe = mysql_num_rows($lieu);			
										do {
											$lieu_exe_trouve = intval($row_lieu['INDEX_LIEU']);
										} while ($row_lieu = mysql_fetch_assoc($lieu));	
										$execution_liaison_fin[$i] = $lieu_exe_trouve;
										// fin de recherche
										
										// Si lieu_exe non existant, la fiche est créée			
										if ($lieu_exe_trouve == "" && $val != "") {
											// Début création de fiche lieu
											$IDENTIFIANT_national = ident_nat("lieux");
											$insertSQL = sprintf("INSERT INTO lieu (SITE,FICHE_CREEE_LE,FICHE_CREEE_PAR,CODEMUSEE,NIVEAU_VISA,IDENTIFIANT_NATIONAL) VALUES ('".$lieu_exe."',%s,'".$_POST['FICHE_CREEE_PAR']."','".$_POST['CODEMUSEE']."','".$_POST['NIVEAU_VISA']."','".$IDENTIFIANT_national."')",GetSQLValueString($date, "date"));
											mysql_select_db($database_alienorweblibre, $alienorweblibre);
											$Result1 = mysql_query($insertSQL, $alienorweblibre) or die(mysql_error());
											// fin création fiche lieu
											
											// Recherche de l'id du lieu créé
											mysql_select_db($database_alienorweblibre, $alienorweblibre);
											$query_lieu = "SELECT INDEX_LIEU FROM lieu WHERE SITE = '".$lieu_exe."'";
											$lieu = mysql_query($query_lieu, $alienorweblibre) or die(mysql_error());
											$row_lieu = mysql_fetch_assoc($lieu);
											$totalRows_lieu_exe = mysql_num_rows($lieu);			
											do {
												$lieu_exe_trouve = intval($row_lieu['INDEX_LIEU']);
											} while ($row_lieu = mysql_fetch_assoc($lieu));
											$execution_liaison_fin[$i] = $lieu_exe_trouve;
											// fin de recherche de l'id lieu_exe créée	
													
											// Début liaison de la fiche lieu avec la fiche objet
											$insertSQL = sprintf("INSERT INTO doc_lie (INDEX_DOCUMENTATION,INDEX_LIEU,QUALIFIANT) VALUES (".$noFiche.",".$lieu_exe_trouve.",'".$key."')");
											mysql_select_db($database_alienorweblibre, $alienorweblibre);
											$Result1 = mysql_query($insertSQL, $alienorweblibre) or die(mysql_error());
											// Fin liaison de la fiche lieu avec la fiche objet
										} else {
											
											// Recherche si liaison existante
											mysql_select_db($database_alienorweblibre, $alienorweblibre);
											$query_liaison = "SELECT INDEX_DOC_LIE FROM doc_lie WHERE INDEX_LIEU = ".$lieu_exe_trouve." AND INDEX_DOCUMENTATION = ".$noFiche." AND QUALIFIANT = '".$key."'";
											$liaison = mysql_query($query_liaison, $alienorweblibre) or die(mysql_error());
											$row_liaison = mysql_fetch_assoc($liaison);
											$totalRows_liaison = mysql_num_rows($liaison);
											do {
												$index_liaison = intval($row_liaison['INDEX_DOC_LIE']);
											} while ($row_liaison = mysql_fetch_assoc($liaison));	
											// fin de recherche de la liaison
											
											if ($index_liaison == "" && $val != "") {
												// Début liaison de la fiche lieu avec la fiche objet
												$insertSQL = sprintf("INSERT INTO doc_lie (INDEX_DOCUMENTATION,INDEX_LIEU,QUALIFIANT) VALUES (".$noFiche.",".$lieu_exe_trouve.",'".$key."')",
												GetSQLValueString($_POST['INDEX_DOCUMENTATION'], "num"));
												mysql_select_db($database_alienorweblibre, $alienorweblibre);
												$Result1 = mysql_query($insertSQL, $alienorweblibre) or die(mysql_error());
												// Fin liaison de la fiche lieu avec la fiche objet
											}
										}
									}
									$difference = array_diff($execution_liaison_debut,$execution_liaison_fin);
									while (list($keyb,$valb)=each($difference)) {
										if ($valb != 0) {
											$deleteSQL = sprintf("DELETE FROM doc_lie WHERE INDEX_LIEU = ".intval($valb)." AND INDEX_DOCUMENTATION = ".$noFiche." AND QUALIFIANT = '".$key."'");
											mysql_select_db($database_alienorweblibre, $alienorweblibre);
											$Result1 = mysql_query($deleteSQL, $alienorweblibre) or die(mysql_error());
										}
									}	
								// ----------------- Fin traitement des champs lieux -----------------
								} else {	
									// ----------------- traitement des champs documentations -----------------
									if ($requete == "") {
										if ($key != 'INDEX_DOCUMENTATION'){$requete = $requete." ".$key." = '".$val."'";};
									} else {
									// ----------------- si la valeur est une date la convertir -----------------
										if (ereg("([0-9]{2}).([0-9]{2}).([0-9]{4})", $val)) {
											$val = preg_replace('/^(.{2}).(.{2}).(.{4})$/','$3-$2-$1', $val);
										}
									// ---------------------------------------------------------------------------
										if ($key != "EFFACER" ) {$requete = $requete.", ".$key." = '".$val."'";};
										
									}
								}
							}
						}	
					}//personne
				}//image
			}//$key == 'nouv_image'
		}//fichier
		}
		// Reqêtes des mise à jour de la fiche
		$val = date('Y.m.d');
		$key = "MISE_A_JOUR";
		$requete = preg_replace('#(\'\')#','NULL', $requete);
		$updateSQL = sprintf("UPDATE documentation SET ".$requete." WHERE INDEX_DOCUMENTATION = ".$noFiche);
		//echo("<br>Mise à jour de la fiche objet = <br>".$updateSQL."<br>");
							   
		mysql_select_db($database_alienorweblibre, $alienorweblibre);
		$Result1 = mysql_query($updateSQL, $alienorweblibre) or die(mysql_error());
	
	// Fin mise à jour de la fiche
	
	// Redirection vers l'affichage de la page modifiée ou vers la page de gestion si nouvelle fiche
	
	redirection($creation,$noFiche,$doublon,$page,$isobjet);
	}
}
?>