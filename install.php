<?php
    include('config/config.php');
    $niveau_visa = $admin;
	require_once('Connections/alienorweblibre.php');
	include('include/fonctions.php');

/******** Initialisation des variables *******/
$page = "ethno";
$msg = "";
$nom = "";
$prenom = "";
$login = "";
$mot_de_passe = "";
/*********************************************/

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

/******* Inserer un utilisateur *******/
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "utilisateur") && ($_POST['nom'] != "")) {
  $mdp = GetSQLValueString($_POST['mot_de_passe'], "text");
  $_POST['mot_de_passe'] = md5($_POST['mot_de_passe']);
  $insertSQL = sprintf("INSERT INTO utilisateur (nom,prenom,login,mot_de_passe,droit) VALUES (%s,%s,%s,%s,%s)",
                       GetSQLValueString($_POST['nom'], "text"),
					   GetSQLValueString($_POST['prenom'], "text"),
					   GetSQLValueString($_POST['login'], "text"),
					   GetSQLValueString($_POST['mot_de_passe'], "text"),
					   GetSQLValueString($_POST['droit'], "int"));
					   
	/******* V�rification login pour �viter les doublons *******/
	mysql_select_db($database_alienorweblibre, $alienorweblibre);
	$query_utilisateur = "SELECT * FROM utilisateur WHERE login = '".$_POST['login']."'";
	$utilisateur = mysql_query($query_utilisateur, $alienorweblibre) or die(mysql_error());
	$row_utilisateur = mysql_fetch_assoc($utilisateur);
	$totalRows_utilisateur = mysql_num_rows($utilisateur);
	/***********************************************************/
	
	if ($totalRows_utilisateur == 0) {
		mysql_select_db($database_alienorweblibre, $alienorweblibre);
		$Result = mysql_query($insertSQL, $alienorweblibre) or die(mysql_error());
		$id_utilisateur = mysql_insert_id();
		mkdir("imagesDoc/".$_POST['code_musee']);
		mkdir("imagesDoc/SUPER");
		$msg = "<br>Utilisateur AlienorWeb Libre ins�r� avec succ�s<br>";
		
		$insertMusee = sprintf("INSERT INTO musee (MUS_INDEX,CODE_MUSEE,NOM,cpt_objets,cpt_lieux,cpt_personnes,cpt_documentations) VALUES (NULL,'".$_POST['code_musee']."','".$_POST['nom_musee']."','".$_POST['cpt_objets']."','".$_POST['cpt_lieux']."','".$_POST['cpt_personnes']."','".$_POST['cpt_documentations']."')");
		$Resultat = mysql_query($insertMusee, $alienorweblibre) or die(mysql_error());
		$id_musee = mysql_insert_id();
		$insertLIEN = sprintf("INSERT INTO user_musee (INDEX_USE_LIEU,INDEX_USER,INDEX_MUSEE) VALUES (NULL,'$id_utilisateur','$id_musee')");
		$Resultat2 = mysql_query($insertLIEN, $alienorweblibre) or die(mysql_error());	
		
		
		echo $msg;
		
        /******************************************/



        $os = array(
            "CYGWIN_NT-5.1" => "Unix",
            "Darwin" => "Unix",
            "FreeBSD" => "Unix",
            "HP-UX" => "Unix",
            "IRIX64" => "Unix",
            "Linux" => "Unix",
            "NetBSD" => "Unix",
            "OpenBSD" => "Unix",
            "SunOS" => "Unix",
            "Unix" => "Unix",
            "WIN32" => "Windows",
            "WINNT" => "Windows",
            "Windows" => "Windows"
        );
    



		$fichier =fopen("./config/config.txt","w");
        if($os[PHP_OS] == 'Unix')
            $defautPath = '../imageDoc';
        else
            $defautPath = 'c:\wamp\www\AlienorWebLibre\imagesDoc';
            

		$taille = $_POST['max_transfert'] * 1000;
		if ($_POST['images'] != "") {
			$repImg = $_POST['images'];
			$defautImage = @file_get_contents($defaultPath."\visuel_de_remplacement.jpg") or die ("Visuel de remplacement not found");
			$fimage = fopen($_POST['images'],"w");
			fwrite($fimage,$defautImage);
			fclose($fimage);
		}else{
			$repImg = $defautPath;
		}
		
		fwrite($fichier,";**************************************** \r\n
						; fichier de configuration d'AWL \r\n
						;**************************************** \r\n

						; Lieu de stockage des images \r\n
						; Attention ce r�pertoire doit �tre accessible par le serveur web \r\n
						images = \"".$repImg."\" \r\n

						;Acc�s � internet \r\n
						; mettre la valeur � true si le poste acc�de � internet, false sinon \r\n
						internet = \"".$_POST['internet']."\" \r\n

						; Taille maximum du transfert accepter par le serveur en upload \r\n
						max_transfert = \"".$taille."\"\r\n");
		fclose($fichier);
		
		/******************************************/
		
        
        if($os[PHP_OS] == 'Windows')
        {
    		/**********************************/
    		/* debut modification du php.ini */
    		/*********************************/
    				// on charge le fichier de conf locale
    		$wampConfFile = '../../wampmanager.conf';
    		if (!is_file($wampConfFile))
        		die ('Unable to open WampServer\'s config file, please change path in index.php file');
    			//require $wampConfFile;
    		$fp = fopen($wampConfFile,'r');
    		$wampConfFileContents = fread ($fp, filesize ($wampConfFile));
    		fclose ($fp);
    		preg_match('|phpVersion = (.*)\n|',$wampConfFileContents,$result);
    		$phpVersion = str_replace('"','',$result[1]);
    		$phpinifile = "../../bin/php/php".$phpVersion."/php.ini";
    		$myphpini = @file_get_contents($phpinifile) or die ("php.ini file not found");
    		$myphpini = ereg_replace('upload_max_filesize = 2M','upload_max_filesize = '.$_POST['max_transfert'].'M',$myphpini);
    		$fpphpini = fopen($phpinifile,"w");
    		fwrite($fpphpini,$myphpini);
    		fclose($fpphpini);
    		/**********************************/
    		/* fin modification du php.ini   */
    		/*********************************/
            
            
    		/**********************************/
    		/*debut modification du httpd.conf*/
    		/*********************************/
    		$wampConfFile = '../../wampmanager.conf';
    		if (!is_file($wampConfFile))
        		die ('Unable to open WampServer\'s config file, please change path in index.php file');
    			//require $wampConfFile;
    		$fp = fopen($wampConfFile,'r');
    		$wampConfFileContents = fread ($fp, filesize ($wampConfFile));
    		fclose ($fp);
    		preg_match('|apacheVersion = (.*)\n|',$wampConfFileContents,$result);
    		$apacheVersion = str_replace('"','',$result[1]);
    		$httpdfile = "../../bin/apache/apache".$apacheVersion."/conf/httpd.conf";
    		$txt = "\n<Directory \"C:/wamp/www/AlienorWebLibre\">\nOrder Deny,Allow\nAllow from ";
    		switch ($_POST['serveur']){
    			case 'internet':	$txt = $txt."all";
    								break;
    			case 'intranet' :	$txt = $txt.$_POST['plage'];
    								break;
    			default :			$txt = $txt."127.0.0.1";
    								break;
    		};
    		$txt = $txt."\n</Directory>\n";
    		$myhttpd = @file_get_contents($httpdfile) or die ("httpd.conf file not found");
    		$myhttpd = $myhttpd.$txt;
    		$fhttpd = fopen($httpdfile,"w");
    		fwrite($fhttpd,$myhttpd);
    		fclose($fhttpd);
    		/**********************************/
    		/* fin modification du httpd.conf */
    		/*********************************/
        }
        else 
        {
            $fp = fopen('./.htaccess', 'w');
            if($fp)
            {
                $htaccess = 'ErrorDocument 404 ./alienorweblibre/erreur404.html'.chr(13);
                $htaccess .= 'ErrorDocument 403 ./alienorweblibre/erreur403.html'.chr(13);
                $htaccess .= 'Order Deny,Allow'.chr(13);
                $htaccess .= 'Deny from All'.chr(13);
                $htaccess .= 'Allow from ';
            	switch ($_POST['serveur']){
        			case 'internet':	$htaccess .= "all";
        								break;
        			case 'intranet' :	$htaccess .= $_POST['plage'];
        								break;
        			default :			$htaccess .= "127.0.0.1";
        								break;
        		};
        		if(fwrite($fp,$htaccess))
                    fclose($fp);
                else 
                {
                    die("could not create htaccess");
                    fclose($fp);
                }
            }
            else
                die("could not create htaccess");
        }
            
            
            
	
		echo "<script>window.close()</script>";
		unlink("install.php");
	} else {
		$msg = "Ce login existe d�j�";
	}	
}
/********************************************/

