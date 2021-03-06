<?php
	session_start();
	require_once('../config/config.php');
	$niveau_visa = $mcr;
	$page = "documentation";
	include('../include/securite.php');
	include('../include/fonctions.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="fr">
<head>
<title>Formulaire de recherche : Documentation g&eacute;n&eacute;rale</title>
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
    <h2>Formulaire de recherche Documentation</h2>
</div>
<div id="s-menu">
    <div id="menu"><a href="#GENERALE">G&eacute;n&eacute;rale</a> <span class="invisible">|</span> <a href="#SUPPORT">Support</a> <span class="invisible">|</span> <a href="#PHOTO">Photographie</a> <span class="invisible">|</span> <a href="#LIVRE">Livre</a> <span class="invisible">|</span> <a href="#INFORMATIQUE">Gestion&nbsp;informatique</a></div>
    <div id="btnvalid">
        <input name="image" type="image" onClick="document.fiche.submit();" src="../images/valider.gif">
    </div>
</div>
<div class="spacer"></div>
<div id="formulaire">
    <form name="fiche" method="post" action="../masques/rep_documentation.php">
        <table class="centpcent">
            <tr>
                <td>
                    <p align="justify"><em><strong>NDLR :</strong></em></p>
                    <p align="justify"><em>Ce masque ne respecte ni une logique de type de document ; ni une logique de saisie mais uniquement une logique de zone de s&eacute;curit&eacute;.</em></p>
                    <p align="justify"><em>Il a pour seul m&eacute;rite de contenir (en fonction de vos droits) toutes les rubriques de la base documentation.</em></p>
                    <p align="justify"><em>Pour une facilit&eacute; de compr&eacute;hension certaines rubriques ont des intitul&eacute;s assez longs.</em></p>
                </TD>
            </tr>
        </table>
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
                <td colspan="2">Titre du document ou de l&#8217;exposition <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4102)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="3">
                    <input name="TITRE_DOCUMENT" type="text" size="90">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <span><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=AUT&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=AUTEUR');">Auteur ou commissaire</a></span>
                    <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,1413)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a></td>
                <td>
                    <span><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=AUT&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=EDITEUR');">&Eacute;diteur ou organisateur</a></span>
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
                            <td colspan="4">Date d&#8217;&eacute;dition ou d'exposition <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4109)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a></td>
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
                <td>Collection <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4111)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a></td>
                <td colspan="2">Notes libres ou commentaires <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4104)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a></td>
            </tr>
            <tr>
                <td>
                    <input name="COLLECTION" type="text" class="motcles">
                </td>
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
            <tr>
                <td><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=TLIEU&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=LOCALISATION_DOCUMENT');">Localisation</a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4113)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a></td>
                <td><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=PERIO&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=PERIODE_CONCERNE');">P&eacute;riode concern&eacute;e par le document</a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4110)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a></td>
                <td><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=ACCESS&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=ACCESSIBILITE');">Accessibilit&eacute;</a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4114)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a></td>
            </tr>
            <tr>
                <td>
                    <input name="LOCALISATION_DOCUMENT" type="text" class="motcles">
                </td>
                <td>
                    <input name="PERIODE_CONCERNE" type="text" class="motcles">
                </td>
                <td>
                    <input name="ACCESSIBILITE" type="text" class="motcles">
                </td>
            </tr>
        </table>
        <br>
        <!-- ZONE SUPPORT -->
        <div><a name="SUPPORT"></a></div>
        <table cellpadding="3" CELLSPACING="0" class="centpcent">
            <tr>
                <td colspan="3" class="titre-tbl">DOCUMENT &Eacute;LECTRONIQUE</td>
            </tr>
            <tr>
                <td>Num&eacute;ro de Support.<a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4215)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a></td>
                <td>Pr&eacute;cision ou adresse sur le Support <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4216)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a></td>
                <td><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=AUT&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=WEBMESTRE');">Webmestre</a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,7777)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a></td>
            </tr>
            <tr>
                <td>
                    <input name="NUMERO_SUPPORT" type="text" class="motcles">
                </td>
                <td>
                    <input name="PRECISION_SUPPORT" type="text" class="motcles">
                </td>
                <td>
                    <input name="WEBMESTRE" type="text" class="motcles" >
                </td>
            </tr>
        </table>
        <br>
        <!-- ZONE PHOTO -->
        <div><a name="PHOTO"></a></div>
        <table cellpadding="3" CELLSPACING="0" class="centpcent">
            <tr>
                <td colspan="2" class="titre-tbl">PHOTO</td>
            </tr>
            <tr>
                <td><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=AUT&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=PHOTOGRAPHE');">Photographe</a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4318)"><img src="../images/infos.gif" alt="aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a></td>
                <td>Date de Prise de Vue <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4319)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a></td>
            </tr>
            <tr>
                <td>
                    <input name="PHOTOGRAPHE" type="text" class="motcles">
                </td>
                <td>
                    <table border="0" cellpadding="0">
                        <tr>
                            <td>Affixe</td>
                            <td>Date</td>
                            <td>&nbsp;</td>
                            <td>Date fin</td>
                        </tr>
                        <tr>
                            <td>
                                <select name="TXT_DATE_PRISE_VUE">
                                    <option selected>--</option>
                                    <option value="LE">Le</option>
                                    <option value="AVANT">Avant</option>
                                    <option value="APRES">Apr&egrave;</option>
                                    <option value="ENTRE">Entre</option>
                                </select>
                            </td>
                            <td>
                                <input name="DEB_DATE_PRISE_VUE" type="text" class="inputnumerique" maxlength="10">
                            </td>
                            <td>et</td>
                            <td>
                                <input name="FIN_DATE_PRISE_VUE" type="text" class="inputnumerique" maxlength="10">
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=TLIEU&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=LIEU_PRISE_VUE');">Lieu de prise de vue</a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4301)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a></td>
                <td>L&eacute;gende <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4323)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a></td>
            </tr>
            <tr>
                <td>
                    <input name="LIEU_PRISE_VUE" type="text" class="motcles">
                </td>
                <td>
                    <input name="LEGENDE" type="text" class="inputtextelibre">
                </td>
            </tr>
            <tr>
                <td><a href="javascript:FenetreTheso('fs_theso.asp?__GroupId=286&amp;curtheso=DROIT&amp;curterm=&amp;curindex=&amp;SRC=champ_7&amp;__formGroupid=37&amp;__TableId=32&amp;IdItem=TYPE_DROIT');">Type de Droits</a> <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4115)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a></td>
                <td>Num&eacute;ro d&#8217;inventaire du document dans le mus&eacute;e <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4122)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a></TD>
            </tr>
            <tr>
                <td>
                    <input name="TYPE_DROIT" type="text" class="motcles">
                </td>
                <td>
                    <input name="NUMERO_INVENTAIRE_INTERNE" type="text" class="motcles">
                </td>
            </tr>
            <tr>
                <td>Copyright de la photo <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4321)"><img src="../images/infos.gif" alt="Aide en ligne" width="16" height="16" border="0" style="vertical-align:middle"></a></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>
                    <input name="COPYRIGHT_PHOTO" type="text" class="motcles">
                </td>
                <td>&nbsp;</td>
            </tr>
        </table>
        <br>
        <!-- ZONE LIVRE -->
        <div><a name="LIVRE"></a></div>
        <table cellpadding="3" cellspacing="0" class="centpcent">
            <tr>
                <td colspan="3" class="titre-tbl">LIVRE</td>
            </tr>
            <tr>
                <td colspan="2">Titre du p&eacute;riodique <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4425)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2">
                    <input name="TITRE_ENSEMBLE" type="text" class="inputlong40">
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>ISBN <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4426)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a></td>
                <td>ISSN <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4427)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a></td>
                <td>Cote de l&#8217;ouvrage <a href="javascript:RH_ShowHelp(0,'<?php echo $_SESSION['aide']; ?>',HH_HELP_CONTEXT,4428)"><img src="../images/infos.gif" width="16" height="16" border="0" alt="Aide en ligne" style="vertical-align:middle"></a></td>
            </tr>
            <tr>
                <td>
                    <input name="ISBN" type="text" class="motcles">
                </td>
                <td>
                    <input name="ISSN" type="text" class="motcles">
                </td>
                <td>
                    <input name="COTE" type="text" class="motcles">
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
