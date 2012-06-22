<?php
function protecValRequete($valeur) {
	return trim(addslashes(iconv('UTF-8','ISO-8859-1',$valeur)));
}

/* ****************************************************************************************** */
/*                                       Fonction objet                                       */
/* ****************************************************************************************** */
function objet($xml,$identifiant_national) {
	$requeteObjetBalise = array();
	$requeteObjetValeur = array();
	// echo("Ceci est l'objet ".$identifiant_national."<br />\n");
	$nofiche_objet = creation_fiche("objet",$identifiant_national);
	// echo("Fiche No = ".$nofiche_objet."<br />\n");
	while($xml->read())
	{
		if ($xml->name <> "DATE_PATRIMONIALE" && $xml->nodeType == 1) {
			$balise_precedente = trim($xml->name);
		}
		if ($xml->name == "OBJET")
		{
			//$requeteObjetB = implode(",<br>\n ",$requeteObjetBalise);
			//$requeteObjetV = implode(", ",$requeteObjetValeur);
			//echo ("<span style=\"color:#FF0000\"> Contenu requête balise Objet = </span>".$requeteObjetB."<br /><br />\n");
			//echo ("Contenu requête valeur Objet = ".$requeteObjetV."<br />\n");
			// Conversion de la balise
			$rep = converse($requeteObjetBalise,$requeteObjetValeur,"objet");
			$requeteObjetBalise = $rep[0];
			$requeteObjetValeur = $rep[1];
			miseaJour("objet",$nofiche_objet,$requeteObjetBalise,$requeteObjetValeur);
			//echo ("Sortie Objet<br /><br />\n");
			return($xml);
		}
		if (estunePersonne($xml))
		{
			$rep = traitementPersonnes($xml,$requeteObjetBalise,$requeteObjetValeur,$nofiche_objet,"obj_per");
			$requeteObjetBalise = $rep[0];
			$requeteObjetValeur = $rep[1];
		}
		if (estunLieu($xml))
		{
			$rep = traitementLieux($xml,$requeteObjetBalise,$requeteObjetValeur,$nofiche_objet,"obj_lie");
			$requeteObjetBalise = $rep[0];
			$requeteObjetValeur = $rep[1];
		}
		if (estuneDate($xml))
		{
			$rep = traitementDate($xml,$balise_precedente,$requeteObjetBalise,$requeteObjetValeur);
			$requeteObjetBalise = $rep[0];
			$requeteObjetValeur = $rep[1];
		}
		if (estuneDocumentation($xml))
		{
			$rep = traitementDocumentations($xml,$requeteObjetBalise,$requeteObjetValeur,$nofiche_objet,"obj_doc");
			$requeteObjetBalise = $rep[0];
			$requeteObjetValeur = $rep[1];
		}
		if (!estuneDate($xml) || !estunePersonne($xml) || !estunLieu($xml) || !estuneDocumentation($xml)) {
		//rechercher si dans le tableau des nom de rubriques j'ai déja xml->name
			//echo ("<span style=\"color:#00FF00\">est une rubrique de l'objet</span><br />\n");
			if ($xml->nodeType == 1)
			{
				$stockageBalise = $xml->name;
			}
			if ($xml->nodeType == 3 && trim($xml->value) <> "")
			{
				//echo("\$stockageBalise".$stockageBalise."<br />\n");
				$position = array_search($stockageBalise,$requeteObjetBalise);
				if ($position === false)
				{
					array_push($requeteObjetBalise,$stockageBalise);
					if ($stockageBalise == "FICHE_CREEE_LE" || $stockageBalise == "MISE_A_JOUR") {
						array_push($requeteObjetValeur,preg_replace('/^(.{2}).(.{2}).(.{4})$/','$3-$2-$1',trim((string)$xml->value)));
					} else {
						array_push($requeteObjetValeur,trim($xml->value));
					}
				} else {
					$requeteObjetValeur[$position] = $requeteObjetValeur[$position]."/".trim($xml->value);
				}
			}
		}
	}
}
/* *********************************** fin Fonction objet *********************************** */

