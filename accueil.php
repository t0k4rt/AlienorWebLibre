<?php
	require_once('config/config.php');
	$niveau_visa = $mcr;
	include('include/version.php');
	include('include/securite.php');
	isset($_GET['formu']) ? $lstformu = $_GET['formu'] : $lstformu = '' ;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="fr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Alienor Web Libre</title>
<link href="style/style_awl.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
<!--
function routage(ident) {
	(ident == 'mr') ? param = '' : param = '?noFiche=0' ;
	if (ident == 'ms' && document.box.masques.value == 'gestion') {
		alert('La \"gestion\" n\'est pas disponible en saisie directe   ');	
	} else {
		url = '/alienorweblibre/masques/' + ident + '_' + document.box.masques.value + '.php' + param;
		// document.write('URL =' + url);
		window.open(url);
	}
}

function recharge_page() {
	var query = location.search.substring(1);
	if (arguments.length == 1) query = change_query(query, arguments[0]);
	else {
		for (var i=0;i<arguments.length;i++) query = change_query(query, arguments[i]);
		}
		location.href = location.pathname + (query ? "?" + query : "");
}

function change_query(query, param) {
 // d�coupe param "variable=valeur" en variable et valeur
	var pos = param.indexOf("=");
	if (pos == -1) {
	   var variable = param;
	   var valeur = "";
	} else {
		var variable = param.substring(0, pos+1); // "variable="
		if (pos == param.length-1) var valeur = "";
		else var valeur = param.substring(pos+1); // "valeur"
	}
	if (variable == "*") query = "";
		// si on a d�j� des param�tres
	else if (query) {
		// la variable n'est pas trouv�e dans la cha�ne query : on rajoute param au query
		if (query.indexOf(variable) == -1) query += valeur ? "&" + param : "";
			// sinon, il se peut qu'elle y ait, mais on peut avoir aussi "id_page=" alors qu'on cherche "page="
		else {
			var params = query.split("&");
			var num_param = ordre_param(params, variable.substring(0, variable.length-1));
				// si le param�tre n'existe pas d�j� dans le query, on le rajoute � la fin
			if (num_param == -1) query += valeur ? "&" + param : "";
				// sinon on le change ou on le supprime (si valeur est vide)
			else {
				if (valeur) params[num_param] = param;
				else params.splice(num_param, 1);
				query = params.length ? params.join("&") : "";
			}
		}
	}
	// on n'a pas de param�tre actuellement, le query = le param
	else if (valeur) query = param;
	return query;
}

function ordre_param(params, variable) {
	var i = 0;
	while (i<params.length) {
		var elts_param = params[i].split("=");
		if (elts_param[0] == variable) break;
		else i++;
	}
	if (i == params.length) return -1;
	else return i;
}
//-->
</script>
</head>
<body>
<div id="accueil">
    <h1><span class="invisible">Alienor Web Libre</span></h1>
</div>
<div align="center"><img src="images/logo_cirm.jpg" alt="Logo du Conseil Interr&eacute;gional des mus&eacute;es" width="195" height="113" style="border:none"></div>
<div id="parametre"> <br>
    <p style="text-align:center; font-weight:bold"><?php echo $_SESSION["prenom"]." ".$_SESSION["nom"]; ?></p>
    <p style="text-align:center; font-weight:bold"><?php echo $_SESSION["musee"]; ?></p>
    <p>Table :</p>
    <div style="text-align:center"> <a href="accueil.php?formu=objet"><img src="images/objets.gif" width="36" height="36" alt="Objets" style="border:none"></a> &nbsp; <a href="accueil.php?formu=personnes"><img src="/alienorweblibre/images/personnes.gif" width="36" height="36" alt="Personnes" style="border:none"></a> &nbsp; <a href="accueil.php?formu=lieux"><img src="/alienorweblibre/images/lieux.gif" width="36" height="36" alt="Lieux" style="border:none"></a> &nbsp; <a href="accueil.php?formu=documentations"><img src="/alienorweblibre/images/documentations.gif" width="36" height="36" alt="Documentations" style="border:none"></a> &nbsp; <a href="accueil.php?formu=gestion"><img src="/alienorweblibre/images/gestion.gif" width="36" height="36" alt="Gestion" style="border:none"></a> </div>
