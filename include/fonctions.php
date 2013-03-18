<?php
$debDate="";


// protection des valeurs transmise
function supprimer_encodage_MQ($valeur) {
	return (get_magic_quotes_gpc()) ? stripslashes($valeur) : $valeur;
}

// suppression des espaces
function valeur_saisie($valeur) {
	return supprimer_encodage_MQ(trim($valeur));
}

// encoder les caract�res HTML sp�ciaux
function vers_formulaire($valeur) {
	return htmlentities($valeur,ENT_QUOTES);
}

// g�n�rer un identifiant unique pour les sessions
function identifiant_unique() {
	// g�n�ration d'identifiant � pr�fixe al�atoire crypt�. Uniquid(g�n�rateur de cha�ne de 13 caract�res)
	return md5(uniqid(rand()));
}

// g�n�rer l'identifiant national avec le code mus�es et les compteurs
function ident_nat($bases, $codeMusee=""){
	$codeMusee = $_POST['CODEMUSEE'];
	$identifiant ="";
	$fichiers_cpt = "";
	switch ($bases) {
		case "objets" :
			$compteur = "cpt_objets";
			break;
		case "personnes" :
			$compteur = "cpt_personnes";
			break;
		case "lieux" :
			$compteur = "cpt_lieux";
			break;
		case "documentations" :
			$compteur = "cpt_documentations";
			break;
	}
	require('../Connections/alienorweblibre.php');
		mysql_select_db($database_alienorweblibre, $alienorweblibre);
		$query_codemusee = "SELECT CODE_MUSEE FROM musee";
		$mysql_query_codemusee = mysql_query($query_codemusee, $alienorweblibre) or die(mysql_error());
		$row_codemusee = mysql_fetch_assoc($mysql_query_codemusee);
		$nb_codemusee = mysql_num_rows($mysql_query_codemusee);
		do {
			$codemusee = $row_codemusee['CODE_MUSEE'];
		} while ($row_codemusee = mysql_fetch_assoc($mysql_query_codemusee));
	//recherche du compteur selectionner dans le musee de l'user
		mysql_select_db($database_alienorweblibre, $alienorweblibre);
		$query_compteur = "SELECT ".$compteur." FROM musee WHERE CODE_MUSEE='".$codeMusee."'";
		$compteur_musees = mysql_query($query_compteur, $alienorweblibre) or die(mysql_error());
		$row_compteur = mysql_fetch_assoc($compteur_musees);
		$totalRows_compteur = mysql_num_rows($compteur_musees);
		do {
			$cpt = $row_compteur[$compteur];
		} while ($row_musees = mysql_fetch_assoc($compteur_musees));
	//fin de la recherche

	if($totalRows_compteur<=1){
		(int)$cpt = (int)$cpt+1;
		(string)$cpt = (string)$cpt;
		for ($i=strlen($cpt); $i<6; $i++){
			$cpt= "0".$cpt;
		}
		//Enregistre la nouvelle valeur du compteur
		mysql_select_db($database_alienorweblibre, $alienorweblibre);
		$update = "UPDATE musee SET ".$compteur."=".$cpt." WHERE CODE_MUSEE='".$codeMusee."'";
		$Result = mysql_query($update, $alienorweblibre) or die(mysql_error());
	//fin de la recherche

	}else{
		$msg="Une erreur s'est produite lors de la cr&eacute;ation de l'identifiant national. Plusieurs mus&eacute;es poss&egrave;dent le m&ecirc;me code mus&eacute;e.";
		echo $msg;
		exit;
	}
	$identifiant = $codeMusee.$cpt;
	return $identifiant;
}

