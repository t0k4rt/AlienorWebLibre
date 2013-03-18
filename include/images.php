<?php
	$niveau_visa="";
	include('securite.php');
	$name=$_GET['SRC'];
	//echo "<br> name :".$name;
	$largeur_voulu=$_GET['LARG'];
	$hauteur_voulu=$_GET['HAUT'];
	$name = strToLower($name);
	$type_image =substr($name,-3);
	$chemin = $_SESSION['images']."/".$name;

	//echo "<br>chemin :".$chemin;exit;
	
	// taille par d�faut vignette
	if (!isset($largeur)) $largeur = 80;
	if (!isset($hauteur)) $hauteur = 80;
	if (!isset($name)){$name = "visuel_de_remplacement.jpg";}
	//echo "<br>chemin :".$chemin;
	$taille = GetImageSize($chemin);
    
	$largeur_origine = $taille[0];
    $hauteur_origine = $taille[1];
    
	//echo '<br>$largeur_origine'.$largeur_origine ;
	//echo '<br>$hauteur_origine'.$hauteur_origine ;
    
	$largeur_ratio = $largeur_voulu/$largeur_origine;
	$hauteur_ratio = $hauteur_voulu/$hauteur_origine;
    
		if ( ($largeur_ratio * $hauteur_origine) < $hauteur_voulu) {
			$tmp_largeur = $largeur_voulu;
			$tmp_hauteur = ceil($largeur_ratio * $hauteur_origine);
			 //echo "<br>tmp_largeur :".$tmp_largeur;
			 //echo "<br>tmp_hauteur :".$tmp_hauteur;
		}else{
			$tmp_largeur = ceil($hauteur_ratio * $largeur_origine);
			$tmp_hauteur = $hauteur_voulu;
			 //echo "<br>tmp_largeur :".$tmp_largeur;
			 //echo "<br>tmp_hauteur :".$tmp_hauteur;
		}
 //echo "<br>type image :".$type_image;
 

 
 switch ($type_image){
 	case 'png': $image_origine = ImageCreateFromPNG($chemin);
				break;
	case 'jpg': $image_origine = ImageCreateFromJPEG($chemin);
				break;
	case 'gif': $image_origine = ImageCreateFromGIF($chemin);
				break;
 }


 //echo "<br>tmp_largeur :".$tmp_largeur;
 //echo "<br>tmp_hauteur :".$tmp_hauteur;
 $image_final = imagecreatetruecolor($tmp_largeur,$tmp_hauteur);
 imagecopyresampled($image_final, $image_origine, 0, 0, 0, 0, $tmp_largeur, $tmp_hauteur, $largeur_origine, $hauteur_origine);
 switch ($type_image){
	case 'png':
		Header('Content-type: image/png');
		ImagePNG($image_final);
		break;
	case 'jpg':
		Header('Content-type: image/jpg');
		ImageJPEG($image_final);
		break;
	case 'gif':
		Header('Content-type: image/gif');
		ImageGIF($image_final);
		break;
 }
 ImageDestroy($image_final);
 ImageDestroy($image_origine);
 
 
?>