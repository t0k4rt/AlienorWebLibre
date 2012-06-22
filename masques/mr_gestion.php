<?php
	session_start();
	require_once('../config/config.php');
	$niveau_visa = $mcr;
	$page = "gestion";
	include('../include/securite.php');
	include('../include/fonctions.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="fr">
<head>
<title>Formulaire de recherche : gestion</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="pragma" content="no-cache">
<link href="../style/style_awl.css" rel="stylesheet" type="text/css" media="screen">
<link href="../style/style_awl_print.css" rel="stylesheet" type="text/css" media="print">
<script language="JavaScript1.2" type="text/javascript" src="../include/RoboHelp_CSH.js"></script>
<script type="text/javascript">
<!--
<?php creerFenetreTheso(); ?>
//-->
</script>
</head>
<body>
<?php include('../include/navigation.php'); ?>
<div id="haut">
    <h2>Formulaire de recherche Gestion</h2>
</div>
<div id="s-menu">
    <div id="menu"></div>
    <div id="btnvalid">
        <input name="image" type="image" onClick="document.fiche.submit();" src="../images/valider.gif">
    </div>
</div>
<div id="formulaire">
    <form name="fiche" method="post" action="../masques/rep_gestion.php">
        <div><a name="GESTION"></a></div>
        <table cellpadding="2" cellspacing="0" class="centpcent">
            <tr>
                <td class="titre-tbl">GESTION</td>
            </tr>
            <tr>
                <td>Emplacement <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide'];?>',HH_HELP_CONTEXT,5217)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></A></td>
            </tr>
            <tr>
                <td>
                    <input name="EMPLACEMENT" type="text" class="inputtextelibre">
                </td>
            </tr>
            <tr>
                <td>Valeur <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide'];?>',HH_HELP_CONTEXT,5107)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></A></td>
            </tr>
            <tr>
                <td>
                    <input name="VALEUR" type="text" class="inputtextelibre">
                </td>
            </tr>
            <tr>
                <td>&Eacute;tat&nbsp; <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide'];?>',HH_HELP_CONTEXT,5108)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></A></td>
            </tr>
            <tr>
                <td>
                    <input name="ETAT_CONSERVATION" type="text" class="inputtextelibre">
                </td>
            </tr>
        </table>
        <input name="page" type="hidden" value="<?php echo $page?>">
        <div><a name="FIN_FORMULAIRE"></a></div>
    </form>
</div>
</body>
</html>
