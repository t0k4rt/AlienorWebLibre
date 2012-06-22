<?php
//***************************************************************************************
	session_start();
	if (!isset($_SESSION["idutil"])){
		$msg = rawurlencode("Connection non autorisée, vous n&#8217;êtes pas identifié");
		$host  = $_SERVER['HTTP_HOST'];
		$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		header("location: http://$host/alienorweblibre/index.php?msg=$msg");
		exit;
	} else {
		if ($_SESSION["droit"] < $niveau_visa) {
			if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != "") {
				$redirection = $_SERVER['HTTP_REFERER'];
				header("location: $redirection");
				exit;
			} else { ?>	
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Document sans nom</title>
</head>
<body>
<p style="text-align:center; font-weight:bold">Vous n'avez pas les droits pour acc&eacute;der &agrave; cette zone</p>
<script language="javascript" type="text/javascript">
<!--
document.write("<p align=\"center\"><a href=\"#\" onClick=\"window.self.close();\">Fermer la fenêtre<\/a><\/p>")
//-->
</script>
</body>
</html>
<?php
			exit;
			}
		}
	}
?>
