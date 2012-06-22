<?php
	session_start();
	require_once('../config/config.php');
	$niveau_visa = $mcr;
	$page = "lieu";
	include('../include/securite.php');
	include('../include/fonctions.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="fr">
<head>
<title>Formulaire de recherche : Lieux</title>
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
    <h2>Formulaire de recherche Lieu</h2>
</div>
<div id="s-menu">
    <div id="menu"><a href="#IDENTIFICATION">Identification</a> <span class="invisible">|</span> <a href="#ADRESSE">Adresse</a> <span class="invisible">|</span> <a href="#INFORMATIQUE">Gestion&nbsp;informatique</a></div>
    <div id="btnvalid">
        <input name="image" type="image" onClick="document.fiche.submit();" src="../images/valider.gif">
    </div>
</div>
<div class="spacer"></div>
<div id="formulaire">
    <form name="fiche" method="post" action="../masques/rep_lieu.php">
        <!-- ZONE IDENTIFICATION -->
        <div><a name="IDENTIFICATION"></a></div>
        <table cellpadding="3" cellspacing="0" class="centpcent">
            <tr>
                <td colspan="3" class="titre-tbl">IDENTIFICATION</td>
            </tr>
            <tr>
                <td>
                    <span class="obligatoire"><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=TLIEU&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=SITE');">Nom&nbsp;du&nbsp;lieu&nbsp;ou&nbsp;du&nbsp;site&nbsp;(identifiant)</a></span>
                    &nbsp;<a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,3101)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a></td>
                <td>
                    <span class="obligatoire"><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=TSITE&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=TYPE_SITE');">Type de lieu ou de site</a></span>
                    <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,3104)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>
                    <input name="SITE" type="text" class="motcles">
                </td>
                <td>
                    <input name="TYPE_SITE" type="text" class="motcles">
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>N&deg; de site SDA <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,3102)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a></td>
                <td>M&eacute;thode de collecte <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,3105)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a></td>
                <td>Pr&eacute;cision sur le site <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,3106)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a></td>
            </tr>
            <tr>
                <td>
                    <input name="NUMERO_SDA" type="text" class="motcles">
                </td>
                <td>
                    <input name="METHODE_COLLECTE" type="text" class="motcles">
                </td>
                <td>
                    <input name="PRECISION_SITE" type="text" class="motcles">
                </td>
            </tr>
            <tr>
                <td>Occupant <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,3108)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a></td>
                <td>P&eacute;riode d&#8217;occupation <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,3103)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>
                    <input name="OCCUPANT" type="text" class="motcles">
                </td>
                <td>
                    <table align="left" cellspacing="0">
                        <tr>
                            <td>Affixe</td>
                            <td>Date</td>
                            <td>&nbsp;</td>
                            <td>Date fin</td>
                        </tr>
                        <tr>
                            <td>
                                <select name="OCCUPANT_TXTDATE1">
                                    <option>-- Affixe --</option>
                                    <option value="LE">Le</option>
                                    <option value="AVANT">Avant</option>
                                    <option value="APRES">Apr&egrave;s</option>
                                    <option value="ENTRE">Entre</option>
                                </select>
                            </td>
                            <td>
                                <input name="OCCUPANT_DEBDATE1" type="text" class="inputnumerique">
                            </td>
                            <td>et</td>
                            <td>
                                <input name="OCCUPANT_FINDATE1" type="text" class="inputnumerique">
                            </td>
                        </tr>
                    </table>
                </td>
                <td>&nbsp;</td>
            </tr>
        </table>
        <br>
        <!-- ZONE ADRESSE -->
        <div><a name="ADRESSE"></a></div>
        <table cellpadding="3" cellspacing="0" class="centpcent">
            <tr>
                <td colspan="3" class="titre-tbl">ADRESSE</td>
            </tr>
            <tr>
                <td>Adresse <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,3209)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a></td>
                <td>T&eacute;l&eacute;phone <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,3210)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a></td>
                <td>Fax <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,3211)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a></td>
            </tr>
            <tr>
                <td>
                    <input name="ADRESSE" type="text" class="motcles">
                </td>
                <td>
                    <input name="TEL" type="text" class="motcles">
                </td>
                <td>
                    <input name="FAX" type="text" class="motcles">
                </td>
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
                <td>Copyright&nbsp;<a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1902)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
                <td>Num&eacute;ro de fiche&nbsp;<a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1911)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
            <tr>
                <td>
                    <input name="CODEMUSEE" type="text" class="motcles">
                </td>
                <td>
                    <input name="COPYRIGHT" type="text" class="motcles">
                </td>
                <td>
                    <input name="INDEX_LIEU" type="text" class="motcles">
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
                    <input name="IDENTIFIANT_NATIONAL" type="text" class="motcles">
                    <input name="page" type="hidden" class="motcles" value="<?php echo $page?>">
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