/* ****************************************************************************************** */
/*                                    Fonction personne                                       */
/* ****************************************************************************************** */
function personne($xml,$etat_civil) {
	$requetePersonneBalise = array();
	$requetePersonneValeur = array();
	// echo("Ceci est la personne ".$etat_civil."<br />\n");
	$nofiche_personne = creation_fiche("personne",$etat_civil);
	// echo("Fiche No = ".$nofiche_personne."<br />\n");
	while($xml->read()) {
		if (($xml->name <> "DATE_PATRIMONIALE" || $xml->name <> "SITE") && $xml->nodeType == 1) {
			$balise_precedente = $xml->name;
		}
		if ($xml->name == "PERSONNE")
		{
			$rep = converse($requetePersonneBalise,$requetePersonneValeur,"personne");
			$requetePersonneBalise = $rep[0];
			$requetePersonneValeur = $rep[1];
			miseaJour("personne",$nofiche_personne,$requetePersonneBalise,$requetePersonneValeur);
			return($xml);
		}
		if (estuneDate($xml))
		{
			$rep = traitementDate($xml,$balise_precedente,$requetePersonneBalise,$requetePersonneValeur);
			$requetePersonneBalise = $rep[0];
			$requetePersonneValeur = $rep[1];
		}
		if (estunLieu($xml))
		{
			$rep = traitementLieux($xml,$requetePersonneBalise,$requetePersonneValeur,$nofiche_personne,"per_lie");
			$requetePersonneBalise = $rep[0];
			$requetePersonneValeur = $rep[1];
		}
		if (estuneDocumentation($xml))
		{
			$rep = traitementDocumentations($xml,$requetePersonneBalise,$requetePersonneValeur,$nofiche_personne,"per_doc");
			$requetePersonneBalise = $rep[0];
			$requetePersonneValeur = $rep[1];
		}
		if (!estuneDate($xml) && !estunLieu($xml) && !estuneDocumentation($xml)) {
		//rechercher si dans le tableau des nom de rubriques j'ai déja xml->name
			//echo ("<span style=\"color:#00FF00\">est une rubrique de la personne</span><br />\n");
			if ($xml->nodeType == 1)
			{
				$stockageBalise = $xml->name;
			}
			if ($xml->nodeType == 3 && trim($xml->value) <> "")
			{
				$position = array_search($stockageBalise,$requetePersonneBalise);
				//echo("Position = ".$position."<br />\n");
				if ($position === false)
				{
					array_push($requetePersonneBalise,$stockageBalise);
					if ($stockageBalise == "FICHE_CREEE_LE" || $stockageBalise == "MISE_A_JOUR") {
						array_push($requetePersonneValeur,preg_replace('/^(.{2}).(.{2}).(.{4})$/','$3-$2-$1',trim((string)$xml->value)));
					} else {
						array_push($requetePersonneValeur,trim($xml->value));
					}
				} else {
					$requetePersonneValeur[$position] = $requetePersonneValeur[$position]."/".trim($xml->value);
				}
			}
		}
	}
}
/* *********************************** fin Fonction personne ******************************** */

/* ****************************************************************************************** */
/*                                      Fonction lieu                                         */
/* ****************************************************************************************** */
function lieu($xml,$site) {
	// echo("Ceci est le lieu ".$site."<br />\n");
	$nofiche_lieu = creation_fiche("lieu",$site);
	// echo("Fiche No = ".$nofiche_lieu."<br />\n");
	$requeteLieuBalise = array();
	$requeteLieuValeur = array();
	while($xml->read())
	{
		if ($xml->name <> "DATE_PATRIMONIALE" && $xml->nodeType == 1) {
			$balise_precedente = trim($xml->name);
		}
		if ($xml->name == "LIEU")
		{
			//$requeteObjetB = implode(",<br>\n ",$requeteObjetBalise);
			//$requeteObjetV = implode(", ",$requeteObjetValeur);
			//echo ("<span style=\"color:#FF0000\"> Contenu requête balise Objet = </span>".$requeteObjetB."<br /><br />\n");
			//echo ("Contenu requête valeur Objet = ".$requeteObjetV."<br />\n");
			// Conversion de la balise
			$rep = converse($requeteLieuBalise,$requeteLieuValeur,"lieu");
			$requeteLieuBalise = $rep[0];
			$requeteLieuValeur = $rep[1];
			miseaJour("lieu",$nofiche_lieu,$requeteLieuBalise,$requeteLieuValeur);
			//echo ("Sortie Objet<br /><br />\n");
			return($xml);
		}
		if (estunePersonne($xml))
		{
			$rep = traitementPersonnes($xml,$requeteLieuBalise,$requeteLieuValeur,$nofiche_lieu,"lie_per");
			$requeteLieuBalise = $rep[0];
			$requeteLieuValeur = $rep[1];
		}
		if (estuneDate($xml))
		{
			$rep = traitementDate($xml,$balise_precedente,$requeteLieuBalise,$requeteLieuValeur);
			$requeteLieuBalise = $rep[0];
			$requeteLieuValeur = $rep[1];
		}
		if (estuneDocumentation($xml))
		{
			$rep = traitementDocumentations($xml,$requeteLieuBalise,$requeteLieuValeur,$nofiche_lieu,"lie_doc");
			$requeteLieuBalise = $rep[0];
			$requeteLieuValeur = $rep[1];
		}
		if (!estuneDate($xml) || !estunePersonne($xml) || !estuneDocumentation($xml)) {
		//rechercher si dans le tableau des nom de rubriques j'ai déja xml->name
			//echo ("<span style=\"color:#00FF00\">est une rubrique de l'objet</span><br />\n");
			if ($xml->nodeType == 1)
			{
				$stockageBalise = $xml->name;
			}
			if ($xml->nodeType == 3 && trim($xml->value) <> "")
			{
				//echo("\$stockageBalise".$stockageBalise."<br />\n");
				$position = array_search($stockageBalise,$requeteLieuBalise);
				if ($position === false)
				{
					array_push($requeteLieuBalise,$stockageBalise);
					if ($stockageBalise == "FICHE_CREEE_LE" || $stockageBalise == "MISE_A_JOUR") {
						array_push($requeteLieuValeur,preg_replace('/^(.{2}).(.{2}).(.{4})$/','$3-$2-$1',trim((string)$xml->value)));
					} else {
						array_push($requeteLieuValeur,trim($xml->value));
					}
				} else {
					$requeteLieuValeur[$position] = $requeteLieuValeur[$position]."/".trim($xml->value);
				}
			}
		}
	}
}
/* *********************************** fin Fonction lieu ******************************** */

