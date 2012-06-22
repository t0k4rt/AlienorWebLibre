<?php
include('../config/config.php');
isset($isobjet)? $isobjet = $isobjet : $isobjet = NULL;
$chaine = $_SERVER['PHP_SELF'];
// echo("Chaine = ".$chaine."<br>");
$debut_chaine = strrpos($chaine,'/') + 1; // strrpos = retourne la dernière occurance du caractères trouvé => contraire strpos
$fin_chaine = strrpos($chaine,'_');
$longueur = $fin_chaine - $debut_chaine;
$morceau = substr($chaine,$debut_chaine,$longueur);
isset($_GET['page']) ? $page = $_GET['page'] : $page = $page;

?>
<script language="javascript" type="text/javascript">
function edite_etat() {
	if (document.Selection.sel != null){
		field = document.Selection.sel;
		document.edition.chx_selection.value = "";
		prem =0;
			if(field.length != null) {
				for (i = 0; i < field.length; i++) {
					if (field[i].checked == true){
						if (prem == 0){
							document.edition.chx_selection.value = field[i].value;
							prem = prem+1;
						}else{
							document.edition.chx_selection.value = document.edition.chx_selection.value + "/"  + field[i].value;
						}
					};
				};
			}else{
				if(field.value != 0) {
					document.edition.chx_selection.value = field.value;
				}
			}
		};
}
</script>
<div id="navigation" align="center" style="border:1px solid #000000; background-image:url(../images/saisie.gif); background-repeat:repeat-x">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><img src="../images/logo_cirm-mini.jpg" alt="CIRM" width="83" height="48" border="0" style="border:1px solid #000000" /></td>
    <td><a href="javascript:history.back();"><img src="../images/retour.gif" alt="Retour à la page pr&eacute;cedente" border="0" style="border:1px solid #000000; width:48px; height:48px;" /></a>    </td>
    <td>
		 <?php
		if ($morceau != "ms" and $page!="Administration") { 
 	?>
	     <a href="../masques/mr_<?php echo $page?>.php"><img src="../images/rech_form.jpg" alt="Aller au masque de recherche" border="0"  style="border:1px solid #000000; width:48px; height:48px;" /></a>
         <?php 
		}; ?>	</td>
    <td><?php if ($page != "gestion" and $page != "Administration" && $_SESSION['droit']>=$ms) { 
		if (isset($_GET['noFiche']) && $_GET['noFiche'] != 0) { 
			?>
	  <a href="../masques/ms_<?php echo $page?>.php?noFiche=<?php echo $_GET['noFiche']?>&amp;duplication=1" target="_self"><img src="../images/creer_ligne.jpg" alt="Dupliquer la fiche" border="0" style="border:1px solid #000000; width:48px; height:48px;" /></a>
      <?php
		} else { 
			?>
      <a href="../masques/ms_<?php echo $page ?>.php?noFiche=0" target="_self"><img src="../images/creer_ligne.jpg" alt="Cr&eacute;er une fiche" border="0" style="border:1px solid #000000; width:48px; height:48px;" /></a>
      <?php
		} ?></td>
    <td><?php if (isset($_GET['noFiche']) && $_GET['noFiche'] != 0 && $page!="Administration" && $_SESSION['droit']>=$ms) {
			?>
      <a href="../masques/ms_<?php echo $page?>.php?noFiche=<?php echo $_GET['noFiche']; ?>"><img src="../images/modifier.jpg" alt="Pour aller modifier la page" border="0" style="border:1px solid #000000; width:48px; height:48px;" /></a>
      <?php
		}; 
};?></td>
	<?php if ($isobjet == 1 && $page!="Administration"){ ?>
    <td>
		<form name="edition" action="../etats/etats_objets.php" method="post" onSubmit="javascript:edite_etat();" target="_blank">
			<input type="hidden" name="page" value="<?php echo $page; ?>" />
			<input type="image" value="submit" src="../images/gest_edition.jpg" alt="&Eacute;diter des &eacute;tats" style="border:1px solid #000000; width:48px; height:48px;">
			<input name="chx_selection" type="hidden" id="chx_selection" value="<?php if (isset($_GET['noFiche'])){ echo $_GET['noFiche'];}; ?>" />
		</form>
	</td>
	<?php }; ?>
    <td><a href="https://bases.alienor.org/leconseiller/index.htm" target="_blank"><img src="../images/aide.jpg" alt="Voir l'aide en ligne" border="0" style="border:1px solid #000000; width:48px; height:48px;" /></a></td>
    <td><?php
	if ($morceau != "ms") { ?>
      <a href="../deconnexion.php" target="_self"><img src="../images/deconnection.jpg" alt="Se d&eacute;connecter" border="0" style="border:1px solid #000000; width:48px; height:48px;" /></a>
      <?php
	}; ?></td>

  </tr>
</table>
  </div>
<div class="spacer"></div>
