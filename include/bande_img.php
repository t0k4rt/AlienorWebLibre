<div id="images">
<?php
//echo $photo;
$tabPhoto = explode('/',$photo);
$tabIdentifiant = explode('/',$identifiant);
$tabIndex_documentation = explode('/',$index_documentation);
$cpt = 0;
foreach ($tabPhoto as $fichier){
		if ($fichier != ""){
	?>
		<div class="rangeImg">
		<a href="<?php echo '../include/images.php?SRC='.$fichier.'&amp;LARG=980&amp;HAUT=700'; ?>" target="_blank"><img src="<?php echo "../include/images.php?SRC=".$fichier."&amp;LARG=200&amp;HAUT=200"; ?>" border="0"></a><br>
		<?php echo $tabIdentifiant[$cpt]; ?><a href="../masques/mc_documentation.php?noFiche=<?php echo $tabIndex_documentation[$cpt]; ?>" target="_blank"><img src="../images/changer_base.gif"  alt="Voir la fiche documentation" width="50" height="20" border="0" style="vertical-align:middle"></a></div>
		<?php 
		$cpt++;
	};
}
?>
</div>