/* ****************************************************************************************** */
/*                                  Fonction documentation                                    */
/* ****************************************************************************************** */
function documentation($xml,$identifiant) {
	//echo("Ceci est la documentation ".$identifiant."<br />\n");
	$nofiche_documentation = creation_fiche("documentation",$identifiant);
	//echo("Fiche No = ".$nofiche_documentation."<br />\n");	
	$requeteDocumentationBalise = array();
	$requeteDocumentationValeur = array();
	while($xml->read())
	{
		if ($xml->name <> "DATE_PATRIMONIALE" && $xml->nodeType == 1) {
			$balise_precedente = trim($xml->name);
		}
		if ($xml->name == "DOCUMENTATION")
		{
			//$requeteDocumentationB = implode(",<br>\n ",$requeteDocumentationBalise);
			//$requeteDocumentationV = implode(", ",$requeteDocumentationValeur);
			//echo ("<span style=\"color:#FF0000\"> Contenu requête balise Documentation = </span>".$requeteDocumentationB."<br /><br />\n");
			//echo ("Contenu requête valeur Documentation = ".$requeteDocumentationV."<br />\n");
			// Conversion de la balise
			$rep = converse($requeteDocumentationBalise,$requeteDocumentationValeur,"documentation");
			$requeteDocumentationBalise = $rep[0];
			$requeteDocumentationValeur = $rep[1];
			miseaJour("documentation",$nofiche_documentation,$requeteDocumentationBalise,$requeteDocumentationValeur);
			//echo ("Sortie Documentation<br /><br />\n");
			return($xml);
		}
		if (estunePersonne($xml))
		{
			$rep = traitementPersonnes($xml,$requeteDocumentationBalise,$requeteDocumentationValeur,$nofiche_documentation,"doc_per");
			$requeteDocumentationBalise = $rep[0];
			$requeteDocumentationValeur = $rep[1];
		}
		if (estunLieu($xml))
		{
			$rep = traitementLieux($xml,$requeteDocumentationBalise,$requeteDocumentationValeur,$nofiche_documentation,"doc_lie");
			$requeteDocumentationBalise = $rep[0];
			$requeteDocumentationValeur = $rep[1];
		}
		if (estuneDate($xml))
		{
			$rep = traitementDate($xml,$balise_precedente,$requeteDocumentationBalise,$requeteDocumentationValeur);
			$requeteDocumentationBalise = $rep[0];
			$requeteDocumentationValeur = $rep[1];
		}
		if (!estuneDate($xml) || !estunePersonne($xml) || !estunLieu($xml)) {
		//rechercher si dans le tableau des nom de rubriques j'ai déja xml->name
			//echo ("<span style=\"color:#00FF00\">est une rubrique de l'documentation</span><br />\n");
			if ($xml->nodeType == 1)
			{
				$stockageBalise = $xml->name;
			}
			if ($xml->nodeType == 3 && trim($xml->value) <> "")
			{
				//echo("\$stockageBalise".$stockageBalise."<br />\n");
				$position = array_search($stockageBalise,$requeteDocumentationBalise);
				if ($position === false)
				{
					array_push($requeteDocumentationBalise,$stockageBalise);
					if ($stockageBalise == "FICHE_CREEE_LE" || $stockageBalise == "MISE_A_JOUR") {
						array_push($requeteDocumentationValeur,preg_replace('/^(.{2}).(.{2}).(.{4})$/','$3-$2-$1',trim((string)$xml->value)));
					} else {
						array_push($requeteDocumentationValeur,trim($xml->value));
					}
				} else {
					$requeteDocumentationValeur[$position] = $requeteDocumentationValeur[$position]."/".trim($xml->value);
				}
			}
		}
	}
}
/* ******************************* fin Fonction documentation ******************************* */