/******** Affichage des utilisateurs *******/
mysql_select_db($database_alienorweblibre, $alienorweblibre);
$query_utilisateur = "SELECT * FROM utilisateur ORDER BY nom ASC";
$utilisateur = mysql_query($query_utilisateur, $alienorweblibre) or die(mysql_error());
$row_utilisateur = mysql_fetch_assoc($utilisateur);
$totalRows_utilisateur = mysql_num_rows($utilisateur);
/********************************************/
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="fr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="pragma" content="no-cache">
<title>Installation des parametre de votre base</title>
<link href="style/style_awl.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
<!--
function verifMdp() {
	if (document.utilisateur.mot_de_passe.value != document.utilisateur.mot_de_passe1.value) {
		alert("ATTENTION :\n\nLes mots de passe ne sont pas identique");
		document.utilisateur.mot_de_passe.value = '';
		document.utilisateur.mot_de_passe1.value = '';
		document.utilisateur.mot_de_passe.select();
		document.utilisateur.mot_de_passe.focus();
	}
}

function confirmer() {
	if (confirm('Voulez vous supprimer cet utilisateur ?')) {
	document.supprimer.submit();	
	} else {
		return false;
	}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_validateForm() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' doit contenir une adresse mail.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' doit contenir un nombre.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' doit �tre compris entre '+min+' et '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' est requis.\n'; }
  } if (errors) alert('Quelques omissions ou erreurs ont �t� trouv�es :\n'+errors);
  document.MM_returnValue = (errors == '');
}
//-->
</script>
<style type="text/css">
<!--
th {
	background-color: #D8D8D8;
	text-align: center;
	font-weight: bold;
}
.L1 {
	background-color: #FAFAFA;
}
.L2 {
	background-color: #F3F3F3;
}
-->
</style>
</head>
<body>