</div>
<?php
/*
debug
require_once('./include/GestionConfig.class.php');



$gestion = new GestionConfig("../config/config.txt");

echo $gestion->__toString()."<br><br><br>";

echo $gestion->chemin()."<br><br><br>";

echo dirname(__FILE__)."<br><br><br>";

print_r(parse_ini_file("/home/alexandre/dev/php/alienorweblibre/include/../config/config.txt"));



print_r($_SESSION);
*/
$filename = "./.htaccess";
$handle = fopen($filename, "a+");

echo fread($handle, filesize($filename));




?>
<div id="boite">
    <p>Masque :</p>
    <div align="center">
        <form name="box" action="accueil.php">
            <?php
			switch ($lstformu) {
				case "personnes" : ?>
            <select name="masques" style="background: #EEEEEE" title="S&eacute;lection des masques des personnes">
                <option value="personne" selected>Personne physique</option>
                <option value="persmor">Personne morale</option>
                <option value="grphumain">Groupe Humain</option>
            </select>
            <?php	break;
			case "lieux" : ?>
            <select name="masques" style="background: #EEEEEE" title="S&eacute;lection du masque des lieux">
                <option value="lieu" selected>Lieux</option>
            </select>
            <?php	break; 
			case "documentations" : ?>
            <select name="masques" style="background: #EEEEEE" title="S&eacute;lection des masques des documentations">
                <option value="documentation" selected>Documentation</option>
                <option value="exposition">Exposition</option>
                <option value="docphoto">Photo</option>
                <option value="edition">&Eacute;dition</option>
            </select>
            <?php	break;
			case "gestion" : ?>
            <select name="masques" style="background: #EEEEEE" title="S&eacute;lection du masque de gestion">
                <option value="gestion" selected>Gestion</option>
            </select>
            <?php	break; 
				default : ?>
            <select name="masques" style="background: #EEEEEE" title="S&eacute;lection des masques des objets">
                <option value="ethno" selected>Ethnographie</option>
                <option value="ba">Art</option>
                <option value="archeo">Arch&eacute;ologie</option>
                <option value="litho">Lithoth&egrave;que</option>
                <option value="vivant">Vivant</option>
            </select>
            <?php } ?>
        </form>
    </div>
</div>
<div id="action">
    <a href="javascript:routage('mr');">
        Rechercher
        <img src="images/rech_form.jpg" alt="Rechercher par crit&egrave;res" width="48" height="48" border="0" style="border:1px solid #000000">
    </a>&nbsp;
    
    <a href="javascript:routage('ms');">
        Créer
        <img src="/alienorweblibre/images/creer_ligne.jpg" alt="Cr&eacute;er une fiche" width="48" height="48" border="0" style="border:1px solid #000000">
    </a>&nbsp;
    
    <img src="/alienorweblibre/images/gest_edition.jpg" alt="Afficher les cartels" width="48" height="48" style="border:1px solid #000000">&nbsp;
    
    <a href="https://bases.alienor.org/leconseiller/index.htm" target="_blank">
        Accueil
        <img src="/alienorweblibre/images/aide.jpg" alt="Acc&egrave;s &agrave; l'aide en ligne" width="48" height="48" border="0" style="border:1px solid #000000">
    </a> 
    
    <a href="deconnexion.php" target="_self">
        Déconnexion
        <img src="images/deconnection.jpg" alt="Se d&eacute;connecter" width="48" height="48" border="0" style="border:1px solid #000000;">
    </a>
</div>
<div id="bas">
    <p class="copyright">&copy; Copyright Alienor Web Libre <?php echo $version?></p>
</div>
</body>
</html>