/* ****************************************************************************************** */
/*                                  Fonction création fiche                                   */
/* ****************************************************************************************** */
function creation_fiche() {
	$tab = func_get_args();
	for ($i = 0; $i < func_num_args(); $i++)
	{
		switch ($i) :
			case 0 :
				$table = $tab[$i];
				break;
			case 1 :
				$idDepart = $tab[$i];
				break;
			case 2 :
				$idArrivee = $tab[$i];
				break;
			case 3:
				$qualifiant = $tab[$i];
				break;
			endswitch;
	}
	switch ($table) :
		case "objet" :
			$param1 = "IDENTIFIANT_NATIONAL";
			$operateur1 = "LIKE";
			$valIdDepart = "'".protecValRequete($idDepart)."'";
			break;
		case "personne" :
			$param1 = "ETAT_CIVIL";
			$operateur1 = "LIKE";
			$valIdDepart = "'".protecValRequete($idDepart)."'";
			break;
		case "lieu" :
			$param1 = "SITE";
			$operateur1 = "LIKE";
			$valIdDepart = "'".protecValRequete($idDepart)."'";
			break;
		case "documentation" :
			$param1 = "IDENTIFIANT";
			$operateur1 = "LIKE";
			$valIdDepart = "'".protecValRequete($idDepart)."'";
			break;
		case "obj_per" :
			$param1 = "INDEX_OBJET"; $param2 = "INDEX_PERSONNE"; $param3 = "QUALIFIANT";
			$valIdDepart = (int)$idDepart;
			$operateur1 = "=";
			break;
		case "obj_lie" :
			$param1 = "INDEX_OBJET"; $param2 = "INDEX_LIEU"; $param3 = "QUALIFIANT";
			$valIdDepart = (int)$idDepart;
			$operateur1 = "=";
			break;
		case "obj_doc" :
			$param1 = "INDEX_OBJET"; $param2 = "INDEX_DOCUMENTATION"; $param3 = "QUALIFIANT";
			$valIdDepart = (int)$idDepart;
			$operateur1 = "=";
			break;
		case "per_lie" :
			$param1 = "INDEX_PERSONNE"; $param2 = "INDEX_LIEU"; $param3 = "QUALIFIANT";
			$valIdDepart = (int)$idDepart;
			$operateur1 = "=";
			break;
		case "per_doc" :
			$param1 = "INDEX_PERSONNE"; $param2 = "INDEX_DOCUMENTATION"; $param3 = "QUALIFIANT";
			$valIdDepart = (int)$idDepart;
			$operateur1 = "=";
			break;
		case "lie_per" :
			$param1 = "INDEX_LIEU"; $param2 = "INDEX_PERSONNE"; $param3 = "QUALIFIANT";
			$valIdDepart = (int)$idDepart;
			$operateur1 = "=";
			break;
		case "lie_doc" :
			$param1 = "INDEX_LIEU"; $param2 = "INDEX_DOCUMENTATION"; $param3 = "QUALIFIANT";
			$valIdDepart = (int)$idDepart;
			$operateur1 = "=";
			break;
		case "doc_lie" :
			$param1 = "INDEX_DOCUMENTATION"; $param2 = "INDEX_LIEU"; $param3 = "QUALIFIANT";
			$valIdDepart = (int)$idDepart;
			$operateur1 = "=";
			break;
		case "doc_per" :
			$param1 = "INDEX_DOCUMENTATION"; $param2 = "INDEX_PERSONNE"; $param3 = "QUALIFIANT";
			$valIdDepart = (int)$idDepart;
			$operateur1 = "=";
			break;
	endswitch;
	
	include('../Connections/alienorweblibre.php');
	$champ = strtoupper("INDEX_".$table);
	mysql_select_db($database_alienorweblibre, $alienorweblibre);
	$query_rech_doublon = "SELECT ".$champ." FROM ".$table." WHERE ".$param1." ".$operateur1." ".$valIdDepart;
	//print("Question = ".$query_rech_doublon."<br />\n");
	if ($idArrivee <> "") { $query_rech_doublon = $query_rech_doublon." AND ".$param2." = ".(int)$idArrivee; }
	if ($qualifiant <> "") { $query_rech_doublon = $query_rech_doublon." AND ".$param3." LIKE '".addslashes($qualifiant)."'"; }
	echo("<br />\nRequête recherche 1 : ".$query_rech_doublon."<br />\n");
	$rech_doublon = mysql_query($query_rech_doublon, $alienorweblibre) or die(mysql_error());
	$row_rech_doublon = mysql_fetch_assoc($rech_doublon);
	$totalRows_rech_doublon = mysql_num_rows($rech_doublon);
	$noFiche = $row_rech_doublon[$champ];
	// Si pas de doublon création de la fiche objet
	//print("Recherche doublon = ".$totalRows_rech_doublon."<br />\n");
	if ($totalRows_rech_doublon != 0)
	{
		$msg = "Ce numéro d'inventaire existe déjà";
		$doublon = 1;
	} else {
		// création de la fiche
		$params = $param1;
		$valeurs = "'".protecValRequete($idDepart)."'";
		if ($idArrivee <> "") { $params = $params.",".$param2; $valeurs = $valeurs.",'".$idArrivee."'"; }
		if ($qualifiant <> "") { $params = $params.",".$param3; $valeurs = $valeurs.",'".$qualifiant."'"; }
		$insertSQL = sprintf("INSERT INTO ".$table." (".$params.") VALUES (".$valeurs.")");
		echo("<br />\nRequête insertion: ".$insertSQL."<br />\n");
		mysql_select_db($database_alienorweblibre, $alienorweblibre);
		$Result = mysql_query($insertSQL, $alienorweblibre) or die(mysql_error());
		$creation = 1;
		
		// récupération de l'id de la fiche créée
		$query_rech_doublon = "SELECT ".$champ." FROM ".$table." WHERE ".$param1." = '".protecValRequete($idDepart)."'";
		if ($idArrivee <> "") { $query_rech_doublon = $query_rech_doublon." AND ".$param2." = '".addslashes($idArrivee)."'"; }
		if ($qualifiant <> "") { $query_rech_doublon = $query_rech_doublon." AND ".$param3." = '".addslashes($qualifiant)."'"; }
		echo("<br />\nRequête recherche 2 : ".$query_rech_doublon."<br />\n");
		$rech_doublon = mysql_query($query_rech_doublon, $alienorweblibre) or die(mysql_error());
		$row_rech_doublon = mysql_fetch_assoc($rech_doublon);
		$totalRows_rech_doublon = mysql_num_rows($rech_doublon);
		$noFiche = $row_rech_doublon[$champ];
	}
	//echo("No fiche créé : ".$noFiche."<br />\n");
	return($noFiche);
}
/* ******************************* fin Fonction création fiche ****************************** */

