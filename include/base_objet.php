<?php
	include('fonctions.php');
	include('securite.php');
	$date= date("Y.m.d");
	(isset($_GET['noFiche']) && $_GET['noFiche'] != 0) ? $noFiche = $_GET['noFiche']  : $noFiche = 0 ;

// ----------------- Détection pour duplication -----------------
	(isset($_GET['duplication']) && $_GET['duplication'] != 0) ? $duplication = $_GET['duplication']  : $duplication = 0 ;
// --------------------------------------------------------------		
	
	$creation = 0;
	$doublon = 0;	
	require_once('../Connections/alienorweblibre.php');
	// pour les fiches gestions du borderaux d'inventaire récolment
	if ($page == "inventaire-recolement"){
		$etatCommentaires ="";
		$emplacementCommentaires = "";
		$valeurCommentaires = "";
		$valEtat ="";
		$valEmplacement="";
		$valValeur ="";
		if(isset($_POST['RECOLEMENT'])){
		if ($_POST['RECOLEMENT'] == "" && isset($_POST['EMPLACEMENT'])) {
			echo '<p> Lors d\'un récolement vous devez impérativement préciser si l\'objet a été localisé ou non (il peut aussi être détruit).</p><p>Vous avez oubliez de confirmer ce récolement.<p><p><b> il vous faut donc resaisir votre bordereau</b><p><p><a href="#" onclick="window.history.go(-1)">Retour</a></p>';
			exit;
		}
		}
	}
	

// Début affichage de tous les champs de la fiche
	mysql_select_db($database_alienorweblibre, $alienorweblibre);
	$query_rech_objet = "SELECT * FROM objet WHERE INDEX_OBJET = ".$noFiche;
	$rech_objet = mysql_query($query_rech_objet, $alienorweblibre) or die(mysql_error());
	$row_rech_objet = mysql_fetch_assoc($rech_objet);
	$totalRows_rech_objet = mysql_num_rows($rech_objet);	
// Fin affichage de tous les champs de la fiche