<div id="haut">
	<h1>&nbsp;</h1>
    <h2>S&eacute;curisation : cr&eacute;ation de l'administrateur</h2>
</div>
<div class="centre">
    <form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="utilisateur">
        <table cellspacing="0" class="bd-tbl-mr">
            <tr>
                <td colspan="2" align="center" class="titre-tbl"><b>Administrateur</b></td>
            </tr>
            <tr>
                <td align="right">
                    <label for="nom">Nom&nbsp;:</label>                </td>
                <td align="left">
                    <input type="text" name="nom" id="nom" size="32" accesskey="N" tabindex="1" value="Nom">                </td>
            </tr>
            <tr>
                <td align="right">
                    <label for="prenom">Pr&eacute;nom&nbsp;:</label>                </td>
                <td align="left">
                    <input type="text" name="prenom" id="prenom" size="32" accesskey="P" tabindex="2" value="Prénom">                </td>
            </tr>
            <tr>
                <td align="right">
                    <label for="login">Login&nbsp;:</label>                </td>
                <td align="left">
                    <input type="text" name="login" id="login" size="32" accesskey="L" tabindex="3" value="Administrateur">                </td>
            </tr>
            <?php if (isset($_POST["module"]) && $_POST["module"] != "utilisateur" || $per_index == 0) { ?>
                <tr>
                    <td align="right">
                        <label for="mot_de_passe">Mot&nbsp;de&nbsp;passe&nbsp;:</label>                    </td>
                    <td align="left">
                        <input type="password" name="mot_de_passe" id="mot_de_passe" size="32" accesskey="M" tabindex="4" value="">                    </td>
                </tr>
                <tr>
                    <td align="right">
                        <label for="mot_de_passe1">Confirmer&nbsp;mot&nbsp;de&nbsp;passe&nbsp;:</label>                    </td>
                    <td align="left">
                        <input type="password" name="mot_de_passe1" id="mot_de_passe1" value="" size="32" accesskey="C" tabindex="5" onBlur="verifMdp()">                    </td>
                </tr>
                <?php } ?>
            <tr>
                <td align="right">
                    <label for="droit">Droit&nbsp;:</label>                </td>
                <td align="left" valign="middle">
                    <input type="radio" name="droit" id="droit" value="50" checked tabindex="6">
                    <label for="droit">Administrateur</label>
                    &nbsp; </td>
            </tr>
            <tr>
              <td align="right">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2" align="center" class="titre-tbl"><strong>Mus&eacute;e</strong></td>
            </tr>
            <tr>
              <td align="right"><label>Nom du mus&eacute;e</label></td>
              <td><input name="nom_musee" type="text" id="nom_musee">              </td>
            </tr>
            <tr>
              <td align="right">Code mus&eacute;e </td>
              <td><input name="code_musee" type="text" id="code_musee" size="6" maxlength="5"></td>
            </tr>
            <tr>
              <td align="right">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2" align="center" class="titre-tbl"><p>Acc&egrave;s internet </p>              </td>
            </tr>
            <tr>
              <td colspan="2" align="center">Pouvez-vous acceder &agrave; internet &agrave; partir des postes de saisie :</td>
            </tr>
            <tr>
              <td align="center"><label></label><input name="internet" type="radio" value="true" checked>