/* ****************************************************************************************** */
/*                                     Fonction is date                                       */
/* ****************************************************************************************** */
function estuneDate($xml) {
	if ($xml->name == "DATE_PATRIMONIALE")
	{
		//print("<b>Est une date</b><br />\n");
		return(true);
	} else {
		return(false);
	}
}
/* ********************************** fin Fonction is date *********************************** */

/* ****************************************************************************************** */
/*                                   Fonction traitement date                                 */
/* ****************************************************************************************** */
function traitementDate($xml,$balise_precedente,$requeteBalise,$requeteValeur) {
	// echo("Ceci est le traitement de la date ".$nofiche_objet."<br />\n");
	$typConvers = lectureFichier("conversion_date");
	while($xml->read())
	{
		$convDate = false;
		if (estuneDate($xml))
		{
			$rep[0] = $requeteBalise;
			$rep[1] = $requeteValeur;
			//echo("<br />Sortie traitement date <br /><br />\n");
			return ($rep);
		}
		switch ($xml->name) :
			case "AFFIXE" : 
				$xml->read();
				if ($xml->nodeType == 3)
				{
					for ($i=0; $i < count($typConvers); $i++)
					{
						if ($typConvers[$i][0] == $balise_precedente) {
							$conversDeb = $typConvers[$i][2];
							$nomConvers = $typConvers[$i][1];
						}
					}
					switch ($conversDeb) :
						case 0 :
							$nomBalise = $nomConvers."_TXT_DATE_PATRIMONIALE";
							break;
						case 1 :
							$nomBalise = "TXT_DATE_".$nomConvers;
							break;
						case 2 :
							$nomBalise = $nomConvers."_TXTDATEDEBUT";
							break;
						case 3 :
							$nomBalise = "TXT_DATE_".$nomConvers;
							$convDate = true;
							break;
						case 4 :
							$nomBalise = $nomConvers."_TXT_DATE_PATRIMONIALE";
							break;
					endswitch;
					$position = array_search($nomBalise,$requeteBalise);
					if ($position === false)
					{
						array_push($requeteBalise,$nomBalise);
						array_push($requeteValeur,trim($xml->value));
					}else{
						$requeteValeur[$position] = $requeteValeur[$position]."/".trim($xml->value);
					}
				}
				break;
			case "DATE_DEBUT" :
				$xml->read();
				if ($xml->nodeType == 3)
				{
					for ($i=0; $i < count($typConvers); $i++) {
						if ($typConvers[$i][0] == $balise_precedente) {
							$conversDeb = $typConvers[$i][2];
							$nomConvers = $typConvers[$i][1];
						}
					}
					switch ($conversDeb) :
						case 0 :
							$nomBalise = $nomConvers."_DEB_DATE_PATRIMONIALE";
							break;
						case 1 :
							$nomBalise = "DEB_DATE_".$nomConvers;
							break;
						case 2 :
							$nomBalise = $nomConvers."_DEBDATEDEBUT";
							break;
						case 3 :
							$nomBalise = "DEB_DATE_".$nomConvers;
							$convDate = true;
							break;
						case 4 :
							$nomBalise = $nomConvers."_DEB_DATE_PATRIMONIALE";
							$convDate = true;
							break;
					endswitch;
					$position = array_search($nomBalise,$requeteBalise);
					if ($position === false)
					{
						array_push($requeteBalise,$nomBalise);
						($convDate) ? array_push($requeteValeur,preg_replace('/^(.{2}).(.{2}).(.{4})$/','$3-$2-$1',trim((string)$xml->value))) : array_push($requeteValeur,trim($xml->value));
					}else{
						$requeteValeur[$position] = $requeteValeur[$position]."/".trim($xml->value);
					}
				}
				break;
			case "DATE_FIN" :
				$xml->read();
				if ($xml->nodeType == 3)
				{
					for ($i=0; $i < count($typConvers); $i++)
					{
						if ($typConvers[$i][0] == $balise_precedente) {
							$conversDeb = $typConvers[$i][2];
							$nomConvers = $typConvers[$i][1];
						}
					}
					switch ($conversDeb) :
						case 0 :
							$nomBalise = $nomConvers."_FIN_DATE_PATRIMONIALE";
							break;
						case 1 :
							$nomBalise = "FIN_DATE_".$nomConvers;
							break;
						case 2 :
							$nomBalise = $nomConvers."_FINDATEDEBUT";
							break;
						case 3 :
							$nomBalise = "FIN_DATE_".$nomConvers;
							$convDate = true;
							break;
						case 4 :
							$nomBalise = $nomConvers."_FIN_DATE_PATRIMONIALE";
							$convDate = true;
							break;
					endswitch;
					$position = array_search($nomBalise,$requeteBalise);
					if ($position === false)
					{
						array_push($requeteBalise,$nomBalise);
						($convDate) ? array_push($requeteValeur,preg_replace('/^(.{2}).(.{2}).(.{4})$/','$3-$2-$1',trim((string)$xml->value))) : array_push($requeteValeur,trim($xml->value));
					}else{
						$requeteValeur[$position] = $requeteValeur[$position]."/".trim($xml->value);
					}
				}
				break;
		endswitch;
	}
}
/* ***************************** fin traitement des dates *********************************** */