// D�but fonction de convertion des dates du format AAAA-MM-JJ en JJ.MM.AAAA
function reverseDate($valeur){
	$tableau = explode("/",$valeur);
	$valeur = "";
	for ($i=0; $i < count($tableau); $i++) {
		$valeur = $tableau[$i];
		$valeur = preg_replace('/^(.{4})-(.{2})-(.{2})$/','$3.$2.$1', $valeur);
		($valeur == '00.00.0000') ? $valeur = "" : $valeur = $valeur; 
		if ($i != 0) {
			$valeur .= "/".$valeur;	
		}
	}
	return $valeur;
}
// Fin fonction de convertion des dates du format AAAA-MM-JJ en JJ.MM.AAAA

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
	$theValue = (!get_magic_quotes_gpc()) ? trim(addslashes($theValue)) : trim(htmlspecialchars($theValue)) ;

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

// fonction de gestion des redirections lors de la cr�ation
// doublon = 1 si fiche existe
// doublon = 2 si pb telechargement image
// objet = 1 s'il s'agit d'un objet
function redirection($creation,$noFiche,$doublon,$page,$isobjet) {
	if ($doublon == 0) {
		($creation == 1 && $isobjet == 1) ? $insertGoTo = "mcr_champs_gestion.php?page=$page" : $insertGoTo = "mc_".$page.".php";
		if (isset($_SERVER['QUERY_STRING'])) {
			$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
			$insertGoTo .= "noFiche=".$noFiche;
		}
		header(sprintf("Location: %s", $insertGoTo));
	}
	return false;
}

// Fonction(s) traitement de date dans les �tats

function traitementDate($txtDate, $debDate, $finDate)
{
// transforme l'affichage des dates patrimoniales de chiffre en lettre
$tabMois = array("","janvier","f�vrier","mars","avril","mai","juin","juillet","ao�t","septembre","octobre","novembre","d�cembre");
$deb = split('[.-]',$debDate);
$fin = split('[.-]',$finDate);

	switch($txtDate) {
		case "ann&eacute;e":
			echo " en ".$deb[2];
			break;
		case "ann�e":
			echo " en ".$deb[2];
			break;
		case "mois":
			echo " en ".$tabMois[(int)$deb[1]]." ".$deb[2];
			break;
		case "le":
			echo " le ".$deb[0]." ".$tabMois[(int)$deb[1]]." ".$deb[2];
			break;
		case "avant":
			echo " avant le ".$deb[0]." ".$tabMois[(int)$deb[1]]." ".$deb[2];
			break;
		case "apr&egrave;s":
			echo " apr�s le ".$deb[0]." ".$tabMois[(int)$deb[1]]." ".$deb[2];
			break;
		case "apr�s":
			echo " apr�s le ".$deb[0]." ".$tabMois[(int)$deb[1]]." ".$deb[2];
			break;
		case "entre":
			echo " entre le ".$deb[0]." ".$tabMois[(int)$deb[1]]." ".$deb[2]." et le ".$fin[0]." ".$tabMois[(int)$fin[1]]." ".$fin[2];
			break;
		case "an":
			echo $deb[2];
		default:
			if ($debDate != ""){echo(" pas d'affixe pr�cis� ");}
	}
}

// ouverture de la f�n�tre de th�saurus
function creerFenetreTheso() {
	echo 'function FenetreTheso(URL) { window.open("../Connections/pageProxy.php?url=';
	echo $_SESSION['thesaurus'];
	echo '"';
	if ($_SESSION['internet'] == "true" ){
		echo "+ URL";
	}else{ 
		echo ' + "?THESO=" + URL'; 
	}
	echo ", '', 'scrollbars=yes,status=yes,width=450,height=500,resizable=yes');";
	echo "}";
}

// int�gration d'un fichier image

