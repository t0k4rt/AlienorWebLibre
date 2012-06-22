<?php
	session_start();
	require_once('../config/config.php');
	$niveau_visa = $mcr;
	$page = "litho";
	include('../include/securite.php');
	include('../include/fonctions.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="fr">
<head>
<title>Formulaire de recherche : Lithoth&egrave;que</title>
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
    <h2>Formulaire de recherche Lithoth&egrave;que </h2>
</div>
<div id="s-menu">
    <div id="menu"><a href="#IDENTIFICATION">D&eacute;signation</a> <span class="invisible">|</span> <a href="#DECOUVERTE">Provenance&nbsp;g&eacute;ographique</a> <span class="invisible">|</span> <a href="#EXECUTION">Donn&eacute;es&nbsp;sur &nbsp;l'execution</a> <span class="invisible">|</span> <a href="#DESCRIPTIONpos">Description</a> <span class="invisible">|</span> <a href="#ADMINISTRATION">Information&nbsp;administrative</a> <span class="invisible">|</span> <a href="#INFORMATIQUE">Gestion&nbsp;informatique</a></div>
    <div id="btnvalid">
        <input name="image" type="image" onClick="document.fiche.submit();" src="../images/valider.gif">
    </div>
</div>
<div class="spacer"></div>
<div id="formulaire">
    <form name="fiche" method="post" action="../masques/rep_litho.php">
        <!-- ZONE IDENTIFICATION -->
        <div><a name="IDENTIFICATION"></a></div>
        <table cellpadding="3" cellspacing="0" class="centpcent" summary="identification">
            <tr>
                <td colspan="3" class="titre-tbl">D&Eacute;SIGNATION</td>
            </tr>
            <tr>
                <td>
                    <span class="obligatoire">Num&eacute;ro d'inventaire</span>
                    <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1109)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a></td>
                <td><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=DSCP&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=DISCIPLINE');">
                    <span class="obligatoire">Discipline</span>
                    </a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1101)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
                <td><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=DOMN&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=DOMAINE');">
                    <span class="obligatoire">Domaine</span>
                    </a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1102)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
            </tr>
            <tr>
                <td>
                    <input name="NUMERO_INVENTAIRE" type="text" class="motcles" id="numinv">
                </td>
                <td>
                    <input name="DISCIPLINE" type="text" class="motcles" id="dsp">
                </td>
                <td>
                    <input name="DOMAINE" type="text" class="motcles" id="dmn">
                </td>
            </tr>
            <tr>
                <td><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=DENO&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=DENOMINATION');">
                    <span>D&eacute;nomination</span>
                    </a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1103)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
                <td>
                    <span><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=TYPOL&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=TYPOLOGIE');">Typologie</a></span>
                    <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1108)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
                <td>
                    <span>Nombre d&#8217;exemplaires</span>
                    <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1107)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
            </tr>
            <tr>
                <td>
                    <input name="DENOMINATION" type="text" class="motcles" id="deno">
                </td>
                <td>
                    <input name="TYPOLOGIE" type="text" class="motcles" id="titre">
                </td>
                <td>
                    <input name="NB_EXEMPLAIRE" type="text" class="motcles" id="nb">
                </td>
            </tr>
        </table>
        <br>
        <!-- ZONE DONNEES SUR LA COLLECTE -->
        <div><a name="DECOUVERTE"></a></div>
        <table cellpadding="3" cellspacing="0" class="centpcent">
            <tr>
                <td colspan="6" class="titre-tbl">PROVENANCE G&Eacute;OGRAPHIQUE</td>
            </tr>
            <tr>
                <td><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=TLIEU&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=LIEUX_DECOUVERTE');">
                    <span>G&icirc;te (lieu de collecte, secteur g&eacute;ographique) </span>
                    </a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1201)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
                <td><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=AUT&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=DESCRIPTEUR');">
                    <span>Descripteur</span>
                    </a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1314)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
                <td colspan="4">&nbsp;</td>
            </tr>
            <tr>
                <td>
                    <input name="LIEUX_DECOUVERTE" type="text" class="motcles" id="liecol">
                </td>
                <td>
                    <input name="DESCRIPTEUR" type="text" class="motcles" id="DESCRIPTEUR">
                </td>
                <td colspan="4">Date de D&eacute;couverte <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1202)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
            </tr>
            <tr>
                <td><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=AUT&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=COLLECTEUR');">
                    <span>Collecteur</span>
                    </a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1206)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
                <td>&nbsp;</td>
                <td>Affixe</td>
                <td>Date d&eacute;but</td>
                <td>&nbsp;</td>
                <td>Date fin</td>
            </tr>
            <tr>
                <td>
                    <input name="COLLECTEUR" type="text" class="motcles" id="COLLECTEUR">
                </td>
                <td>&nbsp;</td>
                <td>
                    <select name="TXT_DATE_DECOUVERTE">
                        <option>--</option>
                        <option value="le">Le</option>
                        <option value="avant">Avant</option>
                        <option value="apr&egrave;s">Apr&egrave;s</option>
                        <option value="entre">Entre</option>
                        <option value="ann&eacute;e">Ann&eacute;e</option>
                        <option value="mois">Mois</option>
                    </select>
                </td>
                <td>
                    <input name="DEB_DATE_DECOUVERTE" type="text" class="inputnumerique">
                </td>
                <td>et</td>
                <td>
                    <input name="FIN_DATE_DECOUVERTE" type="text" class="inputnumerique">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <span>Pr&eacute;cision sur la collecte</span>
                    <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1203)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
                <td colspan="4">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2">
                    <input name="PRECISION_DECOUVERTE" type="text" class="inputtextelibre" id="precol">
                </td>
                <td colspan="4">&nbsp;</td>
            </tr>
        </table>
        <br>
        <div><a name="EXECUTION"></a></div>
        <table cellpadding="3" cellspacing="0" class="centpcent">
            <tr>
                <td colspan="2" class="titre-tbl">DONN&Eacute;ES SUR L&#8217;EX&Eacute;CUTION</td>
            </tr>
            <tr>
                <td><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=PERIO&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=SIECLE_MILLENAIRE');">Si&egrave;cle ou mill&eacute;naire</a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1407)"><img src="../images/infos.gif" WIDTH="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
                <td> <a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=EPOQU&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=EPOQUE_STYLE');">
                    <span>Attribution g&eacute;ologique (&eacute;poque)</span>
                    </a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1408)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a> </td>
            </tr>
            <tr>
                <td>
                    <input name="SIECLE_MILLENAIRE" type="text" class="motcles">
                </td>
                <td>
                    <input name="EPOQUE_STYLE" type="text" class="motcles" id="EPOQUE_STYLE">
                </td>
            </tr>
            <tr>
                <td>Pr&eacute;cision sur la datation <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1409)"><img src="../images/infos.gif" WIDTH="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
                <td>
                    <span>Pr&eacute;cision sur la gen&egrave;se</span>
                    <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1405)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a></td>
            </tr>
            <tr>
                <td>
                    <input name="PRECISION_DATATION" type="text" class="motcles">
                </td>
                <td>
                    <input name="PRECISION_GENESE" type="text" class="motcles" id="PRECISION_GENESE">
                </td>
            </tr>
        </table>
        <br>
        <!-- ZONE DESCRIPTION -->
        <div><a name="DESCRIPTIONpos"></a></div>
        <table cellpadding="3" cellspacing="0" class="centpcent">
            <tr>
                <td class="titre-tbl">DESCRIPTION</td>
            </tr>
            <tr>
                <td>
                    <span>Caract&egrave;res macroscopiques ou microscopiques</span>
                    <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1308)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
            </tr>
            <tr>
                <td>
                    <input name="PRECISION_DESCRIPTION" type="text" class="inputtextelibre" id="DESCRIPTION">
                </td>
            </tr>
        </table>
        <br>
        <!-- ZONE ADMINSTRATION -->
        <div><a name="ADMINISTRATION"></a></div>
        <table cellpadding="3" cellspacing="0" class="centpcent">
            <tr>
                <td colspan="6" class="titre-tbl">INFORMATIONS ADMINISTRATIVES</td>
            <tr>
                <td><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=TLIEU&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=LOCALISATION');">
                    <span class="obligatoire">Localisation</span>

                    </a><a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1601)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
                <td colspan="4"><span class="obligatoire">Date d&#8217;acquisition</span> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1619)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td valign="top">
                    <input name="LOCALISATION" type="text" class="motcles" id="loc">
                </td>
                <td colspan="4">
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td valign="top">Affixe<br>
                                <select name="PROPRIETAIRE_TXT_DATE_PATRIMONIALE">
                                    <option>--</option>
                                    <option value="le">Le</option>
                                    <option value="avant">Avant</option>
                                    <option value="après">Apr&egrave;s</option>
                                    <option value="entre">Entre</option>
                                    <option value="année">Ann&eacute;e</option>
                                    <option value="mois">Mois</option>
                                </select>
                            </td>
                            <td valign="top">Date d&eacute;but<br>
                                <input name="PROPRIETAIRE_DEB_DATE_PATRIMONIALE" type="text" class="inputnumerique">
                            </td>
                            <td valign="middle">et</td>
                            <td valign="top">Date fin<br>
                                <input name="PROPRIETAIRE_FIN_DATE_PATRIMONIALE" type="text" class="inputnumerique">
                            </td>
                        </tr>
                    </table>
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=AUT&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=PROPRIETAIRE');">
                    <span class="obligatoire">Propri&eacute;taire</span>
                    </a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1617)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
                <td colspan="4"><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=AUT&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=SERVICE_GESTIONNAIRE');">
                    <span class="obligatoire">Service gestionnaire</span>
                    </a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1624)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
                <td>Pr&eacute;cision administrative <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1613)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
            </tr>
            <tr>
                <td>
                    <input name="PROPRIETAIRE" type="text" class="motcles" id="prop">
                </td>
                <td colspan="4">
                    <input name="SERVICE_GESTIONNAIRE" type="text" class="motcles" id="serv">
                </td>
                <td>
                    <input name="PRECISION_ADMINISTRATIVE" type="text" class="motcles">
                </td>
            </tr>
            <tr>
                <td><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=MACQ&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=MODE_ACQUISITION');">
                    <span class="obligatoire">Mode d&#8217;acquisition</span>
                    </a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1603)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
                <td colspan="4">Lot <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1605)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
                <td>Num&eacute;ro <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1606)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
            </tr>
            <tr>
                <td>
                    <input name="MODE_ACQUISITION" type="text" class="motcles" id="mode">
                </td>
                <td colspan="4">
                    <input name="LOT" type="text" class="motcles">
                </td>
                <td>
                    <input name="NUMERO" type="text" class="motcles">
                </td>
            </tr>
            <tr>
                <td><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=AUT&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=ANCIENNE_APPARTENANCE');">Ancienne appartenance</a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1614)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
                <td colspan="4">N&deg; de catalogue <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1616)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>
                    <input name="ANCIENNE_APPARTENANCE" type="text" class="motcles">
                </td>
                <td colspan="4">
                    <input name="NUMERO_CATALOGUE" type="text" class="motcles">
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td colspan="4">Date de d&eacute;pot <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1622)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=AUT&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=DEPOSITAIRE');">D&eacute;positaire</a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1621)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a> </td>
                <td>Affixe</td>
                <td>Date d&eacute;but</td>
                <td>&nbsp;</td>
                <td>Date fin</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>
                    <input name="DEPOSITAIRE" type="text" class="motcles">
                </td>
                <td>
                    <select name="DEPOSITAIRE_TXT_DATE_PATRIMONIALE">
                        <option>--</option>
                        <option value="le">Le</option>
                        <option value="avant">Avant</option>
                        <option value="après">Apr&egrave;s</option>
                        <option value="entre">Entre</option>
                        <option value="année">Ann&eacute;e</option>
                        <option value="mois">Mois</option>
                    </select>
                </td>
                <td>
                    <input name="DEPOSITAIRE_DEB_DATE_PATRIMONIALE" type="text" class="inputnumerique">
                </td>
                <td>et </td>
                <td>
                    <input name="DEPOSITAIRE_FIN_DATE_PATRIMONIALE" type="text" class="inputnumerique">
                </td>
                <td>&nbsp; </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td colspan="4">Date de d&eacute;pot <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1622)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=AUT&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=ANCIEN_DEPOSITAIRE');">Ancien d&eacute;positaire</a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1625)"><img src="../images/infos.gif" width="16" height="16" border="0" style="vertical-align:middle" alt="Aide en ligne"></a></td>
                <td>Affixe</td>
                <td>Date d&eacute;but</td>
                <td>&nbsp;</td>
                <td>Date fin</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>
                    <input name="ANCIEN_DEPOSITAIRE" type="text" class="motcles">
                </td>
                <td>
                    <select name="ANCIEN_DEPOSITAIRE_TXT_DATE_PATRIMONIALE">
                        <option>--</option>
                        <option value="le">Le</option>
                        <option value="avant">Avant</option>
                        <option value="après">Apr&egrave;s</option>
                        <option value="entre">Entre</option>
                        <option value="année">Ann&eacute;e</option>
                        <option value="mois">Mois</option>
                    </select>
                </td>
                <td>
                    <input name="ANCIEN_DEPOSITAIRE_DEB_DATE_PATRIMONIALE" type="text" class="inputnumerique">
                </td>
                <td>et</td>
                <td>
                    <input name="ANCIEN_DEPOSITAIRE_FIN_DATE_PATRIMONIALE" type="text" class="inputnumerique">
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
                    <input name="INDEX_OBJET" type="text" class="motcles">
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