/* ****************************************************************************************** */
/*                                  Fonction is personne                                      */
/* ****************************************************************************************** */
function estunePersonne($xml) {
	if ($xml->name == "AUTEUR" || $xml->name == "COLLECTEUR" || $xml->name == "DESCRIPTEUR" || $xml->name == "ATTRIBUTEUR" || $xml->name == "ATTRIBUTION" || $xml->name == "PHOTOGRAPHE" || $xml->name == "INVENTEUR" || $xml->name == "DETERMINATEUR" || $xml->name == "UTILISATEUR" || $xml->name == "ANCIENNE_APPARTENANCE" || $xml->name == "PROPRIETAIRE" || $xml->name == "COMMISSAIRE_PRISEUR" || $xml->name == "DEPOSITAIRE" || $xml->name == "GALERIE" || $xml->name == "SERVICE_GESTIONNAIRE" || $xml->name == "ANCIEN_DEPOSITAIRE" || $xml->name == "OCCUPANT")
	{
		//print("<b>Est une personne</b><br />\n");
		return(true);
	} else {
		return(false);
	}
}
/* ******************************* fin Fonction is personne ******************************** */

/* ****************************************************************************************** */
/*                               Fonction traitement personne 1.01                            */
/* ****************************************************************************************** */
function traitementPersonnes($xml,$requeteBalise,$requeteValeur,$nofiche,$table_depart) {
	//echo("Ceci est le traitement de la personne de la fiche objet N° ".$nofiche_objet."<br />\n");
	do
	{
		if (estunePersonne($xml))
		{
			$rubrique_personne = $xml->name;
		}
		if (estuneDate($xml))
		{
			$rep = traitementDate($xml,$rubrique_personne,$requeteBalise,$requeteValeur);
			$requeteBalise = $rep[0];
			$requeteValeur = $rep[1];
		}
		if ($xml->name == "ROLE") {
			$nomBalise = $xml->name;
			$xml->read();
			if ($xml->nodeType == 3)
			{
				$nomBalise = "ROLE";
				$position = array_search($nomBalise,$requeteBalise);
				if ($position === false)
				{
					array_push($requeteBalise,$nomBalise);
					array_push($requeteValeur,trim($xml->value));
				}else{
					$requeteValeur[$position] = $requeteValeur[$position]."/".trim($xml->value);
				}
			}
			$xml->read();
		}
		if ($xml->name == "NUMERO_CATALOGUE") {
			$nomBalise = $xml->name;
			$xml->read();
			if ($xml->nodeType == 3)
			{
				if ($rubrique_personne == "ANCIENNE_APPARTENANCE")
				{
					$nomBalise = "NUMERO_CATALOGUE";
				} else {
					$nomBalise = $rubrique_personne."_NUMERO_CATALOGUE";
				}
				$position = array_search($nomBalise,$requeteBalise);
				if ($position === false)
				{
					array_push($requeteBalise,$nomBalise);
					array_push($requeteValeur,trim($xml->value));
				}else{
					$requeteValeur[$position] = $requeteValeur[$position]."/".trim($xml->value);
				}
			}
			$xml->read();
		}
		if ($xml->name == "TAXONOMIE_DETERMINE") {
			$nomBalise = $xml->name;
			$xml->read();
			if ($xml->nodeType == 3)
			{
				$position = array_search($nomBalise,$requeteBalise);
				if ($position === false)
				{
					array_push($requeteBalise,$nomBalise);
					array_push($requeteValeur,trim($xml->value));
				}else{
					$requeteValeur[$position] = $requeteValeur[$position]."/".trim($xml->value);
				}
			}
			$xml->read();
		}
		if ($xml->name == "TYPE_PROPRIETE") {
			$nomBalise = $xml->name;
			$xml->read();
			if ($xml->nodeType == 3)
			{
				$position = array_search($nomBalise,$requeteBalise);
				if ($position === false)
				{
					array_push($requeteBalise,$nomBalise);
					array_push($requeteValeur,trim($xml->value));
				}else{
					$requeteValeur[$position] = $requeteValeur[$position]."/".trim($xml->value);
				}
			}
			$xml->read();
		}
		if ($xml->hasValue && $xml->nodeType <> 14)
		{
			$nofiche_personne = creation_fiche("personne",trim($xml->value));
			echo("\$nofiche_personne = ".$nofiche_personne."<br>\n");
			if ($nofiche_personne != 0)
			{
				$nofiche_liaison = creation_fiche($table_depart,$nofiche,$nofiche_personne,$rubrique_personne);
			}
		}
		if ($xml->name == $rubrique_personne && $xml->nodeType == 15)
		{
			$rep[0] = $requeteBalise;
			$rep[1] = $requeteValeur;
			return($rep);
		}
	} while ($xml->read());
}
/* *************************** fin Fonction traitement personne ***************************** */