function integreImage($fichier, $nomAncienFichier, $supprime, $sousrep)
// cette fonction prend comme parametre :
//      * $ficher de type $_FILES comportant lefichier envoy�
//		* $nomAncienFichier : nom du fichier d�j� contenu dans la bdd (pour faire entre autre les comparaisons sur le remplacement d'un fichier
// 		* $supprime : s'il faut supprimer le fichier cette variable est diff de ""
// cette fonction renvoi un tableau enregImage o� :
//  	* enregImage[0] = � "" si tout est ok ou � un message d'erreur
//		* enregImage[1] = une chaine de caract�re comportant une partie de la requ�te du type ",FICHIER = valeur"
{
	$pbimage = false;
	$rep = array('', $nomAncienFichier);
	if ($fichier['error'] > 0 && $nomAncienFichier != "") {
		$rep[0] = "Probleme lors du t�l�chargement de l'image<br>";
		$pbImage=true;
		switch ($fichier['error']){
			case 1 : $rep[0] .= "le fichier t�l�charg� � d�passer la taille maximun de t�l�chargement : ".$_SESSION['max_transfert']." octets.";
				break;
			case 2 : $rep[0] .= "le fichier t�l�charg� � d�passer la taille maximun de fichier : ".$_SESSION['max_transfert']." octets.";
				break;
			case 3 : $rep[0] .= "le fichier n'a pas �t� t�l�charg� correctement (t�l�chargement partiel).";
				break;
			case 4 : $rep[0] .= "Pas de fichier t�l�charg�.";
				break;
		};//fin switch
		//exit;
	} else {
		// le fichier est il une image
		if ($fichier['type'] != 'image/gif' && $fichier['type'] != 'image/pjpeg' && $fichier['type'] != 'image/jpeg' && $fichier['type'] != 'image/x-png') {
			if ($fichier['type'] != ""){
				$pbImage = true;
				$rep[0] = "Le fichier t�l�charg� n'est pas une image g�r� par le syst�me (JPEG,GIF,PNG) mais :".$fichier['type'];
				//exit;
			};//$fichier['type'] != ""
		}else{
			$destination = $_SESSION['images'].$sousrep."\\".strToLower($fichier['name']);
			//echo "<br> \$destination:<br>";
			//echo $destination;
			//echo "<br> \$fichier['tmp_name']:<br>";
			//echo $fichier['tmp_name'];
			if (is_uploaded_file($fichier['tmp_name'])) {
				// si le fichier est diff�rent d�truire l'ancien
				if ($nomAncienFichier != $fichier['name'] ){
					if ($nomAncienFichier != ""){
						unlink($_SESSION['images'].$sousrep."\\".$nomAncienFichier);
						//echo "effacement de :".$nomAncienFichier;
					};
					$nomAncienFichier = strToLower($fichier['name']);
				};
				if (file_exists($_SESSION['images'].$sousrep."\\".$fichier['name'])) {
					$rep[0] = "Le fichier : ".$fichier['name']." existe d�j�. Il n'est pas possible de donner deux fois le m�me nom � un fichier image.<br> Utiliser l'identifiant ou l'identifiant national pour nommer vos fichiers.";
					//echo $rep[0];
					$pbImage = true;
				}else{
					if (!move_uploaded_file($fichier['tmp_name'],$destination)) {
						$pbImage = true;
						$rep[0] = "Probl�me lors du d�placement du fichier dans l'espace de stockage";	
						//exit;
					};//(!move_uploaded_file($fichier['tmp_name'],$destination))
				}//is_existe_image($fichier[name])
			}else{
				echo "possibilit� d'une attaque du serveur";
				exit;
			}// (is_uploaded_file($fichier['tmp_name']))
		} //($fichier['type'] != 'image/gif') 
	} // fin ($fichier['error'] > 0 && $nomAncienFichier != "")
	// ----------------- Fin Mise a jour de l'image ----------------------------------------
	//mise � jour du champs
	if (! $pbImage){
		$rep[1] = $nomAncienFichier;
		// effacer le fichier si suppression
		if ($_POST['FICHIER'] == "" && $supprime != ""){
			unlink($_SESSION['images'].$sousrep."\\".$supprime);
			};
		//echo "<br> requete rep[1] :<br>";
		//echo $rep[1];
	};	
	//echo "<br>fichier['tmp_name'] :<br>";
	//echo $fichier['tmp_name'];
	return $rep;	
}