Oui</td>
              <td align="center"><input type="radio" name="internet" value="false">
                Non</td>
            </tr>
            <tr>
              <td align="right">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2" align="center" class="titre-tbl">Compteurs</td>
            </tr>
            <tr>
              <td align="right">OBJETS</td>
              <td>
              <input name="cpt_objets" type="text" id="cpt_objets" value="000000" size="7" maxlength="6"></td>
            </tr>
            <tr>
              <td align="right">LIEUX</td>
              <td><input name="cpt_lieux" type="text" id="cpt_lieux" value="000000" size="7" maxlength="6"></td>
            </tr>
            <tr>
              <td align="right">Personnes</td>
              <td><input name="cpt_personnes" type="text" id="cpt_personnes" value="000000" size="7" maxlength="6"></td>
            </tr>
            <tr>
              <td align="right">Documentations</td>
              <td><input name="cpt_documentations" type="text" id="cpt_documentations" value="000000" size="7" maxlength="6"></td>
            </tr>
            <tr>
              <td align="right">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2" align="center" class="titre-tbl">Images</td>
            </tr>
            <tr>
              <td align="right">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td align="right">Taille maximum du transfert</td>
              <td><input name="max_transfert" type="text" id="max_transfert" value="5" size="4" maxlength="3">
                M0 </td>
            </tr>
            <tr>
              <td colspan="2"><p class="centre">Chemin du r&eacute;pertoire de stockage sur le serveur.</p>
                <p>Inscrivez le chemin complet &agrave; partir de la racine par exemple : &quot;c:\mesimages\images_bases&quot;.</p>
                <p>Vous devez vous assurer au pr&eacute;alable que le r&eacute;pertoire  ait les autorisations n&eacute;cessaires &agrave; l'acc&egrave;s par le serveur. </p>
                <p> 
              Par d&eacute;faut le r&eacute;pertoire est le r&eacute;pertoire d'installation/imagesDoc</p>
                <p>&nbsp;</p></td>
            </tr>
            <tr>
              <td align="right">Chemin : </td>
              <td><input name="images" type="text" size="50"></td>
            </tr>
            <tr>
              <td align="right">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2" align="center" class="titre-tbl">Serveur</td>
            </tr>
            <tr>
              <td colspan="2" align="left"><p>Votre AWL doit pouvoir &ecirc;tre accessible depuis :</p>
              </td>
            </tr>
            <tr>
              <td colspan="2" align="center"><table width="750" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="30%" valign="top"><input name="serveur" type="radio" value="machine" checked>
                    cette machine uniquement </td>
                  <td width="30%"><p>
                    <input type="radio" name="serveur" value="intranet">
                    tout l'intranet </p>
                  <p>plage d'adresse :
                    <input name="plage" type="text" id="plage" size="16" maxlength="15">
</p></td>
                  <td width="30%" valign="top"><input type="radio" name="serveur" value="internet">
                  internet</td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td align="right">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
                <td align="right">&nbsp;</td>
                <td> 
                        <input name="inserer" type="submit" accesskey="I" onClick="MM_validateForm('nom','','R','prenom','','R','login','','R','nom_musee','','R','code_musee','','R');return document.MM_returnValue" value="Valider">
                        <input type="hidden" name="MM_insert" value="utilisateur">                        </td>
            </tr>
            <tr>
                <td colspan="2" align="right">
                    <p style="text-align:center; color:#FF0000; font-weight:bold"> <?php echo $msg; ?> </p>                </td>
            </tr>
        </table>
    </form>
</div>
<br>
<div class="centre"></div>
</body>
</html>
<?php
mysql_free_result($utilisateur);
?>