/* ****************************************************************************************** */
/*                                     Fonction is lie                                        */
/* ****************************************************************************************** */
// Debut test est ce un lieu
function estunLieu($xml) {
	if ($xml->name == "LIEUX_DECOUVERTE" || $xml->name == "LIEUX_EXECUTION" || $xml->name == "LIEUX_UTILISATION" || $xml->name == "LIEU_NAISSANCE" || $xml->name == "LIEU_DECES" || $xml->name == "LIEU_TRAVAIL" || $xml->name == "LIEU_RESIDENCE" || $xml->name == "GALERIE_IND" || $xml->name == "LIEU_EDITION" || $xml->name == "LIEU_PRISE_VUE" )
	{
		return(true);
	} else {
		return(false);
	}
}
/* ********************************* fin fonction is lieu *********************************** */

/* ****************************************************************************************** */
/*                                Fonction traitement des lieux                               */
/* ****************************************************************************************** */
function traitementLieux($xml,$requeteBalise,$requeteValeur,$nofiche,$table_depart) {
	//echo("Ceci est le traitement des lieux de la fiche N° ".$nofiche_objet."<br />\n");
	do
	{
		if (estunlieu($xml))
		{
			$rubrique_lieu = $xml->name;
		}
		if (estuneDate($xml))
		{
			$rep = traitementDate($xml,$rubrique_lieu,$requeteBalise,$requeteValeur);
			$requeteBalise = $rep[0];
			$requeteValeur = $rep[1];
			}
		if ($xml->hasValue && $xml->nodeType <>14)
		{
			$nofiche_lieu = creation_fiche("lieu",trim($xml->value));
			if ($nofiche_lieu != 0)
			{
				$nofiche_liaisons = creation_fiche($table_depart,$nofiche,$nofiche_lieu,$rubrique_lieu);
			}
		}
		if ($xml->name == $rubrique_lieu && $xml->nodeType == 15)
		{
			$rep[0] = $requeteBalise;
			$rep[1] = $requeteValeur;
			return($rep);
		}
	} while ($xml->read());
}
/* ********************************* fin traitement des lieux ******************************* */

/* ****************************************************************************************** */
/*                                  Fonction is documentation                                 */
/* ****************************************************************************************** */
function estuneDocumentation($xml) {
	if ($xml->name == "BIBLIOGRAPHIE" || $xml->name == "PHOTOGRAPHIE" || $xml->name == "EXPOSITION" || $xml->name == "CEDEROM" || $xml->name == "INTERNET" || $xml->name == "TAPUSCRIT" || $xml->name == "MANUSCRIT" || $xml->name == "VIDEO" || $xml->name == "REPRODUCTION")
	{
		return(true);
	} else {
		return(false);
	}
}
/* ****************************** fin fonction is documentations **************************** */

/* ****************************************************************************************** */
/*                              Fonction traitement documentation                             */
/* ****************************************************************************************** */
function traitementDocumentations($xml,$requeteBalise,$requeteValeur,$nofiche_objet,$liaison) {
	//echo("Ceci est le traitement des documentation de la fiche N° ".$nofiche_objet."<br />\n");
	do
	{
		if (estunedocumentation($xml)){
			$rubrique_documentation = $xml->name;
		}
		if ($xml->name == "PARAMETRE") {
			$xml->read();
			if ($xml->nodeType == 3)
			{
				$nomBalise = $rubrique_documentation."_PARAM";
				$position = array_search($nomBalise,$requeteBalise);
				if ($position === false)
				{
					array_push($requeteBalise,$nomBalise);
					array_push($requeteValeur,trim($xml->value));
				}else{
					$requeteValeur[$position] = $requeteValeur[$position]."/".trim($xml->value);
				}
			}
			$xml->read();
		}
		if ($xml->hasValue && $xml->nodeType <>14)
		{
			$nofiche_documentation = creation_fiche("documentation",trim($xml->value));
			if ($nofiche_documentation != 0)
			{
				$nofiche_liaisons = creation_fiche($liaison,$nofiche_objet,$nofiche_documentation,$rubrique_documentation);
			}
		}
		if ($xml->name == $rubrique_documentation && $xml->nodeType == 15)
		{
			$rep[0] = $requeteBalise;
			$rep[1] = $requeteValeur;
			return($rep);
		}
		$rubrique_precedente = $xml->name;
	} while ($xml->read());
}
/* *************************** fin traitement des documentations **************************** */

/* ****************************************************************************************** */
/*                             Fonction traitement lecture fichier                            */
/* ****************************************************************************************** */
function lectureFichier($nomFichier) {
	if (!$fichier = fopen($nomFichier.".txt","r"))
	{
		$msg = "Lecture du fichier ".$nomFichier." impossible";
		exit;
	} else {
		$contenu_conversion = fread($fichier,filesize($nomFichier.".txt"));
		fclose($fichier);
	}
	//echo("Contenu de conversion : ".$contenu_conversion."<br />\n");
	$ligne = split("\r\n",$contenu_conversion);
	//echo("\$ligne = ".count($ligne)."<br />\n");
	for ($l = 0; $l < count($ligne); $l++)
	{
		//echo("\$ligne[$l] = ".$ligne[$l]."<br />\n");
		if (eregi("#",$ligne[$l]))
		{
			//echo("Effacement<br />\n");
			unset($ligne[$l]);
		}
	}
	
	//print("nombre de saut de ligne : ".count($ligne)."<br />\n");
	for ($l = 0; $l < count($ligne); $l++)
	{
		//print("Test $l = ".$ligne[$l]."<br />\n");
		$donnees = split(";",$ligne[$l]);
		for ($c = 0; $c < count($donnees); $c++)
		{
			// Tableau 2 dimension
			$tabConversion[$l][$c] = $donnees[$c];
		}
	}
//	print_r($tabConversion);
	return($tabConversion);
}
/* ****************************** fin traitement lecture fichier **************************** */

