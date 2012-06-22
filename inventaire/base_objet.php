<?php
	$date= date("Y.m.d");
	(isset($_GET['noFiche']) && $_GET['noFiche'] != 0) ? $noFiche = $_GET['noFiche']  : $noFiche = 0 ;
	
	$creation = 0;
	$doublon = 0;

if (isset($_POST['DATE_RECOLEMENT']) && $_POST['DATE_RECOLEMENT'] == "" )
{
	$msg = "La date de r&eacute;colement ne doit pas &ecirc;tre vide";
} else {

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
			mysql_select_db($database_alienorweb, $alienorweb);
			$query_rech_doublon = "SELECT * FROM objet WHERE NUMERO_INVENTAIRE = '".$_POST['NUMERO_INVENTAIRE']."'";
			$rech_doublon = mysql_query($query_rech_doublon, $alienorweb) or die(mysql_error());
			$row_rech_doublon = mysql_fetch_assoc($rech_doublon);
			$totalRows_rech_doublon = mysql_num_rows($rech_doublon);
			// echo("Nb résultat = ".$totalRows_rech_objet."<br>");
		}
				if ($noFiche == 0 && $_POST['NUMERO_INVENTAIRE'] != '') {
				// Début création de fiche */
				$IDENTIFIANT_national = ident_nat("objets");
				$insertSQL = sprintf("INSERT INTO objet (NUMERO_INVENTAIRE,FICHE_CREEE_LE,IDENTIFIANT_NATIONAL) VALUES (%s,%s,%s)",
									GetSQLValueString($_POST['NUMERO_INVENTAIRE'], "text"),
									GetSQLValueString($date, "date"),
									GetSQLValueString($IDENTIFIANT_national, "text"));
				mysql_select_db($database_alienorweb, $alienorweb);
				$Result1 = mysql_query($insertSQL, $alienorweb) or die(mysql_error());
				$creation = 1;
				// fin création fiches
				 
				// Récuperation du numéro de la fiche créée
				mysql_select_db($database_alienorweb, $alienorweb);
				$query_objets = "SELECT INDEX_OBJET FROM objet WHERE NUMERO_INVENTAIRE = '".$_POST['NUMERO_INVENTAIRE']."'";
				$objets = mysql_query($query_objets, $alienorweb) or die(mysql_error());
				$row_objets = mysql_fetch_assoc($objets);
				$totalRows_objets = mysql_num_rows($objets);
				do {
					$noFiche = intval($row_objets['INDEX_OBJET']);
				} while ($row_objets = mysql_fetch_assoc($objets));
				$noFab = $noFiche;
				$comptage = strlen($noFab);
				for ($i = $comptage; $i < 6; $i++) {
					$noFab = "0".$noFab;
				}
				$_POST['IDENTIFIANT_NATIONAL'] = $_POST['CODEMUSEE'].$noFab;
				// Fin de récupération de la fiche créée */
				}
			
			// ----------------- Construction dynamique de la requête de mise à jour -----------------
			foreach($_POST as $key=>$val) {
				//echo("<b>Rubrique =</b> ".$key." <b>Valeur =</b> ".$val."<br>");
				$val = trim($val);
				if ($key != 'valider_x' && $key != 'valider_y' && $key != 'MM_update' && $key != 'NUMERO_INVENTAIRE_INIT' && $key != 'Submit' && $key != 'PHOTOGRAPHE' && $key != 'TXT_DATE_PRISE_VUE' && $key != 'DEB_DATE_PRISE_VUE' && $key != 'FIN_DATE_PRISE_VUE' && $key != 'DATE_RECOLEMENT' && $key != 'FICHIER' && $key != 'MAX_FILE_SIZE') {
				// Séparation des valeurs
				$tableau = split("/",$val);
					for ($i=0; $i < count($tableau); $i++) {
						// ----------------- Début de traitement des personnes -----------------
						if ($key == 'AUTEUR' || $key == 'UTILISATEUR' || $key == 'COLLECTEUR' || $key == 'INVENTEUR' || $key == 'PROPRIETAIRE' || $key == 'DESCRIPTEUR' || $key == 'COMMISSAIRE_PRISEUR' || $key == 'GALERIE' || $key == 'DEPOSITAIRE' || $key == 'ATTRIBUTION' || $key == 'ATTRIBUTEUR' || $key == 'SERVICE_GESTIONNAIRE' || $key == 'ANCIENNE_APPARTENANCE' || $key == 'SERVICE_GESTIONNAIRE' || $key == 'ANCIEN_DEPOSITAIRE' || $key == 'DETERMINATEUR') {
							// Recherche des personnes
							mysql_select_db($database_alienorweb, $alienorweb);
							$query_liaison_debut = "SELECT INDEX_PERSONNE FROM obj_per WHERE INDEX_OBJET = ".$noFiche." AND QUALIFIANT = '".$key."'";
							$liaison_debut = mysql_query($query_liaison_debut, $alienorweb) or die(mysql_error());
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
								mysql_select_db($database_alienorweb, $alienorweb);
								$query_personne = "SELECT INDEX_PERSONNE FROM personne WHERE ETAT_CIVIL = '".$auteur."'";
								$personne = mysql_query($query_personne, $alienorweb) or die(mysql_error());
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
									mysql_select_db($database_alienorweb, $alienorweb);
									$Result1 = mysql_query($insertSQL, $alienorweb) or die(mysql_error());
									// Fin création fiche
									
									// Recherche de l'id de la personne créée
									mysql_select_db($database_alienorweb, $alienorweb);
									$query_personne = "SELECT INDEX_PERSONNE FROM personne WHERE ETAT_CIVIL= '".$auteur."'";
									$personne = mysql_query($query_personne, $alienorweb) or die(mysql_error());
									$row_personne = mysql_fetch_assoc($personne);
									$totalRows_auteur = mysql_num_rows($personne);
									do {
										$auteur_trouve = intval($row_personne['INDEX_PERSONNE']);
									} while ($row_personne = mysql_fetch_assoc($personne));
									$auteur_liaison_fin[$i] = $auteur_trouve;
									// Fin de recherche de l'id de la personne créée
									
									// Début liaison de la fiche personne avec la fiche objet
									$insertSQL = sprintf("INSERT INTO obj_per (INDEX_OBJET,INDEX_PERSONNE,QUALIFIANT) VALUES (".$noFiche.",".$auteur_trouve.",'".$key."')");
									mysql_select_db($database_alienorweb, $alienorweb);
									$Result1 = mysql_query($insertSQL, $alienorweb) or die(mysql_error());
									// Fin liaison de la fiche auteur avec la fiche objet
									
								} else {
									// Recherche si liaison existante
									mysql_select_db($database_alienorweb, $alienorweb);
									$query_liaison = "SELECT INDEX_OBJ_PER FROM obj_per WHERE INDEX_PERSONNE = ".$auteur_trouve." AND INDEX_OBJET = ".$noFiche." AND QUALIFIANT = '".$key."'";
									$liaison = mysql_query($query_liaison, $alienorweb) or die(mysql_error());
									$row_liaison = mysql_fetch_assoc($liaison);
									$totalRows_liaison = mysql_num_rows($liaison);
									do {
										$index_liaison = $row_liaison['INDEX_OBJ_PER'];
									} while ($row_liaison = mysql_fetch_assoc($liaison));
									// fin de recherche
									
									if ($index_liaison == "" &&$val != "") {
										// Début liaison de la fiche personne avec la fiche objet
										$insertSQL = sprintf("INSERT INTO obj_per (INDEX_OBJET,INDEX_PERSONNE,QUALIFIANT) VALUES (".$noFiche.",".$auteur_trouve.",'".$key."')");
										mysql_select_db($database_alienorweb, $alienorweb);
										$Result1 = mysql_query($insertSQL, $alienorweb) or die(mysql_error());
										// Fin liaison de la fiche personne avec la fiche objet
									}
								// fin de création et affectation de la personne
								}
							}
							$difference = array_diff($auteur_liaison_debut,$auteur_liaison_fin);
							while (list($keya,$vala) = each($difference)) {
								if ($vala != 0) {
									$deleteSQL = sprintf("DELETE FROM obj_per WHERE INDEX_PERSONNE=".intval($vala)." AND INDEX_OBJET = ".$noFiche." AND QUALIFIANT = '".$key."'");
									mysql_select_db($database_alienorweb, $alienorweb);
									$Result1 = mysql_query($deleteSQL, $alienorweb) or die(mysql_error());
								}
							}
							// ----------------- Fin de traitement des personnes -----------------
						} else {
							// ----------------- Début de traitement des champs lieux ------------
							if ($key == 'LIEUX_DECOUVERTE' || $key == 'LIEUX_EXECUTION' || $key == 'LIEUX_UTILISATION') {
								// Recherche des lieux
								mysql_select_db($database_alienorweb, $alienorweb);
								$query_liaison_debut = "SELECT INDEX_LIEU FROM obj_lie WHERE QUALIFIANT = '".$key."' AND INDEX_OBJET = ".$noFiche."";
								$liaison_debut = mysql_query($query_liaison_debut, $alienorweb) or die(mysql_error());
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
									mysql_select_db($database_alienorweb, $alienorweb);
									$query_lieu = "SELECT INDEX_LIEU FROM lieu WHERE SITE= '".$lieu_exe."'";
									$lieu = mysql_query($query_lieu, $alienorweb) or die(mysql_error());
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
										mysql_select_db($database_alienorweb, $alienorweb);
										$Result1 = mysql_query($insertSQL, $alienorweb) or die(mysql_error());
										// fin création fiche lieu
										
										// Recherche de l'id du lieu créé
										mysql_select_db($database_alienorweb, $alienorweb);
										$query_lieu = "SELECT INDEX_LIEU FROM lieu WHERE SITE = '".$lieu_exe."'";
										$lieu = mysql_query($query_lieu, $alienorweb) or die(mysql_error());
										$row_lieu = mysql_fetch_assoc($lieu);
										$totalRows_lieu_exe = mysql_num_rows($lieu);
										do {
											$lieu_exe_trouve = intval($row_lieu['INDEX_LIEU']);
										} while ($row_lieu = mysql_fetch_assoc($lieu));
										$execution_liaison_fin[$i] = $lieu_exe_trouve;
										// fin de recherche de l'id lieu_exe créée	
												
										// Début liaison de la fiche lieu avec la fiche objet
										$insertSQL = sprintf("INSERT INTO obj_lie (INDEX_OBJET,INDEX_LIEU,QUALIFIANT) VALUES (".$noFiche.",".$lieu_exe_trouve.",'".$key."')");
										mysql_select_db($database_alienorweb, $alienorweb);
										$Result1 = mysql_query($insertSQL, $alienorweb) or die(mysql_error());
										// Fin liaison de la fiche lieu avec la fiche objet
									} else {
										
										// Recherche si liaison existante
										mysql_select_db($database_alienorweb, $alienorweb);
										$query_liaison = "SELECT INDEX_OBJ_LIE FROM obj_lie WHERE INDEX_LIEU = ".$lieu_exe_trouve." AND INDEX_OBJET = ".$noFiche." AND QUALIFIANT = '".$key."'";
										$liaison = mysql_query($query_liaison, $alienorweb) or die(mysql_error());
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
											mysql_select_db($database_alienorweb, $alienorweb);
											$Result1 = mysql_query($insertSQL, $alienorweb) or die(mysql_error());
											// Fin liaison de la fiche lieu avec la fiche objet
										}
									}
								}
								$difference = array_diff($execution_liaison_debut,$execution_liaison_fin);
								while (list($keyb,$valb)=each($difference)) {
									if ($valb != 0) {
										$deleteSQL = sprintf("DELETE FROM obj_lie WHERE INDEX_LIEU = ".intval($valb)." AND INDEX_OBJET = ".$noFiche." AND QUALIFIANT = '".$key."'");
										mysql_select_db($database_alienorweb, $alienorweb);
										$Result1 = mysql_query($deleteSQL, $alienorweb) or die(mysql_error());
									}
								}	
							// ----------------- Fin traitement des champs lieux -----------------
							} else {
								// ***************************************************************
								// ----------------- traitement des champs documentation ---------
								// ***************************************************************
								if ($key == 'PHOTOGRAPHIE') {
									// Recherche de documentation
									mysql_select_db($database_alienorweb, $alienorweb);
									$query_liaison_debut = "SELECT INDEX_DOCUMENTATION FROM obj_doc WHERE QUALIFIANT = '".$key."' AND INDEX_OBJET = ".$noFiche."";
									$liaison_debut = mysql_query($query_liaison_debut, $alienorweb) or die(mysql_error());
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
										$docum_exe = $tableau[$i];
										/* Recherche si la documentation existe déjà */
										mysql_select_db($database_alienorweb, $alienorweb);
										$query_docum = "SELECT INDEX_DOCUMENTATION FROM documentation WHERE IDENTIFIANT = '".$docum_exe."'";
										$docum = mysql_query($query_docum, $alienorweb) or die(mysql_error());
										$row_docum = mysql_fetch_assoc($docum);
										$totalRows_docum_exe = mysql_num_rows($docum);
										do {
											$docum_exe_trouve = intval($row_docum['INDEX_DOCUMENTATION']);
										} while ($row_docum = mysql_fetch_assoc($docum));
										$execution_liaison_fin[$i] = $docum_exe_trouve;
										// fin de recherche de  la documentation
										
										$fichier_image = "NULL";
										// ****************************************************
										//  Traitement du fichier image
										// ****************************************************
										if ($_FILES['FICHIER'] <> "") {
											$infoImage = $_FILES['FICHIER'];
											$nom = $infoImage["name"];
											$type = $infoImage["type"];
											// echo("\$type = ".$type."<br>\n");
											if ($type != "image/jpeg" && $type != "image/png" && $type != "image/gif" && $type != "") {
												$msg = "Ce fichier '$nom' n'a pas un type de fichier pris en compte !";
											} else {
												$taille = $infoImage["size"];
												$fichier_temporaire = $infoImage["tmp_name"];
												// echo ("\$fichier_temporaire = ".$fichier_temporaire."<br>\n");
												$code_erreur = $infoImage["error"];
												switch ($code_erreur) {
													case UPLOAD_ERR_OK : // N° erreur 0
														// Fichier bien reçu
														// déterminer un nom de destination final pour le fichier
														$destination = "c:/wamp/www/alienorweblibre/images/$nom";
														// Copie du fichier temporaire et test
														if (file_exists($destination)) {
															$msg = "Un fichier image du m&ecirc;me nom '$nom' est d&eacute;j&eacute; pr&eacute;sent !";
														} else {
															if (copy($fichier_temporaire,$destination)) {
																$msg = "Le Fichier '$nom' a &eacute;t&eacute; int&eacute;gr&eacute; avec succ&egrave;s";
																$fichier_image = $destination;
															} else {
																$msg = "Erreur lors de la copie du fichier '$nom'";
															}
														}
														break;
													case UPLOAD_ERR_NO_FILE : // N° erreur 4
														$msg = " Pas de nom de fichier saisie";
														break;
													case UPLOAD_ERR_INI_SIZE : // N° erreur 1
														$msg = " Fichier'$nom' trop volumineux pour le serveur<br>\n";
														$msg .= " taile > upload_max_filesize";
														break;
													case UPLOAD_ERR_FORM_SIZE : // N° erreur 2
														$msg = " Fichier'$nom' trop volumineux<br>\n";
														$msg .= " taille sup&eacute;rieure au maximum autorisé";
														break;
													case UPLOAD_ERR_PARTIAL : // N° erreur 3
														$msg = " Erreur fichier '$nom' incomplet<br>\n";
														$msg .= " probl&egrave;me lors du transfert&nbsp;!";
														break;
													case 5 : // N° erreur 5
														$msg = " Erreur fichier '$nom' non transf&eacute;r&eacute;<br>\n";
														$msg .= " (fichier non trouv&eacute; nom ou chemin incorrecte)";
														break;
													default :
														$msg = " Fichier non transfer&eacute;<br>\n";
														$msg .= " Erreur inconnue : $code_erreur";
												}
											}
										}
										// Si la document est non existant la fiche est créée
										if ($docum_exe_trouve == "" && $val != "" ) {
											// Début création de fiche documentation
											$IDENTIFIANT_national = ident_nat("documentations");
											$insertSQL = sprintf("INSERT INTO documentation (IDENTIFIANT,FICHE_CREEE_LE,FICHE_CREEE_PAR,CODEMUSEE,NIVEAU_VISA,IDENTIFIANT_NATIONAL,TXT_DATE_PRISE_VUE,DEB_DATE_PRISE_VUE,FIN_DATE_PRISE_VUE,FICHIER) VALUES ('".$docum_exe."','".$_POST['FICHE_CREEE_LE']."','".$_POST['FICHE_CREEE_PAR']."','".$_POST['CODEMUSEE']."','".$_POST['NIVEAU_VISA']."','".$IDENTIFIANT_national."','".$_POST['TXT_DATE_PRISE_VUE']."','".preg_replace('/^(.{2}).(.{2}).(.{4})$/','$3-$2-$1',$_POST['DEB_DATE_PRISE_VUE'])."','".preg_replace('/^(.{2}).(.{2}).(.{4})$/','$3-$2-$1',$_POST['FIN_DATE_PRISE_VUE'])."','".$fichier_image."')");
											mysql_select_db($database_alienorweb, $alienorweb);
											// echo("\$insertSQL documentation = ".$insertSQL."<br>\n");
											$Result1 = mysql_query($insertSQL, $alienorweb) or die(mysql_error());
											// Fin de création de la fiche documentation
											
											// Recherche de l'id de la fiche documention créée
											mysql_select_db($database_alienorweb, $alienorweb);
											$query_docum = "SELECT INDEX_DOCUMENTATION FROM documentation WHERE IDENTIFIANT = '".$docum_exe."'";
											$docum = mysql_query($query_docum, $alienorweb) or die(mysql_error());
											$row_docum = mysql_fetch_assoc($docum);
											$totalRows_docum_exe = mysql_num_rows($docum);
											do {
												$docum_exe_trouve = intval($row_docum['INDEX_DOCUMENTATION']);
											} while ($row_docum = mysql_fetch_assoc($docum));
											$execution_liaison_fin[$i] = $docum_exe_trouve;
											// Fin de recherche de l'id de la fiche documention créée
											
											// Début liaison de la fiche documentation avec la fiche objet
											$insertSQL = sprintf("INSERT INTO obj_doc (INDEX_OBJET,INDEX_DOCUMENTATION,QUALIFIANT) VALUES (".$noFiche.",".$docum_exe_trouve.",'".$key."')");
											mysql_select_db($database_alienorweb, $alienorweb);
											$Result1 = mysql_query($insertSQL, $alienorweb) or die(mysql_error());
											// Fin liaison de la fiche documentation avec la fiche objet
										} else {
											// Recherche si liaison existante
											mysql_select_db($database_alienorweb, $alienorweb);
											$query_liaison = "SELECT INDEX_OBJ_DOC FROM obj_doc WHERE INDEX_DOCUMENTATION = ".$docum_exe_trouve." AND INDEX_OBJET = ".$noFiche." AND QUALIFIANT = '".$key."'";
											$liaison = mysql_query($query_liaison, $alienorweb) or die(mysql_error());
											$row_liaison = mysql_fetch_assoc($liaison);
											$totalRows_liaison = mysql_num_rows($liaison);
											do {
												$index_liaison = $row_liaison['INDEX_OBJ_DOC'];
											} while ($row_liaison = mysql_fetch_assoc($liaison));	
											// Fin de recherche
											
											if ($index_liaison == "" && $val != "") {
												// Début liaison de la fiche documentation avec la fiche objet
												$insertSQL = sprintf("INSERT INTO obj_doc (INDEX_OBJET,INDEX_DOCUMENTATION,QUALIFIANT) VALUES (".$noFiche.",".$docum_exe_trouve.",'".$key."')");
												mysql_select_db($database_alienorweb, $alienorweb);
												$Result1 = mysql_query($insertSQL, $alienorweb) or die(mysql_error());
												// Fin liaison de la fiche documentation avec la fiche objet
											}
										}
									}
									$difference = array_diff($execution_liaison_debut,$execution_liaison_fin);
									while (list($keyc,$valc)=each($difference)) {
										if ($valc != 0) {
											$deleteSQL = sprintf("DELETE FROM obj_doc WHERE INDEX_DOCUMENTATION=".intval($valc)." AND INDEX_OBJET=".$noFiche." AND QUALIFIANT = '".$key."'");
											mysql_select_db($database_alienorweb, $alienorweb);
											$Result1 = mysql_query($deleteSQL, $alienorweb) or die(mysql_error());
										}
									}
										if (isset($_POST['PHOTOGRAPHE']) && $_POST['PHOTOGRAPHE'] != "") {
											// Recherche si l'auteur existe déjà
											mysql_select_db($database_alienorweb, $alienorweb);
											$query_personne = "SELECT INDEX_PERSONNE FROM personne WHERE ETAT_CIVIL = '".$_POST['PHOTOGRAPHE']."'";
											$personne = mysql_query($query_personne, $alienorweb) or die(mysql_error());
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
												mysql_select_db($database_alienorweb, $alienorweb);
												$Result1 = mysql_query($insertSQL, $alienorweb) or die(mysql_error());
												// Fin création fiche
												
												// Recherche de l'id de la personne créée
												mysql_select_db($database_alienorweb, $alienorweb);
												$query_personne = "SELECT INDEX_PERSONNE FROM personne WHERE ETAT_CIVIL= '".$_POST['PHOTOGRAPHE']."'";
												$personne = mysql_query($query_personne, $alienorweb) or die(mysql_error());
												$row_personne = mysql_fetch_assoc($personne);
												$totalRows_auteur = mysql_num_rows($personne);
												do {
													$auteur_trouve = intval($row_personne['INDEX_PERSONNE']);
												} while ($row_personne = mysql_fetch_assoc($personne));
												$auteur_liaison_fin[$i] = $auteur_trouve;
												// Fin de recherche de l'id de la personne créée
												
												// Début liaison de la fiche personne avec la fiche doc
												$insertSQL = sprintf("INSERT INTO doc_per (INDEX_DOCUMENTATION,INDEX_PERSONNE,QUALIFIANT) VALUES (".$docum_exe_trouve.",".(int)$auteur_trouve.",'PHOTOGRAPHE')");
												mysql_select_db($database_alienorweb, $alienorweb);
												$Result1 = mysql_query($insertSQL, $alienorweb) or die(mysql_error());
												// Fin liaison de la fiche auteur avec la fiche doc
											} else {
												// Recherche si liaison existante
												mysql_select_db($database_alienorweb, $alienorweb);
												$query_liaison = "SELECT INDEX_DOC_PER FROM doc_per WHERE INDEX_PERSONNE = ".$auteur_trouve." AND INDEX_DOCUMENTATION = ".$docum_exe_trouve." AND QUALIFIANT = 'PHOTOGRAPHE'";
												// echo "\$query_liaison = ".$query_liaison."<br>\n";
												$liaison = mysql_query($query_liaison, $alienorweb) or die(mysql_error());
												$row_liaison = mysql_fetch_assoc($liaison);
												$totalRows_liaison = mysql_num_rows($liaison);
												do {
													$index_liaison = $row_liaison['INDEX_OBJ_DOC'];
												} while ($row_liaison = mysql_fetch_assoc($liaison));
												// fin de recherche
												
												if ($index_liaison == "" &&$val != "") {
													// Début liaison de la fiche personne avec la fiche objet
													$insertSQL = sprintf("INSERT INTO doc_per (INDEX_DOCUMENTATION,INDEX_PERSONNE,QUALIFIANT) VALUES (".$docum_exe_trouve.",".$auteur_trouve.",'PHOTOGRAPHE')");
													mysql_select_db($database_alienorweb, $alienorweb);
													$Result1 = mysql_query($insertSQL, $alienorweb) or die(mysql_error());
													// Fin liaison de la fiche personne avec la fiche objet
												}
											// fin de création et affectation de la personne
											}
										}
								} else { 
									// ********* Partie ajout de la gestion ****************
									if ($key == 'ETAT' || $key == 'COMMENTAIRES' || $key == 'VALEUR' || $key == 'EMPLACEMENT' || $key == 'EXPERT') {
										if ($val != "") {
											$valeur = "";
											// Suivant les cas
											switch ($key) {
												case "ETAT":
													$key = "ETAT_CONSERVATION";
													$param = "ETAT_CONSERVATION,DATE_CONSERVATION"; 
													if (is_array($_POST['ETAT'])) {
														foreach($_POST['ETAT'] as $value) {
															$valeur .= $value."/";
														}
														$valeur = substr(trim($valeur),0,strlen($valeur)-1);
													}
													break;
												case "COMMENTAIRES":
													$key = "COMMENTAIRES";
													$param = "COMMENTAIRES"; 
													if (is_array($_POST['COMMENTAIRES'])) {
														foreach($_POST['COMMENTAIRES'] as $value) {
															$valeur .= $value."/";
														}
														$valeur = substr(trim($valeur),0,strlen($valeur)-1);
													}
													break;
												case "VALEUR":
													$key = "VALEUR";
													$param = "VALEUR,DATE_VALEUR"; 
													if (isset($_POST['VALEUR'])) { $valeur = $_POST['VALEUR']; }
													break;
												case "EXPERT":
													$key = "EXPERT";
													$param = "EXPERT"; 
													if (isset($_POST['EXPERT'])) { $valeur = $_POST['EXPERT']; }
													break;
												case "EMPLACEMENT":
													$key = "EMPLACEMENT";
													$param = "EMPLACEMENT,DATE_EMPLACEMENT";
													if (isset($_POST['EMPLACEMENT'])) { $valeur = $_POST['EMPLACEMENT']; }
													break;
											}
											$values = "";
											// Début création de fiche de gestion
											$values = GetSQLValueString($valeur, "text");
											if ($key <> "EXPERT" && $key <> "COMMENTAIRES") { 
												$values .= ",".GetSQLValueString(preg_replace('/^(.{2}).(.{2}).(.{4})$/','$3-$2-$1', $_POST['DATE_RECOLEMENT']), "date");
											}
											$values .= ", '".date('Y-m-d')."'";
											$values .= ",".GetSQLValueString($_POST['CODEMUSEE'], "text");
											$insertSQL = sprintf("INSERT INTO gestion (".$param.",FICHE_CREEE_LE,CODEMUSEE) VALUES (".$values.")");
											mysql_select_db($database_alienorweb, $alienorweb);
											// echo ("\$insertSQL = ".$insertSQL."<br>\n");
											$Result = mysql_query($insertSQL, $alienorweb) or die(mysql_error());
											// fin création fiches
											
											// Récuperation du numéro de la fiche créée
											mysql_select_db($database_alienorweb, $alienorweb);
											$query_gestion = "SELECT DISTINCT INDEX_GESTION FROM gestion WHERE ".$key." = '".$valeur."' AND FICHE_CREEE_LE = '".date('Y-m-d')."'";
											// echo ("\$query_gestion = ".$query_gestion."<br>\n");
											$gestion = mysql_query($query_gestion, $alienorweb) or die(mysql_error());
											$row_gestion = mysql_fetch_assoc($gestion);
											$totalRows_gestion = mysql_num_rows($gestion);
											
											$noGestion = intval($row_gestion['INDEX_GESTION']);
											
											// Liaison de la table objte avec la table gestion
											$insertSQL = sprintf("INSERT INTO obj_ges (INDEX_OBJET,INDEX_GESTION) VALUES (".intval($_POST['INDEX_OBJET']).",".$noGestion.")");
											$Result = mysql_query($insertSQL, $alienorweb) or die(mysql_error());
										}
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
			$updateSQL = sprintf("UPDATE objet SET ".$requete." WHERE INDEX_OBJET = ".$noFiche."");
			//echo("Mise à jour de la fiche objet = ".$updateSQL."<br>");
			mysql_select_db($database_alienorweb, $alienorweb);
			$Result1 = mysql_query($updateSQL, $alienorweb) or die(mysql_error());
		// Fin mise à jour de la fiche
		
		// Redirection vers l'affichage de la page modifiée ou vers la page de gestion si nouvelle fiche
		
		//redirection($creation,$noFiche,$doublon,$page,$isobjet);
	}
} // fin date de réolment différente de vide

// Début affichage de tous les champs de la fiche
	mysql_select_db($database_alienorweb, $alienorweb);
	$query_rech_objet = "SELECT * FROM objet WHERE INDEX_OBJET = ".$noFiche."";
	$rech_objet = mysql_query($query_rech_objet, $alienorweb) or die(mysql_error());
	$row_rech_objet = mysql_fetch_assoc($rech_objet);
	$totalRows_rech_objet = mysql_num_rows($rech_objet);
// Fin affichage de tous les champs de la fiche
?>