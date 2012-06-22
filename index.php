<?php

	include('include/version.php');
	include("include/fonctions.php");
	include('Connections/alienorweblibre.php');
	// Intialisation des variables
		$identifiant = "";
		$mot_de_passe = "";
		isset($_GET["msg"]) ? $message = rawurldecode($_GET["msg"]) : $message = "";
	// Traitement du formulaire
		if ((isset($_POST["inventaire"])) || (isset($_POST["administration"]))) {
			// R�cup�rer les informations saisie
			$identifiant = $_POST["identifiant"];
			$mot_de_passe = $_POST["mot_de_passe"];
			// V�rifier si l'utilisateur existe
			session_start();
			if(utilisateur_existe($identifiant,$mot_de_passe,0)) {		
				$host  = $_SERVER['HTTP_HOST'];
				$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
				if(isset($_POST["inventaire"])){
					$redirection = 'accueil.php';
				}else{
					$redirection = 'gestion/index.php';
				}
				header("location: http://$host$uri/$redirection");
				exit;
			} else {
				$message = "Identifiant ou mot de passe incorrecte<br />\n";	
			}
		}
		$nb = count_users();
		($nb<1 && file_exists('install.php'))?header("location: install.php"):"";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="fr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Alienor Web Libre : identification</title>
<link href="style/style_awl.css" rel="stylesheet" type="text/css">
</head>
<body>
<div align="center"><img src="images/ban-alienor.gif" alt="Alienor web libre" width="468" height="60"></div>
<div align="center"><img src="images/logo_cirm.jpg" alt="Logo du Conseil Interr&eacute;gional des Mus&eacute;es" width="195" height="113"></div>
<div align="center">
    <form method="post" action="index.php">
        <table class="bdr" summary="Tableau d'identification" cellspacing="0">
            <tr>
                <th scope="row" colspan="2" align="center">
                    <p style="font-weight:bold; color:#FF0000"><?php echo $message; ?></p>
                </th>
            </tr>
            <tr>
                <th scope="row" colspan="2" align="center" style="background:#CCCCCC"><b> Merci de vous identifier</b></th>
            </tr>
            <tr>
                <th scope="row" align="right">
                    <label for="identifiant">Login :</label>
                </th>
                <td align="left">
                    <input type="text" id="identifiant" name="identifiant" accesskey="L" tabindex="1" size="30" value="<?php echo vers_formulaire($identifiant); ?>">
                </td>
            </tr>
            <tr>
                <th scope="row" align="right">
                    <label for="mot_de_passe">Mot&nbsp;de&nbsp;passe&nbsp;:</label>
                </th>
                <td align="left">
                    <input type="password" id="mot_de_passe" name="mot_de_passe" accesskey="M" tabindex="2" size="30" value="">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <table align="center" width="100%">
                        <tr>
                            <td width="50%" align="center">
                                <input type="submit" name="inventaire" value="Inventaire" style="cursor:hand" accesskey="I" tabindex="3">
                            </td>
                            <td width="50%" align="center">
                                <input type="submit" name="administration" id="administration" style="cursor:hand" accesskey="A" tabindex="4" value="Administration">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" colspan="2" align="right" class="copyright">Alienor Web Libre <?php echo $version ?></th>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </form>
</div>
</body>
</html>