/* ****************************************************************************************** */
/*                         Fonction traitement mise à jour fichier                            */
/* ****************************************************************************************** */
function miseaJour($table,$id,$requeteBalise,$requeteValeur) {
	switch ($table) :
		case "objet" :
			$requeteconstruite = constructionRequeteMaj($requeteBalise,$requeteValeur);
			break;
		case "personne" :
			$requeteconstruite = constructionRequeteMaj($requeteBalise,$requeteValeur);
			break;
		case "lieu" :
			$requeteconstruite = constructionRequeteMaj($requeteBalise,$requeteValeur);
			break;
		case "documentation" :
			$requeteconstruite = constructionRequeteMaj($requeteBalise,$requeteValeur);
			break;
		case "obj_per" :
			$param1 = "INDEX_OBJET"; $param2 = "INDEX_PERSONNE"; $param3 = "QUALIFIANT";
			break;
		case "obj_lie" :
			$param1 = "INDEX_OBJET"; $param2 = "INDEX_LIEU"; $param3 = "QUALIFIANT";
			break;
		case "obj_doc" :
			$param1 = "INDEX_OBJET"; $param2 = "INDEX_DOCUMENTATION"; $param3 = "QUALIFIANT";
			break;
		case "per_lie" :
			$param1 = "INDEX_PERSONNE"; $param2 = "INDEX_LIEU"; $param3 = "QUALIFIANT";
			break;
		case "per_doc" :
			$param1 = "INDEX_PERSONNE"; $param2 = "INDEX_DOCUMENTATION"; $param3 = "QUALIFIANT";
			break;
		case "lie_per" :
			$param1 = "INDEX_LIEU"; $param2 = "INDEX_PERSONNE"; $param3 = "QUALIFIANT";
			break;
		case "lie_doc" :
			$param1 = "INDEX_LIEU"; $param2 = "INDEX_DOCUMENTATION"; $param3 = "QUALIFIANT";
			break;
		case "doc_lie" :
			$param1 = "INDEX_DOCUMENTATION"; $param2 = "INDEX_LIEU"; $param3 = "QUALIFIANT";
			break;
		case "doc_per" :
			$param1 = "INDEX_DOCUMENTATION"; $param2 = "INDEX_PERSONNE"; $param3 = "QUALIFIANT";
			break;
	endswitch;
	
	include('../Connections/alienorweblibre.php');
	mysql_select_db($database_alienorweblibre, $alienorweblibre);
	$query_modif = "UPDATE ".$table." SET ".$requeteconstruite." WHERE INDEX_".strtoupper($table)." = ".(int)$id;
	print("".$query_modif."<br>\n");
	$Result = mysql_query($query_modif, $alienorweblibre) or die(mysql_error());

}
/* ******************************* fin Fonction mise à jour fiche ************************** */

/* ****************************************************************************************** */
/*                                  Fonction conversion                                       */
/* ****************************************************************************************** */
function converse($requeteoldBalise,$requeteoldValeur,$table) {
	$tabRub = lectureFichier($table);
	$cptNewTable = 0;
	for ($i=0; $i < count($requeteoldBalise); $i++)
	{
		//echo("\$requeteObjetBalise = ".$requeteObjetBalise[$i]."<br />\n");
		for ($u=0; $u <count($tabRub);$u++)
		{
			//echo("\$tabRub[$u][0] = ".$tabRub[$u][0]."<br />\n");
			if ($tabRub[$u][0] == $requeteoldBalise[$i])
			{
				$requetenewBalise[$cptNewTable] = $tabRub[$u][1];
				$requetenewValeur[$cptNewTable] = $requeteoldValeur[$i];
				$cptNewTable = $cptNewTable + 1;
			}
		}
	}
	$rep[0] = $requetenewBalise;
	$rep[1] = $requetenewValeur;
	return($rep);
}
/* ************************************* Fonction conversion ********************************* */

/* ****************************************************************************************** */
/*                           construction Requete Mise à jour                                 */
/* ****************************************************************************************** */
function constructionRequeteMaj($requeteBalise,$requeteValeur) {
	$max = count($requeteBalise) - 1;
	for ($i = 0; $i < count($requeteBalise); $i++)
	{
		$requeteconstruite .= $requeteBalise[$i]." = '".protecValRequete($requeteValeur[$i])."'";
		($i < $max) ? $requeteconstruite .= ", " : $requeteconstruite;
	}
	return($requeteconstruite);
}
/* ***************************** construction Requete Mise à jour *************************** */
?>
