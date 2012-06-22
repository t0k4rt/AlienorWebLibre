<?php
	session_start();
	require_once('../config/config.php');
	$niveau_visa = $mcr;
	$page = "exposition";
	include('../include/securite.php');
	include('../include/fonctions.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="fr">
<head>
<title>Formulaire de recherche : Exposition</title>
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
    <h2>Formulaire de recherche Exposition </h2>
</div>
<div id="s-menu">
    <div id="menu"><a href="#GENERALE">G&eacute;n&eacute;rale</a><span class="invisible">|</span> <a href="#INFORMATIQUE">Gestion&nbsp;informatique</a></div>
    <div id="btnvalid">
        <input name="image" type="image" onClick="document.fiche.submit();" src="../images/valider.gif">
    </div>
</div>
<div class="spacer"></div>
<div id="formulaire">
    <form name="fiche" method="post" action="../masques/rep_documentation.php">
        <!-- ZONE IDENTIFICATION -->
        <div><a name="GENERALE"></a></div>
        <table cellpadding="3" cellspacing="0" class="centpcent">
            <tr>
                <td colspan="3" class="titre-tbl">G&Eacute;N&Eacute;RALE</td>
            </tr>
            <tr>
                <td>
                    <span class="obligatoire">Identifiant</span>
                    <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4101)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a></td>
                <td>&nbsp; </td>
                <td>
                    <span class="obligatoire"><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=TYDOC&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=TYPE_DOCUMENT');">Type de document</a></span>
                    <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4123)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a></td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="text" name="IDENTIFIANT" id="IDENTIFIANT" size="90">
                </td>
                <td>
                    <input name="TYPE_DOCUMENT" type="text" class="motcles"  id="TYPE_DOCUMENT">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <span><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=AUT&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=AUTEUR');">Commissaire</a></span>
                    <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1413)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a></td>
                <td>
                    <span><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=AUT&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=EDITEUR');">Organisateur</a></span>
                    <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4107)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a></td>
            </tr>
            <tr>
                <td colspan="2">
                    <input name="AUTEUR" type="text" class="inputlong40" id="AUTEUR">
                </td>
                <td>
                    <input name="EDITEUR" type="text" class="motcles" id="EDITEUR">
                </td>
            </tr>
            <tr>
                <td><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=TLIEU&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=LIEU_EDITION');">Lieu d&#8217;&eacute;dition ou d&#8217;exposition</a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4108)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a></td>
                <td rowspan="2">
                    <table border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td colspan="4"><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=TLIEU&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=LIEU_EDITION');">Lieu d&#8217;&eacute;dition ou d&#8217;exposition</a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4108)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a></td>
                        </tr>
                        <tr>
                            <td>Affixe</td>
                            <td>Date</td>
                            <td>&nbsp;</td>
                            <td>Date fin</td>
                        </tr>
                        <tr>
                            <td>
                                <select name="TXTDATEEDITION" id="TXTDATEEDITION">
                                    <option selected>--</option>
                                    <option value="LE">Le</option>
                                    <option value="AVANT">Avant</option>
                                    <option value="APRES">Apr&egrave;s</option>
                                    <option value="ENTRE">Entre</option>
                                </select>
                            </td>
                            <td>
                                <input name="DEBDATEEDITION" type="text" class="inputnumerique" id="DEBDATEEDITION" maxlength="10">
                            </td>
                            <td>et</td>
                            <td>
                                <input name="FINDATEEDITION" type="text" class="inputnumerique" id="FINDATEEDITION" maxlength="10">
                            </td>
                        </tr>
                    </table>
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>
                    <input name="LIEU_EDITION" type="text" class="motcles" id="LIEU_EDITION">
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td colspan="2">Notes libres ou commentaires <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4104)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td colspan="2">
                    <input name="NOTE_LIBRE" type="text" class="inputlong40">
                </td>
            </tr>
            <tr>
                <td><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=DTECH&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=DESCRIPTION_TECHNIQUE');">Description technique</a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4105)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a></td>
                <td>Commentaires&nbsp;techniques&nbsp;ou&nbsp;description&nbsp;physique&nbsp;<a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4106)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a></td>
                <td><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=MOCLE&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=MOTS_CLES');">Mots Cl&eacute;s</a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4112)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a></td>
            </tr>
            <tr>
                <td>
                    <input name="DESCRIPTION_TECHNIQUE" type="text" class="motcles">
                </td>
                <td>
                    <input name="COMMENTAIRE_TECHNIQUE" type="text" class="motcles">
                </td>
                <td>
                    <input name="MOTS_CLES" type="text" class="motcles">
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
                    <input name="INDEX_DOCUMENTATION" type="text" class="motcles">
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