$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == 'objets')) {

	$noFiche = intval($_POST['INDEX_OBJET']);
	$totalRows_rech_doublon = 0;
	$requete = "";	
	if ($_POST['NUMERO_INVENTAIRE'] != $_POST['NUMERO_INVENTAIRE_INIT']) {	
		// Recherche si doubon de numéro d'inventaire sur un même musée
		mysql_select_db($database_alienorweblibre, $alienorweblibre);
		$query_rech_doublon = "SELECT * FROM objet WHERE NUMERO_INVENTAIRE = '".$_POST['NUMERO_INVENTAIRE']."'";
		$rech_doublon = mysql_query($query_rech_doublon, $alienorweblibre) or die(mysql_error());
		$row_rech_doublon = mysql_fetch_assoc($rech_doublon);
		$totalRows_rech_doublon = mysql_num_rows($rech_doublon);
		// echo("Nb résultat = ".$totalRows_rech_objet."<br>");
	}
	
	if ($totalRows_rech_doublon != 0) {
		$msg = "Ce numéro d'inventaire existe déjà";
		$doublon = 1;	
		
	} else {
		if ($noFiche == 0 && $_POST['NUMERO_INVENTAIRE'] != '') {
			// Début création de fiche */
			$IDENTIFIANT_national = ident_nat("objets");
			$insertSQL = sprintf("INSERT INTO objet (NUMERO_INVENTAIRE,FICHE_CREEE_LE,IDENTIFIANT_NATIONAL) VALUES (%s,%s,%s)",
								GetSQLValueString($_POST['NUMERO_INVENTAIRE'], "text"),
								GetSQLValueString($date, "date"),
								GetSQLValueString($IDENTIFIANT_national, "text"));
			mysql_select_db($database_alienorweblibre, $alienorweblibre);
			$Result1 = mysql_query($insertSQL, $alienorweblibre) or die(mysql_error());
			$creation = 1;
			// fin création fiches
			// Récuperation du numéro de la fiche créée
			mysql_select_db($database_alienorweblibre, $alienorweblibre);
			$query_objets = "SELECT INDEX_OBJET FROM objet WHERE NUMERO_INVENTAIRE = '".$_POST['NUMERO_INVENTAIRE']."'";
			$objets = mysql_query($query_objets, $alienorweblibre) or die(mysql_error());
			$row_objets = mysql_fetch_assoc($objets);
			$totalRows_objets = mysql_num_rows($objets);
			do {
				$noFiche = intval($row_objets['INDEX_OBJET']);
			} while ($row_objets = mysql_fetch_assoc($objets));
			$_POST['IDENTIFIANT_NATIONAL'] = $IDENTIFIANT_national;
			// Fin de récupération de la fiche créée */
		}
		
		// ----------------- Construction dynamique de la requête de mise à jour -----------------
		
		foreach($_POST as $key=>$val) {
			//echo("<b>Rubrique =</b> ".$key." <b>Valeur =</b> ".$val."<br>");
			$val = trim($val);
			$val = addslashes($val);
				if ($key != 'valider_x' && $key != 'valider_y' && $key != 'MM_update' && $key != 'NUMERO_INVENTAIRE_INIT' && $key != 'Submit' && $key != 'PHOTOGRAPHE' && $key != 'TXT_DATE_PRISE_VUE' && $key != 'DEB_DATE_PRISE_VUE' && $key != 'FIN_DATE_PRISE_VUE' && $key != 'DATE_RECOLEMENT' && $key != 'FICHIER' && $key != 'MAX_FILE_SIZE' && $key != 'image_x' && $key != 'image_y') {
			// Séparation des valeurs
			$tableau = explode("/",$val);
				for ($i=0; $i < count($tableau); $i++) {
				$tableau[$i] = addslashes($tableau[$i]);
				 
					// ----------------- Début de traitement des personnes -----------------
					if ($key == 'AUTEUR' || $key == 'UTILISATEUR' || $key == 'COLLECTEUR' || $key == 'INVENTEUR' || $key == 'PROPRIETAIRE' || $key == 'DESCRIPTEUR' || $key == 'COMMISSAIRE_PRISEUR' || $key == 'GALERIE' || $key == 'DEPOSITAIRE' || $key == 'ATTRIBUTION' || $key == 'ATTRIBUTEUR' || $key == 'SERVICE_GESTIONNAIRE' || $key == 'ANCIENNE_APPARTENANCE' || $key == 'SERVICE_GESTIONNAIRE' || $key == 'ANCIEN_DEPOSITAIRE' || $key == 'DETERMINATEUR') {
						// Recherche des personnes
						mysql_select_db($database_alienorweblibre, $alienorweblibre);
						$query_liaison_debut = "SELECT INDEX_PERSONNE FROM obj_per WHERE INDEX_OBJET = ".$noFiche." AND QUALIFIANT = '".$key."'";
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
								//echo $insertSQL."<br>";
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
								$insertSQL = sprintf("INSERT INTO obj_per (INDEX_OBJET,INDEX_PERSONNE,QUALIFIANT) VALUES (".$noFiche.",".$auteur_trouve.",'".$key."')");
								mysql_select_db($database_alienorweblibre, $alienorweblibre);
								$Result1 = mysql_query($insertSQL, $alienorweblibre) or die(mysql_error());
								// Fin liaison de la fiche auteur avec la fiche objet
								
							} else {
								// Recherche si liaison existante
								mysql_select_db($database_alienorweblibre, $alienorweblibre);
								$query_liaison = "SELECT INDEX_OBJ_PER FROM obj_per WHERE INDEX_PERSONNE = ".$auteur_trouve." AND INDEX_OBJET = ".$noFiche." AND QUALIFIANT = '".$key."'";
								$liaison = mysql_query($query_liaison, $alienorweblibre) or die(mysql_error());
								$row_liaison = mysql_fetch_assoc($liaison);
								$totalRows_liaison = mysql_num_rows($liaison);
								do {
									$index_liaison = $row_liaison['INDEX_OBJ_PER'];
								} while ($row_liaison = mysql_fetch_assoc($liaison));	
								// fin de recherche
								
								if ($index_liaison == "" &&$val != "") {
									// Début liaison de la fiche personne avec la fiche objet
									$insertSQL = sprintf("INSERT INTO obj_per (INDEX_OBJET,INDEX_PERSONNE,QUALIFIANT) VALUES (".$noFiche.",".$auteur_trouve.",'".$key."')");
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
								$deleteSQL = sprintf("DELETE FROM obj_per WHERE INDEX_PERSONNE=".intval($vala)." AND INDEX_OBJET = ".$noFiche." AND QUALIFIANT = '".$key."'");
								mysql_select_db($database_alienorweblibre, $alienorweblibre);
								$Result1 = mysql_query($deleteSQL, $alienorweblibre) or die(mysql_error());
							}
						}
						// ----------------- Fin de traitement des personnes -----------------
					} else {
						// ----------------- Début de traitement des champs lieux -----------------
						if ($key == 'LIEUX_DECOUVERTE' || $key == 'LIEUX_EXECUTION' || $key == 'LIEUX_UTILISATION') {
							// Recherche des lieux
							mysql_select_db($database_alienorweblibre, $alienorweblibre);
							$query_liaison_debut = "SELECT INDEX_LIEU FROM obj_lie WHERE QUALIFIANT = '".$key."' AND INDEX_OBJET = ".$noFiche."";
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
								if ($lieu_exe_trouve == "" && $val!="") {
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
									$insertSQL = sprintf("INSERT INTO obj_lie (INDEX_OBJET,INDEX_LIEU,QUALIFIANT) VALUES (".$noFiche.",".$lieu_exe_trouve.",'".$key."')");
									mysql_select_db($database_alienorweblibre, $alienorweblibre);
									$Result1 = mysql_query($insertSQL, $alienorweblibre) or die(mysql_error());
									// Fin liaison de la fiche lieu avec la fiche objet
								} else {
									
									// Recherche si liaison existante
									mysql_select_db($database_alienorweblibre, $alienorweblibre);
									$query_liaison = "SELECT INDEX_OBJ_LIE FROM obj_lie WHERE INDEX_LIEU = ".$lieu_exe_trouve." AND INDEX_OBJET = ".$noFiche." AND QUALIFIANT = '".$key."'";
									$liaison = mysql_query($query_liaison, $alienorweblibre) or die(mysql_error());
									$row_liaison = mysql_fetch_assoc($liaison);
									$totalRows_liaison = mysql_num_rows($liaison);
									do {
										$index_liaison = intval($row_liaison['INDEX_OBJ_LIE']);
									} while ($row_liaison = mysql_fetch_assoc($liaison));	
									// fin de recherche de la liaison
									
									if ($index_liaison == "" && $val != "") {
										// Début liaison de la fiche lieu avec la fiche objet
										$insertSQL = sprintf("INSERT INTO obj_lie (INDEX_OBJET,INDEX_LIEU,QUALIFIANT) VALUES (".$noFiche.",".$lieu_exe_trouve.",'".$key."')",
										GetSQLValueString($_POST['INDEX_OBJET'], "num"));
										mysql_select_db($database_alienorweblibre, $alienorweblibre);
										$Result1 = mysql_query($insertSQL, $alienorweblibre) or die(mysql_error());
										// Fin liaison de la fiche lieu avec la fiche objet
									}
								}
							}
							$difference = array_diff($execution_liaison_debut,$execution_liaison_fin);
							while (list($keyb,$valb)=each($difference)) {
								if ($valb != 0) {
									$deleteSQL = sprintf("DELETE FROM obj_lie WHERE INDEX_LIEU = ".intval($valb)." AND INDEX_OBJET = ".$noFiche." AND QUALIFIANT = '".$key."'");
									mysql_select_db($database_alienorweblibre, $alienorweblibre);
									$Result1 = mysql_query($deleteSQL, $alienorweblibre) or die(mysql_error());
								}
							}	
						// ----------------- Fin traitement des champs lieux -----------------
						} else {
							// ----------------- traitement des champs documentation -----------------
							if ($key == 'BIBLIOGRAPHIE' || $key == 'PHOTOGRAPHIE' || $key == 'EXPOSITION' || $key == 'CEDEROM' || $key == 'INTERNET' || $key == 'TAPUSCRIT' || $key == 'MANUSCRIT' || $key == 'VIDEO' || $key == 'REPRODUCTION') {
								// Recherche de documentation
								mysql_select_db($database_alienorweblibre, $alienorweblibre);
								$query_liaison_debut = "SELECT INDEX_DOCUMENTATION FROM obj_doc WHERE QUALIFIANT = '".$key."' AND INDEX_OBJET = ".$noFiche."";
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
								
								// Création ou liaison de la documentation avec la fiche objet
								$tableau = split("/",$val);
								
								for ($i=0; $i < count($tableau); $i++) {
								//print_r($tableau[$i]);echo "<br>";
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
									if ($docum_exe_trouve == "" && $val != "" ) {
										// Début création de fiche documentation
										$IDENTIFIANT_national = ident_nat("documentations");
										if (isset($_POST['TXT_DATE_PRISE_VUE'])){
											$tmp = integreImage($_FILES['nouv_image'],"","");
											//echo"<br>tmp1 :".$tmp[1];
											if ($tmp[0]	!= "") {
												$msg .= $tmp[0];
												$doublon = 1;
											}else{
												$fichier = $tmp[1];
												//echo "<br>fichier : ".$fichier;
											}
											$insertSQL = sprintf("INSERT INTO documentation (IDENTIFIANT,FICHE_CREEE_LE,FICHE_CREEE_PAR,CODEMUSEE,NIVEAU_VISA,IDENTIFIANT_NATIONAL,TXT_DATE_PRISE_VUE,DEB_DATE_PRISE_VUE,FIN_DATE_PRISE_VUE,TYPE_DOCUMENT,FICHIER) VALUES ('".$docum_exe."','".$_POST['FICHE_CREEE_LE']."','".$_POST['FICHE_CREEE_PAR']."','".$_POST['CODEMUSEE']."','".$_POST['NIVEAU_VISA']."','".$IDENTIFIANT_national."','".$_POST['TXT_DATE_PRISE_VUE']."','".preg_replace('/^(.{2}).(.{2}).(.{4})$/','$3-$2-$1',$_POST['DEB_DATE_PRISE_VUE'])."','".preg_replace('/^(.{2}).(.{2}).(.{4})$/','$3-$2-$1',$_POST['FIN_DATE_PRISE_VUE'])."','photgraphie','".$fichier."')");
										}else{
										$insertSQL = sprintf("INSERT INTO documentation (IDENTIFIANT,FICHE_CREEE_LE,FICHE_CREEE_PAR,CODEMUSEE,NIVEAU_VISA,IDENTIFIANT_NATIONAL) VALUES ('".$docum_exe."',%s,'".$_POST['FICHE_CREEE_PAR']."','".$_POST['CODEMUSEE']."','".$_POST['NIVEAU_VISA']."','".$IDENTIFIANT_national."')",GetSQLValueString($date, "date"));
										}
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
												
										// Début liaison de la fiche documentation avec la fiche objet
										$insertSQL = sprintf("INSERT INTO obj_doc (INDEX_OBJET,INDEX_DOCUMENTATION,QUALIFIANT) VALUES (".$noFiche.",".$docum_exe_trouve.",'".$key."')");
										mysql_select_db($database_alienorweblibre, $alienorweblibre);
										$Result1 = mysql_query($insertSQL, $alienorweblibre) or die(mysql_error());
										// Fin liaison de la fiche documentation avec la fiche objet
									} else {								
										// Recherche si liaison existante
										mysql_select_db($database_alienorweblibre, $alienorweblibre);
										$query_liaison = "SELECT INDEX_OBJ_DOC FROM obj_doc WHERE INDEX_DOCUMENTATION = ".$docum_exe_trouve." AND INDEX_OBJET = ".$noFiche." AND QUALIFIANT = '".$key."'";
										$liaison = mysql_query($query_liaison, $alienorweblibre) or die(mysql_error());
										$row_liaison = mysql_fetch_assoc($liaison);
										$totalRows_liaison = mysql_num_rows($liaison);
										do {
											$index_liaison = $row_liaison['INDEX_OBJ_DOC'];
										} while ($row_liaison = mysql_fetch_assoc($liaison));	
										// Fin de recherche
										
										if ($index_liaison == "" && $val != "") {
											// Début liaison de la fiche documentation avec la fiche objet
											$insertSQL = sprintf("INSERT INTO obj_doc (INDEX_OBJET,INDEX_DOCUMENTATION,QUALIFIANT) VALUES (".$noFiche.",".$docum_exe_trouve.",'".$key."')");
											mysql_select_db($database_alienorweblibre, $alienorweblibre);
											$Result1 = mysql_query($insertSQL, $alienorweblibre) or die(mysql_error());
											// Fin liaison de la fiche documentation avec la fiche objet
										}
									}
								}
								if ( $page != 'inventaire-recolement'){
									$difference = array_diff($execution_liaison_debut,$execution_liaison_fin);
									while (list($keyc,$valc)=each($difference)) {
										if ($valc != 0) {
											$deleteSQL = sprintf("DELETE FROM obj_doc WHERE INDEX_DOCUMENTATION=".intval($valc)." AND INDEX_OBJET=".$noFiche." AND QUALIFIANT = '".$key."'");
											mysql_select_db($database_alienorweblibre, $alienorweblibre);
											$Result1 = mysql_query($deleteSQL, $alienorweblibre) or die(mysql_error());
										}
									}
								} //	$page != 'inventaire-recolement'
								//-----------------------------------------------------------------------------------------
								//                          Autres tables lié au récolement
								//-----------------------------------------------------------------------------------------
								if (isset($_POST['PHOTOGRAPHE']) && $_POST['PHOTOGRAPHE'] != "") {
											// Recherche si l'auteur existe déjà
											mysql_select_db($database_alienorweblibre, $alienorweblibre);
											$query_personne = "SELECT INDEX_PERSONNE FROM personne WHERE ETAT_CIVIL = '".$_POST['PHOTOGRAPHE']."'";
											$personne = mysql_query($query_personne, $alienorweblibre) or die(mysql_error());
											$row_personne = mysql_fetch_assoc($personne);
											$totalRows_auteur = mysql_num_rows($personne);
											do {
												$auteur_trouve = intval($row_personne['INDEX_PERSONNE']);
											} while ($row_personne = mysql_fetch_assoc($personne));	
											$auteur_liaison_fin[$i] = $auteur_trouve;
											// fin de la recherche
											
											// Si personne non existante, la fiche est créée
											if ($auteur_trouve == "" && $_POST['PHOTOGRAPHE'] != "") {
											
												// Création de fiche personne
												$IDENTIFIANT_national = ident_nat("personnes");
												$insertSQL = sprintf("INSERT INTO personne (ETAT_CIVIL,FICHE_CREEE_LE,FICHE_CREEE_PAR,CODEMUSEE,NIVEAU_VISA,IDENTIFIANT_NATIONAL) VALUES ('".$_POST['PHOTOGRAPHE']."','".date('Y-m-d')."','".$_POST['FICHE_CREEE_PAR']."','".$_POST['CODEMUSEE']."','".$_POST['NIVEAU_VISA']."','".$IDENTIFIANT_national."')");
												mysql_select_db($database_alienorweblibre, $alienorweblibre);
												$Result1 = mysql_query($insertSQL, $alienorweblibre) or die(mysql_error());
												// Fin création fiche
												
												// Recherche de l'id de la personne créée
												mysql_select_db($database_alienorweblibre, $alienorweblibre);
												$query_personne = "SELECT INDEX_PERSONNE FROM personne WHERE ETAT_CIVIL= '".$_POST['PHOTOGRAPHE']."'";
												$personne = mysql_query($query_personne, $alienorweblibre) or die(mysql_error());
												$row_personne = mysql_fetch_assoc($personne);
												$totalRows_auteur = mysql_num_rows($personne);
												do {
													$auteur_trouve = intval($row_personne['INDEX_PERSONNE']);
												} while ($row_personne = mysql_fetch_assoc($personne));
												$auteur_liaison_fin[$i] = $auteur_trouve;
												// Fin de recherche de l'id de la personne créée
												
												// Début liaison de la fiche personne avec la fiche doc
												$insertSQL = sprintf("INSERT INTO doc_per (INDEX_DOCUMENTATION,INDEX_PERSONNE,QUALIFIANT) VALUES (".$docum_exe_trouve.",".(int)$auteur_trouve.",'PHOTOGRAPHE')");
												mysql_select_db($database_alienorweblibre, $alienorweblibre);
												$Result1 = mysql_query($insertSQL, $alienorweblibre) or die(mysql_error());
												// Fin liaison de la fiche auteur avec la fiche doc
											} else {
												// Recherche si liaison existante
												mysql_select_db($database_alienorweblibre, $alienorweblibre);
												$query_liaison = "SELECT INDEX_DOC_PER FROM doc_per WHERE INDEX_PERSONNE = ".$auteur_trouve." AND INDEX_DOCUMENTATION = ".$docum_exe_trouve." AND QUALIFIANT = 'PHOTOGRAPHE'";
												// echo "\$query_liaison = ".$query_liaison."<br>\n";
												$liaison = mysql_query($query_liaison, $alienorweblibre) or die(mysql_error());
												$row_liaison = mysql_fetch_assoc($liaison);
												$totalRows_liaison = mysql_num_rows($liaison);
												do {
													$index_liaison = $row_liaison['INDEX_OBJ_DOC'];
												} while ($row_liaison = mysql_fetch_assoc($liaison));
												// fin de recherche
												
												if ($index_liaison == "" &&$val != "") {
													// Début liaison de la fiche personne avec la fiche objet
													$insertSQL = sprintf("INSERT INTO doc_per (INDEX_DOCUMENTATION,INDEX_PERSONNE,QUALIFIANT) VALUES (".$docum_exe_trouve.",".$auteur_trouve.",'PHOTOGRAPHE')");
													mysql_select_db($database_alienorweblibre, $alienorweblibre);
													$Result1 = mysql_query($insertSQL, $alienorweblibre) or die(mysql_error());
													// Fin liaison de la fiche personne avec la fiche objet
												}
											// fin de création et affectation de la personne
											}
										}
								} else { 
									// ********* Partie ajout de la gestion ****************
									if ($key == 'ETAT' || $key == 'MARQUAGE_CONSTATE' || $key == 'MARQUAGE_EFFECTUE' || $key == 'CONDITIONNEMENT' || $key == 'CONTENANT' ||  $key == 'ACTIONS' ||$key == 'RECOLEMENT' || $key == 'VALEUR' || $key == 'EMPLACEMENT' || $key == 'EXPERT') {
										if ($val != "") {
											// Suivant les cas
											switch ($key) {
												case "ETAT":
													if (is_array($_POST['ETAT'])) {
														foreach($_POST['ETAT'] as $value) {
															$etat .= $value."/";
														}
														$etat = substr(trim($etat),0,strlen($etat)-1);
													}
													break;
												case "MARQUAGE_CONSTATE":
													$etatCommentaires .= "Marquage constaté : ".$val.". ";
													break;
												case "CONDITIONNEMENT":
													$etatCommentaires .= "Conditionnement : ".$val.". ";
													break;
												case "CONTENANT":
													$etatCommentaires .= "Contenant : ";
													if (is_array($_POST['CONTENANT'])) {
														foreach($_POST['CONTENANT'] as $value) {
															$etatCommentaires .= $value.", ";
														}
														$etatCommentaires = substr(trim($etatCommentaires),0,strlen($etatCommentaires)-1);
													}
													$etatCommentaires .= ". ";
													break;
												case "RECOLEMENT":
													$emplacementCommentaires .= "Objet ".$val.". ";
													break;
												case "MARQUAGE_EFFECTUE":
													$etatCommentaires .= "Marquage éffectué : ".$val.". ";
													break;
												case "ACTIONS":
													$etatCommentaires .= "Action effectuées : ";
													if (is_array($_POST['ACTIONS'])) {
														foreach($_POST['ACTIONS'] as $value) {
															$etatCommentaires .= $value.", ";
														}
														$etatCommentaires = substr(trim($etatCommentaires),0,strlen($etatCommentaires)-1);
													}
													$etatCommentaires .= ". ";
													break;
											}
										}
									//-------------------------------------------------------------------------------------------
									//                 fin du traitement des autres tables liés au récolment
									//-------------------------------------------------------------------------------------------
							} else {	
								// ----------------- traitement des champs objets -----------------
								if ($requete == "") {
									if ($key != 'INDEX_OBJET'){$requete = $requete." ".$key." = '".$val."'";};
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
		}
	}
		// Reqêtes des mise à jour de la fiche
		$val = date('Y.m.d');
		$key = "MISE_A_JOUR";
		$requete = $requete.", ".$key." = '".$val."'";
		$requete = preg_replace('#(\'\')#','NULL', $requete);
		$updateSQL = sprintf("UPDATE objet SET ".$requete." WHERE INDEX_OBJET = ".$noFiche);
		//echo("Mise à jour de la fiche objet = ".$updateSQL."<br>");
		mysql_select_db($database_alienorweblibre, $alienorweblibre);
		$Result1 = mysql_query($updateSQL, $alienorweblibre) or die(mysql_error());
	// Fin mise à jour de la fiche

	// S'il s'agit du bordereau d'inventaire récolment alors fair les fiches gestions
	if ($page == "inventaire-recolement"){
		$user = $_SESSION["prenom"]." ".$_SESSION["nom"];
		$dateRecolement = preg_replace('/^(.{2}).(.{2}).(.{4})$/','$3-$2-$1', $_POST['DATE_RECOLEMENT']);
		// Début création de fiche de gestion Etat
		if ($etat != ""){
			$insertSQL = sprintf("INSERT INTO gestion (ETAT_CONSERVATION,EXPERT,DATE_CONSERVATION,COMMENTAIRES,FICHE_CREEE_PAR,FICHE_CREEE_LE,CODEMUSEE) VALUES (%s,%s,%s,%s,%s,%s,%s)",
				GetSQLValueString($etat, "text"),
				GetSQLValueString($_POST['EXPERT'], "text"),
				GetSQLValueString($dateRecolement, "date"),
				GetSQLValueString($etatCommentaires, "text"),
				GetSQLValueString($user, "text"),
				GetSQLValueString(date('Y-m-d'), "date"),
				GetSQLValueString($_POST['CODEMUSEE'], "text")
				);
			mysql_select_db($database_alienorweblibre, $alienorweblibre);
			//echo ("<br>\$insertSQL = ".$insertSQL."<br>\n");
			$Result = mysql_query($insertSQL, $alienorweblibre) or die(mysql_error());
			// fin création fiches Etat
			
			// Récuperation du numéro de la fiche créée
			mysql_select_db($database_alienorweblibre, $alienorweblibre);
			$query_gestion = "SELECT DISTINCT INDEX_GESTION FROM gestion WHERE DATE_CONSERVATION = '".$dateRecolement."' AND FICHE_CREEE_LE = '".date('Y-m-d')."'";
			//echo ("\$query_gestion = ".$query_gestion."<br>\n");
			$gestion = mysql_query($query_gestion, $alienorweblibre) or die(mysql_error());
			$row_gestion = mysql_fetch_assoc($gestion);
			$totalRows_gestion = mysql_num_rows($gestion);
			
			$noGestion = intval($row_gestion['INDEX_GESTION']);
			
			// Liaison de la table objte avec la table gestion
			$insertSQL = sprintf("INSERT INTO obj_ges (INDEX_OBJET,INDEX_GESTION) VALUES (".intval($_POST['INDEX_OBJET']).",".$noGestion.")");
			$Result = mysql_query($insertSQL, $alienorweblibre) or die(mysql_error());
		}
		
		// Début création de fiche de gestion Emplacement
		if ( $_POST['EMPLACEMENT'] != "") {
			$insertSQL = sprintf("INSERT INTO gestion (EMPLACEMENT,EXPERT,DATE_EMPLACEMENT,COMMENTAIRES,FICHE_CREEE_PAR,FICHE_CREEE_LE,CODEMUSEE) VALUES (%s,%s,%s,%s,%s,%s,%s)",
				GetSQLValueString($_POST['EMPLACEMENT'], "text"),
				GetSQLValueString($_POST['EXPERT'], "text"),
				GetSQLValueString($dateRecolement, "date"),
				GetSQLValueString($emplacementCommentaires, "text"),
				GetSQLValueString($user, "text"),
				GetSQLValueString(date('Y-m-d'), "date"),
				GetSQLValueString($_POST['CODEMUSEE'], "text")
				);
			mysql_select_db($database_alienorweblibre, $alienorweblibre);
			//echo ("<br>\$insertSQL = ".$insertSQL."<br>\n");
			$Result = mysql_query($insertSQL, $alienorweblibre) or die(mysql_error());
			// fin création fiches Emplacement
			
			// Récuperation du numéro de la fiche créée
			mysql_select_db($database_alienorweblibre, $alienorweblibre);
			$query_gestion = "SELECT DISTINCT INDEX_GESTION FROM gestion WHERE DATE_EMPLACEMENT = '".$dateRecolement."' AND FICHE_CREEE_LE = '".date('Y-m-d')."'";
			//echo ("\$query_gestion = ".$query_gestion."<br>\n");
			$gestion = mysql_query($query_gestion, $alienorweblibre) or die(mysql_error());
			$row_gestion = mysql_fetch_assoc($gestion);
			$totalRows_gestion = mysql_num_rows($gestion);
			
			$noGestion = intval($row_gestion['INDEX_GESTION']);
			
			// Liaison de la table objte avec la table gestion
			$insertSQL = sprintf("INSERT INTO obj_ges (INDEX_OBJET,INDEX_GESTION) VALUES (".intval($_POST['INDEX_OBJET']).",".$noGestion.")");
			$Result = mysql_query($insertSQL, $alienorweblibre) or die(mysql_error());
		}
		
				// Début création de fiche de gestion valeur
		if( $_POST['VALEUR'] != "") {
			$insertSQL = sprintf("INSERT INTO gestion (VALEUR,EXPERT,DATE_VALEUR,COMMENTAIRES,FICHE_CREEE_PAR,FICHE_CREEE_LE,CODEMUSEE) VALUES (%s,%s,%s,%s,%s,%s,%s)",
				GetSQLValueString($_POST['VALEUR'], "text"),
				GetSQLValueString($_POST['EXPERT'], "text"),
				GetSQLValueString($dateRecolement, "date"),
				GetSQLValueString($valeurCommentaires, "text"),
				GetSQLValueString($user, "text"),
				GetSQLValueString(date('Y-m-d'), "date"),
				GetSQLValueString($_POST['CODEMUSEE'], "text")
				);
			mysql_select_db($database_alienorweblibre, $alienorweblibre);
			//echo ("<br>\$insertSQL = ".$insertSQL."<br>\n");
			$Result = mysql_query($insertSQL, $alienorweblibre) or die(mysql_error());
			// fin création fiches valeur
			
			// Récuperation du numéro de la fiche créée
			mysql_select_db($database_alienorweblibre, $alienorweblibre);
			$query_gestion = "SELECT DISTINCT INDEX_GESTION FROM gestion WHERE DATE_VALEUR = '".$dateRecolement."' AND FICHE_CREEE_LE = '".date('Y-m-d')."'";
			//echo ("\$query_gestion = ".$query_gestion."<br>\n");
			$gestion = mysql_query($query_gestion, $alienorweblibre) or die(mysql_error());
			$row_gestion = mysql_fetch_assoc($gestion);
			$totalRows_gestion = mysql_num_rows($gestion);
			
			$noGestion = intval($row_gestion['INDEX_GESTION']);
			
			// Liaison de la table objte avec la table gestion
			$insertSQL = sprintf("INSERT INTO obj_ges (INDEX_OBJET,INDEX_GESTION) VALUES (".intval($_POST['INDEX_OBJET']).",".$noGestion.")");
			$Result = mysql_query($insertSQL, $alienorweblibre) or die(mysql_error());
		}
	} // if page == inventaire-recolement
	
	// Redirection vers l'affichage de la page modifiée ou vers la page de gestion si nouvelle fiche
	redirection($creation,$noFiche,$doublon,$page,$isobjet);
	}
}
?>