function utilisateur_existe($identifiant,$mot_de_passe,$code_musee="")
{
	$existe="";
	$codeMusee_select="";
	require_once('GestionConfig.class.php');
	require('Connections/alienorweblibre.php');
	
	// Recherche de l'utilisateur et de ses divers param�tres
	mysql_select_db($database_alienorweblibre, $alienorweblibre);
	$query_utilis = "SELECT * FROM utilisateur WHERE utilisateur.login = '".$identifiant."'";
	$utilis = mysql_query($query_utilis, $alienorweblibre) or die(mysql_error());
	$row_utilis = mysql_fetch_assoc($utilis);
	$totalRows_utilis = mysql_num_rows($utilis);
	do {
		$motdepasse = $row_utilis["mot_de_passe"];
		$droit = $row_utilis["droit"];
		$nom = $row_utilis["nom"];
		$prenom = $row_utilis["prenom"];
		$idutil =  $row_utilis["per_index"];
	} while ($row_utilis = mysql_fetch_assoc($utilis));

	$query_musees = "	SELECT MUS_INDEX,NOM,CODE_MUSEE
						FROM musee, user_musee 
						WHERE 
							user_musee.INDEX_MUSEE = musee.MUS_INDEX
							AND
							user_musee.INDEX_USER = '".$idutil."'";
	$musees = mysql_query($query_musees, $alienorweblibre) or die(mysql_error());
	$row_musees = mysql_fetch_assoc($musees);
	$totalRows_musees = mysql_num_rows($musees);
	if ($totalRows_musees >0 ){
		do {
			$mus_index_select = $row_musees['MUS_INDEX'];
			$codeMusee_select = $row_musees['CODE_MUSEE'];
			$nom_musee_select = $row_musees['NOM'];
		} while ($row_musees = mysql_fetch_assoc($musees));
	}
	// V�rification identification

	if ($code_musee == $codeMusee_select || $code_musee==0)
	{
	$existe = ( (! empty($motdepasse)) and ($motdepasse == md5($mot_de_passe)));
	if(!empty($existe)) {
		$_SESSION["droit"] = $droit;
		$_SESSION["nom"] = $nom;
		$_SESSION["prenom"] = $prenom;
		$_SESSION["idutil"] = $idutil;
		$_SESSION["code_musee"] = $codeMusee_select;
		$_SESSION["musee"] = $nom_musee_select;
		$_SESSION["site"] = "prod";//s�curit� pour ne pas que l'utilisateur arrive de test
		//cr�ation de l'objet pour lire dans le fichier texte
		$objet = new GestionConfig("../config/config.txt");
		
		$_SESSION["internet"] = $objet->internet;
		$_SESSION["max_transfert"] = $objet->max_transfert;
		$_SESSION["images"] = $objet->images;
		
		if ($objet->internet == "true") {
			$_SESSION["aide"] = "https://bases.alienor.org/leconseiller/index.htm";
			$_SESSION["thesaurus"] = "http://www.alienor.org/Alienorweb/Public/";
		} else {
			$_SESSION["aide"] = "../leconseillerAWL/index.htm";
			$_SESSION["thesaurus"] = "./theso_local.php";
			//todo arranger le thesaurus local
		}
	}
	}
	return (bool)$existe;
	mysql_free_result($utilis);
}

function count_users()
{
	$nb = 0;
	include(dirname(__FILE__).'/../Connections/alienorweblibre.php');
	
	// Recherche de l'utilisateur et de ses divers param�tres
	mysql_select_db($database_alienorweblibre, $alienorweblibre);
	$query_utilis = "SELECT COUNT(per_index) as nb FROM utilisateur";
	$utilis = mysql_query($query_utilis, $alienorweblibre) or die(mysql_error());
	$row_utilis = mysql_fetch_assoc($utilis);
	$totalRows_utilis = mysql_num_rows($utilis);
	do {
		$nb = $row_utilis["nb"];
	} while ($row_utilis = mysql_fetch_assoc($utilis));

	return $nb;
	mysql_free_result($utilis);
}

?>