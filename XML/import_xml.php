<?php 
header('Cache-Control: must-revalidate'); // forcer la remise en cache à chaque visite de la page

/*iconv_set_encoding('internal_encoding', 'UTF-8');
iconv_set_encoding('output_encoding', 'ISO-8859-1');
ob_start('ob_iconv_handler');*/

include('type.php');
include('../Connections/alienorweblibre.php');	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="fr" />
<meta http-equiv="pragma" content="no-cache" />
<meta http-equiv="cache-control" content="no-cache" />
<title>TEST importer un fichier XML</title>
</head>
<body>
<?php
// intialisation variables
$nombreobjet = 0;
$cons_nom = ""; // conservation du nom de la balise antérieure

if(file_exists("objets-mini.xml")) {
	
	$xml = new XMLReader();
	$xml->open("objets-mini.xml");
	
	$xml->setParserProperty(2, TRUE);
	
	while($xml->read()) {
/*		for ($i=0; $i<$xml->depth; $i++)
		{
			printf("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
			printf("\$xml->depth".$xml->depth."<br />\n");
			printf("\$xml->nodeType".$xml->nodeType."<br />\n");
			printf("\$xml->name".$xml->name."<br />\n");
			printf("\$xml->getAttribute(\"IDENTIFIANT_NATIONAL\")".$xml->getAttribute("IDENTIFIANT_NATIONAL")."<br />\n");
		}
*/
		
		switch ($xml->name) :
			case "OBJET" :
				$nbobj = $nbobj + 1;
				//echo("nombre objet = ".$nbobj."<br />\n");
				objet($xml,$xml->getAttribute("IDENTIFIANT_NATIONAL"));
				break;
			case "PERSONNE" :
				$nbper = $nbper + 1;
				//echo("nombre personne = ".$nbper."<br />\n");
				personne($xml,$xml->getAttribute("ETAT_CIVIL"));
				break;
			case "LIEU" :
				$nblie = $nblie + 1;
				//echo("nombre lieu = ".$nblie."<br />\n");
				lieu($xml,$xml->getAttribute("SITE"));
				break;
			case "DOCUMENTATION" :
				$nbdoc = $nbdoc + 1;
				//echo("nombre documentation = ".$nbdoc."<br />\n");
				documentation($xml,$xml->getAttribute("IDENTIFIANT"));
				break;
			default :
				break;
		endswitch;
	} // fin while lecture fichier
	
	// Fermer le Fichier
	$xml->close("objets-mini.xml");
	print("<br /><br /><br />\n");
} else {
	
	print("Attention fichier introuvable.!<br />\n");
	print("Pas de fichier objet.xml existant.!<br />\n");
	print("<br />\nListe des fichiers et répertoires présents :<br />\n");
	
	// fonction d'affichage du contenu du répertoire
	function AffDir($rep) {
		$dir = opendir($rep);
		while ($File = readdir($dir)) {
			if($File != "." && $File != "..") {
				echo "\t".$File."<br />\n";
			}
		}
		closedir($dir);
	}
	// fin fonction d'affichage du contenu du répertoire
	
	// affichage du contenu du répertoire
AffDir(".");
}
?>
</body>
</html>
