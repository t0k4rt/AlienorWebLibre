<?php
	session_start();

	require_once('../config/config.php');
	$niveau_visa = $mcr;
	$page = "persmor";
	include('../include/securite.php');
	include('../include/fonctions.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="fr">
<head>
<title>Formulaire de recherche : Personne physique</title>
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
    <h2>Formulaire de recherche Personne Morale </h2>
</div>
<div id="s-menu">
    <div id="menu"><a href="#IDENTIFICATION">Identification</a> <span class="invisible">|</span> <a href="#ADRESSE">Adresse</a> <span class="invisible">|</span> <a href="#INFORMATIQUE">Gestion&nbsp;informatique</a></div>
    <div id="btnvalid">
        <input name="image" type="image" onClick="document.fiche.submit();" src="../images/valider.gif">
    </div>
</div>
<div class="spacer"> </div>
<div id="formulaire">
    <form name="fiche" method="post" action="../masques/rep_personne.php">
        <!-- ZONE IDENTIFICATION -->
        <div><a name="IDENTIFICATION"></a></div>
        <table cellpadding="3" cellspacing="0" class="centpcent">
            <tr>
                <td colspan="4" class="titre-tbl">IDENTIFICATION</td>
            </tr>
            <tr>
                <td>
                    <span class="obligatoire"><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=TYPERS&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=TYPE_PERSONNE');">Type de personne</a></span>
                    <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,2104)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a></td>
                <td>Sigle <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,2102)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a></td>
            </tr>
            <tr>
                <td>
                    <input name="TYPE_PERSONNE" type="text" class="motcles" id="TYPE_PERSONNE">
                </td>
                <td>
                    <input name="NOM_MARITAL" type="text" class="motcles" id="NOM_MARITAL">
                </td>
            </tr>
            <tr>
                <td>
                    <span class="obligatoire"><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=AUT&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=ETAT_CIVIL');">Nom (autre appelation)</a></span>
                    &nbsp;<a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,2101)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a></td>
                <td>
                    <span class="obligatoire"><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=SEXE&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=GENRE');">Genre</a></span>
                    <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,2103)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a></td>
            </tr>
            <tr>
                <td>
                    <input name="ETAT_CIVIL" type="text" class="motcles" id="ETAT_CIVIL">
                </td>
                <td>
                    <input name="GENRE" type="text" class="motcles" id="GENRE">
                </td>
            </tr>
            <tr>
                <td>
                    <span><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=TLIEU&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=LIEU_NAISSANCE');">Lieu de cr&eacute;ation </a></span>
                    <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,2111)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>
                    <input name="LIEU_NAISSANCE" type="text" class="motcles" id="LIEU_NAISSANCE">
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>
                    <span><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=TLIEU&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=LIEU_DECES');">Lieu de disparition</a></span>
                    <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,2113)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>
                    <input name="LIEU_DECES" type="text" class="motcles" id="LIEU_DECES">
                </td>
                <td>&nbsp;</td>
            </tr>
        </table>
        <br>
        <!-- ZONE Adresse -->
        <div><a name="ADRESSE"></a></div>
        <table cellpadding="3" CELLSPACING="0" class="centpcent">
            <tr>
                <td colspan="3" class="titre-tbl">ADRESSE</td>
            <tr>
                <td>
                    <span><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=TLIEU&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=LIEU_RESIDENCE');">Lieu de r&eacute;sidence</a></span>
                    <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,2224)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a></td>
                <td>Site internet <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,2222)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a></td>
                <td>Ad&egrave;le <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,2223)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a></td>
            </tr>
            <tr>
                <td>
                    <input name="LIEU_RESIDENCE" type="text" class="motcles" id="LIEU_RESIDENCE">
                </td>
                <td>
                    <input name="SITE_INTERNET" type="text" class="motcles" id="SITE_INTERNET">
                </td>
                <td>
                    <input name="ADELE" type="text" class="motcles" id="ADELE">
                </td>
            </tr>
            <tr>
                <td>
                    <span><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=TLIEU&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=LIEU_RESIDENCE');">Si&egrave;ge social </a></span>
                    <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,2224)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a></td>
                <td>
                    <span>Commentaire</span>
                    <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,2107)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>
                    <input name="LIEU_TRAVAIL" type="text" class="motcles" id="LIEU_TRAVAIL">
                </td>
                <td>
                    <input name="COMMENTAIRE" type="text" class="motcles" id="COMMENTAIRE">
                </td>
                <td>&nbsp;</td>
            </tr>
        </table>
        <br>
        <!-- ZONE INFORMATIQUE -->
        <div><a name="INFORMATIQUE"></a></div>
        <table cellpadding="3" cellspacing="0" class="centpcent">
            <tr>
                <td colspan="5" class="titre-tbl">GESTION INFORMATIQUE</td>
            </tr>
            <tr>
                <td>Code mus&eacute;e&nbsp;<a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1912)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a></td>
                <td>Num&eacute;ro de fiche&nbsp;<a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1911)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
                <td>Copyright&nbsp;<a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1902)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a></td>
            <tr>
                <td>
                    <input name="CODEMUSEE" type="text" class="motcles">
                </td>
                <td>
                    <input name="COPYRIGHT" type="text" class="motcles">
                </td>
                <td>
                    <input name="INDEX_PERSONNE" type="text" class="motcles">
                </td>
            </tr>
            <tr>
                <td>Fiche cr&eacute;&eacute;e par&nbsp;<a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1904)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
                <td>Fiche cr&eacute;&eacute;e le&nbsp;<a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1903)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
                <td>Fiche mise &agrave; jour le&nbsp;<a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1905)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
            </tr>
            <tr>
                <td>
                    <input name="FICHE_CREEE_PAR" type="text" class="motcles">
                </td>
                <td>
                    <input name="FICHE_CREEE_LE" type="text" class="motcles">
                </td>
                <td>
                    <input name="MISE_A_JOUR" type="text" class="motcles">
                </td>
            </tr>
            <tr>
                <td>Identifiant National&nbsp;<a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1901)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>
                    <input name="INDENTIFIANT_NATIONAL" type="text" class="motcles">
                    <input name="page" type="hidden" class="motcles" value="<?php echo $page ?>">
                </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        </table>
        <div><a name="FIN_FORMULAIRE"></a></div>
    </form>
</div>
</body>
</html>
