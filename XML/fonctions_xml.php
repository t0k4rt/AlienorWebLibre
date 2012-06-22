<?php
// Début traitement des dates
function traitementDate($xml,$cons_nom) {
	global $requete, $valeur;
	$cons_depth = $xml->depth;
	print("<br><b>Début date :</b><br>\n");
	print("<br>Conservation du nom :".$cons_nom."<br>\n");
	$memo = true;
	do {
		if($xml->nodeType == 1)
			{
				if ($multiname == $xml->name)
				{ // si balise se répéte
					//print("Nom : ".$xml->name);
					$multival = 1;
					$multiname = $xml->name;
				} else {
					//print("Nom : ".$xml->name);
					$multiname = $xml->name;
					$multival = 0;
				} // fin mulitname
			} // Fin nodeType = 1
			if ($xml->nodeType == 3 && $xml->value != "") // si présence valeur dans la balise
			{
				if ($memo)
				{
					($valeur) ? $valeur = $valeur."," : $valeur ;
					($requete) ? $requete = $requete.",".$cons_nom : $requete = $cons_nom;
					$memo = false;
				}
				if ($multival == 0)
				{
					print("NM".$xml->value);
					($valeur) ? $valeur = $valeur.",".preg_replace('/^(.{2}).(.{2}).(.{4})$/','$3-$2-$1',trim((string)$xml->value)) : $valeur = preg_replace('/^(.{2}).(.{2}).(.{4})$/','$3-$2-$1',trim((string)$xml->value));
					($requete) ? $requete = $requete.",".$multiname : $requete = $multiname;
				} else {
					print("<b>M</b>".$xml->value);
					($valeur) ? $valeur = $valeur."/".preg_replace('/^(.{2}).(.{2}).(.{4})$/','$3-$2-$1',trim((string)$xml->value)) : $valeur = preg_replace('/^(.{2}).(.{2}).(.{4})$/','$3-$2-$1',trim((string)$xml->value));
				}
			} // Fin nodeType = 3
		$xml->read();
	} while (($xml->depth > $cons_depth) || ($xml->nodeType <> 15)); // jusqu'à fin noeud
	print("<br><b>Fin date :</b><br>");
}
// Fin traitement des dates
?>
