<?php include('../Connections/alienorweblibre.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_alienorweb, $alienorweb);
$query_table_objet = "SHOW COLUMNS FROM objet";
$table_objet = mysql_query($query_table_objet, $alienorweb) or die(mysql_error());
$row_table_objet = mysql_fetch_assoc($table_objet);
$totalRows_table_objet = mysql_num_rows($table_objet);

mysql_select_db($database_alienorweb, $alienorweb);
$query_objet = "SELECT * FROM objet";
$objet = mysql_query($query_objet, $alienorweb) or die(mysql_error());
$row_objet = mysql_fetch_assoc($objet);
$totalRows_objet = mysql_num_rows($objet);

mysql_select_db($database_alienorweb, $alienorweb);
$query_table_personne = "SHOW COLUMNS FROM personne";
$table_personne = mysql_query($query_table_personne, $alienorweb) or die(mysql_error());
$row_table_personne = mysql_fetch_assoc($table_personne);
$totalRows_table_personne = mysql_num_rows($table_personne);

mysql_select_db($database_alienorweb, $alienorweb);
$query_personne = "SELECT * FROM personne";
$personne = mysql_query($query_personne, $alienorweb) or die(mysql_error());
$row_personne = mysql_fetch_assoc($personne);
$totalRows_personne = mysql_num_rows($personne);

mysql_select_db($database_alienorweb, $alienorweb);
$query_table_lieu = "SHOW COLUMNS FROM lieu";
$table_lieu = mysql_query($query_table_lieu, $alienorweb) or die(mysql_error());
$row_table_lieu = mysql_fetch_assoc($table_lieu);
$totalRows_table_lieu = mysql_num_rows($table_lieu);

mysql_select_db($database_alienorweb, $alienorweb);
$query_lieu = "SELECT * FROM lieu";
$lieu = mysql_query($query_lieu, $alienorweb) or die(mysql_error());
$row_lieu = mysql_fetch_assoc($lieu);
$totalRows_lieu = mysql_num_rows($lieu);

mysql_select_db($database_alienorweb, $alienorweb);
$query_table_documentation = "SHOW COLUMNS FROM documentation";
$table_documentation = mysql_query($query_table_documentation, $alienorweb) or die(mysql_error());
$row_table_documentation = mysql_fetch_assoc($table_documentation);
$totalRows_table_documentation = mysql_num_rows($table_documentation);

mysql_select_db($database_alienorweb, $alienorweb);
$query_documentation = "SELECT * FROM documentation";
$documentation = mysql_query($query_documentation, $alienorweb) or die(mysql_error());
$row_documentation = mysql_fetch_assoc($documentation);
$totalRows_documentation = mysql_num_rows($documentation);

mysql_select_db($database_alienorweb, $alienorweb);
$query_table_obj_per = "SHOW COLUMNS FROM obj_per";
$table_obj_per = mysql_query($query_table_obj_per, $alienorweb) or die(mysql_error());
$row_table_obj_per = mysql_fetch_assoc($table_obj_per);
$totalRows_table_obj_per = mysql_num_rows($table_obj_per);

mysql_select_db($database_alienorweb, $alienorweb);
$query_obj_per = "SELECT * FROM obj_per";
$obj_per = mysql_query($query_obj_per, $alienorweb) or die(mysql_error());
$row_obj_per = mysql_fetch_assoc($obj_per);
$totalRows_obj_per = mysql_num_rows($obj_per);

mysql_select_db($database_alienorweb, $alienorweb);
$query_table_obj_lie = "SHOW COLUMNS FROM obj_lie";
$table_obj_lie = mysql_query($query_table_obj_lie, $alienorweb) or die(mysql_error());
$row_table_obj_lie = mysql_fetch_assoc($table_obj_lie);
$totalRows_table_obj_lie = mysql_num_rows($table_obj_lie);

mysql_select_db($database_alienorweb, $alienorweb);
$query_obj_lie = "SELECT * FROM obj_lie";
$obj_lie = mysql_query($query_obj_lie, $alienorweb) or die(mysql_error());
$row_obj_lie = mysql_fetch_assoc($obj_lie);
$totalRows_obj_lie = mysql_num_rows($obj_lie);

mysql_select_db($database_alienorweb, $alienorweb);
$query_table_obj_doc = "SHOW COLUMNS FROM obj_doc";
$table_obj_doc = mysql_query($query_table_obj_doc, $alienorweb) or die(mysql_error());
$row_table_obj_doc = mysql_fetch_assoc($table_obj_doc);
$totalRows_table_obj_doc = mysql_num_rows($table_obj_doc);

mysql_select_db($database_alienorweb, $alienorweb);
$query_obj_doc = "SELECT * FROM obj_doc";
$obj_doc = mysql_query($query_obj_doc, $alienorweb) or die(mysql_error());
$row_obj_doc = mysql_fetch_assoc($obj_doc);
$totalRows_obj_doc = mysql_num_rows($obj_doc);

mysql_select_db($database_alienorweb, $alienorweb);
$query_table_obj_ges = "SHOW COLUMNS FROM obj_ges";
$table_obj_ges = mysql_query($query_table_obj_ges, $alienorweb) or die(mysql_error());
$row_table_obj_ges = mysql_fetch_assoc($table_obj_ges);
$totalRows_table_obj_ges = mysql_num_rows($table_obj_ges);

mysql_select_db($database_alienorweb, $alienorweb);
$query_obj_ges = "SELECT * FROM obj_ges";
$obj_ges = mysql_query($query_obj_ges, $alienorweb) or die(mysql_error());
$row_obj_ges = mysql_fetch_assoc($obj_ges);
$totalRows_obj_ges = mysql_num_rows($obj_ges);

mysql_select_db($database_alienorweb, $alienorweb);
$query_table_per_lie = "SHOW COLUMNS FROM per_lie";
$table_per_lie = mysql_query($query_table_per_lie, $alienorweb) or die(mysql_error());
$row_table_per_lie = mysql_fetch_assoc($table_per_lie);
$totalRows_table_per_lie = mysql_num_rows($table_per_lie);

mysql_select_db($database_alienorweb, $alienorweb);
$query_per_lie = "SELECT * FROM per_lie";
$per_lie = mysql_query($query_per_lie, $alienorweb) or die(mysql_error());
$row_per_lie = mysql_fetch_assoc($per_lie);
$totalRows_per_lie = mysql_num_rows($per_lie);

mysql_select_db($database_alienorweb, $alienorweb);
$query_table_per_doc = "SHOW COLUMNS FROM per_doc";
$table_per_doc = mysql_query($query_table_per_doc, $alienorweb) or die(mysql_error());
$row_table_per_doc = mysql_fetch_assoc($table_per_doc);
$totalRows_table_per_doc = mysql_num_rows($table_per_doc);

mysql_select_db($database_alienorweb, $alienorweb);
$query_per_doc = "SELECT * FROM per_doc";
$per_doc = mysql_query($query_per_doc, $alienorweb) or die(mysql_error());
$row_per_doc = mysql_fetch_assoc($per_doc);
$totalRows_per_doc = mysql_num_rows($per_doc);

mysql_select_db($database_alienorweb, $alienorweb);
$query_table_lie_per = "SHOW COLUMNS FROM lie_per";
$table_lie_per = mysql_query($query_table_lie_per, $alienorweb) or die(mysql_error());
$row_table_lie_per = mysql_fetch_assoc($table_lie_per);
$totalRows_table_lie_per = mysql_num_rows($table_lie_per);

mysql_select_db($database_alienorweb, $alienorweb);
$query_lie_per = "SELECT * FROM lie_per";
$lie_per = mysql_query($query_lie_per, $alienorweb) or die(mysql_error());
$row_lie_per = mysql_fetch_assoc($lie_per);
$totalRows_lie_per = mysql_num_rows($lie_per);

mysql_select_db($database_alienorweb, $alienorweb);
$query_table_lie_doc = "SHOW COLUMNS FROM lie_doc";
$table_lie_doc = mysql_query($query_table_lie_doc, $alienorweb) or die(mysql_error());
$row_table_lie_doc = mysql_fetch_assoc($table_lie_doc);
$totalRows_table_lie_doc = mysql_num_rows($table_lie_doc);

mysql_select_db($database_alienorweb, $alienorweb);
$query_lie_doc = "SELECT * FROM lie_doc";
$lie_doc = mysql_query($query_lie_doc, $alienorweb) or die(mysql_error());
$row_lie_doc = mysql_fetch_assoc($lie_doc);
$totalRows_lie_doc = mysql_num_rows($lie_doc);

mysql_select_db($database_alienorweb, $alienorweb);
$query_table_doc_lie = "SHOW COLUMNS FROM doc_lie";
$table_doc_lie = mysql_query($query_table_doc_lie, $alienorweb) or die(mysql_error());
$row_table_doc_lie = mysql_fetch_assoc($table_doc_lie);
$totalRows_table_doc_lie = mysql_num_rows($table_doc_lie);

mysql_select_db($database_alienorweb, $alienorweb);
$query_doc_lie = "SELECT * FROM doc_lie";
$doc_lie = mysql_query($query_doc_lie, $alienorweb) or die(mysql_error());
$row_doc_lie = mysql_fetch_assoc($doc_lie);
$totalRows_doc_lie = mysql_num_rows($doc_lie);

mysql_select_db($database_alienorweb, $alienorweb);
$query_table_doc_per = "SHOW COLUMNS FROM doc_per";
$table_doc_per = mysql_query($query_table_doc_per, $alienorweb) or die(mysql_error());
$row_table_doc_per = mysql_fetch_assoc($table_doc_per);
$totalRows_table_doc_per = mysql_num_rows($table_doc_per);

mysql_select_db($database_alienorweb, $alienorweb);
$query_doc_per = "SELECT * FROM doc_per";
$doc_per = mysql_query($query_doc_per, $alienorweb) or die(mysql_error());
$row_doc_per = mysql_fetch_assoc($doc_per);
$totalRows_doc_per = mysql_num_rows($doc_per);

?>
<?php
$xml .= '<?xml version="1.0" encoding="iso-8859-1"?>';
$xml .= '<!DOCTYPE PATRIMOINE SYSTEM "http://www.inter-regions-musees.org/xml/patrimoine.dtd">';
$xml .= '<?xml-stylesheet version="1.0" type="text/xsl" href="alienorweblibre.xsl"?>';
$xml .= '<PATRIMOINE>'; ?>
<!-- ******* Traitement objet ******* -->
<?php
do
{
	$colonne_objet[] = $row_table_objet['Field'];
} while ($row_table_objet = mysql_fetch_assoc($table_objet));
?>
<?php do { ?>
    <?php $xml .= '<OBJET>'; ?>
    <?php
		for($u = 0; $u < count($colonne_objet);$u++)
		{
			$xml .= '<'.$colonne_objet[$u].'>'.$row_objet[$colonne_objet[$u]].'</'.$colonne_objet[$u].'>';
		}
		?>
    <?php $xml .= '</OBJET>'; ?>
    <?php } while ($row_objet = mysql_fetch_assoc($objet)); ?>
<!-- ******* Traitement obj_per ******* -->
<?php
do
{
	$colonne_obj_per[] = $row_table_obj_per['Field'];
} while ($row_table_obj_per = mysql_fetch_assoc($table_obj_per));
?>
<?php do { ?>
    <?php $xml .= '<OBJ_PER>'; ?>
    <?php
		for($u = 0; $u < count($colonne_obj_per);$u++)
		{
			$xml .= '<'.$colonne_obj_per[$u].'>'.$row_obj_per[$colonne_obj_per[$u]].'</'.$colonne_obj_per[$u].'>';
		}
		?>
    <?php $xml .= '</OBJ_PER>'; ?>
    <?php } while ($row_obj_per = mysql_fetch_assoc($obj_per)); ?>
<!-- ******* Traitement obj_lie ******* -->
<?php
do
{
	$colonne_obj_lie[] = $row_table_obj_lie['Field'];
} while ($row_table_obj_lie = mysql_fetch_assoc($table_obj_lie));
?>
<?php do { ?>
    <?php $xml .= '<OBJ_LIE>'; ?>
    <?php
		for($u = 0; $u < count($colonne_obj_lie);$u++)
		{
			$xml .= '<'.$colonne_obj_lie[$u].'>'.$row_obj_lie[$colonne_obj_lie[$u]].'</'.$colonne_obj_lie[$u].'>';
		}
		?>
    <?php $xml .= '</OBJ_LIE>'; ?>
    <?php } while ($row_obj_lie = mysql_fetch_assoc($obj_lie)); ?>
<!-- ******* Traitement obj_doc ******* -->
<?php
do
{
	$colonne_obj_doc[] = $row_table_obj_doc['Field'];
} while ($row_table_obj_doc = mysql_fetch_assoc($table_obj_doc));
?>
<?php do { ?>
    <?php $xml .= '<OBJ_DOC>'; ?>
    <?php
		for($u = 0; $u < count($colonne_obj_doc);$u++)
		{
			$xml .= '<'.$colonne_obj_doc[$u].'>'.$row_obj_doc[$colonne_obj_doc[$u]].'</'.$colonne_obj_doc[$u].'>';
		}
		?>
    <?php $xml .= '</OBJ_DOC>'; ?>
    <?php } while ($row_obj_doc = mysql_fetch_assoc($obj_doc)); ?>
<!-- ******* Traitement obj_ges ******* -->
<?php
do
{
	$colonne_obj_ges[] = $row_table_obj_ges['Field'];
} while ($row_table_obj_ges = mysql_fetch_assoc($table_obj_ges));
?>
<?php do { ?>
    <?php $xml .= '<OBJ_GES>'; ?>
    <?php
		for($u = 0; $u < count($colonne_obj_ges);$u++)
		{
			$xml .= '<'.$colonne_obj_ges[$u].'>'.$row_obj_ges[$colonne_obj_ges[$u]].'</'.$colonne_obj_ges[$u].'>';
		}
		?>
    <?php $xml .= '</OBJ_GES>'; ?>
    <?php } while ($row_obj_ges = mysql_fetch_assoc($obj_ges)); ?>
<!-- ******* Traitement personne ******* -->
<?php
	do
	{
		$colonne_personne[] = $row_table_personne['Field'];
	} while ($row_table_personne = mysql_fetch_assoc($table_personne));
	?>
<?php do { ?>
    <?php $xml .= '<PERSONNE>'; ?>
    <?php
	for($u = 0; $u < count($colonne_personne);$u++)
	{
		$xml .='<'.$colonne_personne[$u].'>'.$row_personne[$colonne_personne[$u]].'</'.$colonne_personne[$u].'>';
	}
	?>
    <?php $xml .= '</PERSONNE>'; ?>
    <?php } while ($row_personne = mysql_fetch_assoc($personne)); ?>
<!-- ******* Traitement per_lie ******* -->
<?php
	do
	{
		$colonne_per_lie[] = $row_table_per_lie['Field'];
	} while ($row_table_per_lie = mysql_fetch_assoc($table_per_lie));
	?>
<?php do { ?>
    <?php $xml .= '<PER_LIE>'; ?>
    <?php
	for($u = 0; $u < count($colonne_per_lie);$u++)
	{
		$xml .='<'.$colonne_per_lie[$u].'>'.$row_per_lie[$colonne_per_lie[$u]].'</'.$colonne_per_lie[$u].'>';
	}
	?>
    <?php $xml .= '</PER_LIE>'; ?>
    <?php } while ($row_per_lie = mysql_fetch_assoc($per_lie)); ?>
<!-- ******* Traitement per_doc ******* -->
<?php
	do
	{
		$colonne_per_doc[] = $row_table_per_doc['Field'];
	} while ($row_table_per_doc = mysql_fetch_assoc($table_per_doc));
	?>
<?php do { ?>
    <?php $xml .= '<PER_DOC>'; ?>
    <?php
	for($u = 0; $u < count($colonne_per_doc);$u++)
	{
		$xml .='<'.$colonne_per_doc[$u].'>'.$row_per_doc[$colonne_per_doc[$u]].'</'.$colonne_per_doc[$u].'>';
	}
	?>
    <?php $xml .= '</PER_DOC>'; ?>
    <?php } while ($row_per_doc = mysql_fetch_assoc($per_doc)); ?>
<!-- ******* Traitement lieu ******* -->
<?php
do {
	$colonne_lieu[] = $row_table_lieu['Field'];
} while ($row_table_lieu = mysql_fetch_assoc($table_lieu));
?>
<?php do { ?>
    <?php $xml .= '<LIEU>'; ?>
    <?php
	for($u = 0; $u < count($colonne_lieu);$u++)
	{
		$xml .='<'.$colonne_lieu[$u].'>'.$row_lieu[$colonne_lieu[$u]].'</'.$colonne_lieu[$u].'>';
	}
	?>
    <?php $xml .= '</LIEU>'; ?>
    <?php } while ($row_lieu = mysql_fetch_assoc($lieu)); ?>
<!-- ******* Traitement lie_per ******* -->
<?php
do {
	$colonne_lie_per[] = $row_table_lie_per['Field'];
} while ($row_table_lie_per = mysql_fetch_assoc($table_lie_per));
?>
<?php do { ?>
    <?php $xml .= '<LIE_PER>'; ?>
    <?php
	for($u = 0; $u < count($colonne_lie_per);$u++)
	{
		$xml .='<'.$colonne_lie_per[$u].'>'.$row_lie_per[$colonne_lie_per[$u]].'</'.$colonne_lie_per[$u].'>';
	}
	?>
    <?php $xml .= '</LIE_PER>'; ?>
    <?php } while ($row_lie_per = mysql_fetch_assoc($lie_per)); ?>
<!-- ******* Traitement lie_doc ******* -->
<?php
do {
	$colonne_lie_doc[] = $row_table_lie_doc['Field'];
} while ($row_table_lie_doc = mysql_fetch_assoc($table_lie_doc));
?>
<?php do { ?>
    <?php $xml .= '<LIE_DOC>'; ?>
    <?php
	for($u = 0; $u < count($colonne_lie_doc);$u++)
	{
		$xml .='<'.$colonne_lie_doc[$u].'>'.$row_lie_doc[$colonne_lie_doc[$u]].'</'.$colonne_lie_doc[$u].'>';
	}
	?>
    <?php $xml .= '</LIE_DOC>'; ?>
    <?php } while ($row_lie_doc = mysql_fetch_assoc($lie_doc)); ?>
<!-- ******* Traitement documentation ******* -->
<?php
do {
	$colonne_documentation[] = $row_table_documentation['Field'];
} while ($row_table_documentation = mysql_fetch_assoc($table_documentation));
?>
<?php do { ?>
    <?php $xml .= '<DOCUMENTATION>'; ?>
    <?php 
	for($u = 0; $u < count($colonne_documentation);$u++)
	{
		$xml .='<'.$colonne_documentation[$u].'>'.$row_documentation[$colonne_documentation[$u]].'</'.$colonne_documentation[$u].'>';
	}
	?>
    <?php $xml .= '</DOCUMENTATION>'; ?>
    <?php } while ($row_documentation = mysql_fetch_assoc($documentation)); ?>
<!-- ******* Traitement doc_per ******* -->
<?php
do {
	$colonne_doc_per[] = $row_table_doc_per['Field'];
} while ($row_table_doc_per = mysql_fetch_assoc($table_doc_per));
?>
<?php do { ?>
    <?php $xml .= '<DOC_PER>'; ?>
    <?php 
	for($u = 0; $u < count($colonne_doc_per);$u++)
	{
		$xml .='<'.$colonne_doc_per[$u].'>'.$row_doc_per[$colonne_doc_per[$u]].'</'.$colonne_doc_per[$u].'>';
	}
	?>
    <?php $xml .= '</DOC_PER>'; ?>
    <?php } while ($row_doc_per = mysql_fetch_assoc($doc_per)); ?>
<!-- ******* Traitement doc_lie ******* -->
<?php
do {
	$colonne_doc_lie[] = $row_table_doc_lie['Field'];
} while ($row_table_doc_lie = mysql_fetch_assoc($table_doc_lie));
?>
<?php do { ?>
    <?php $xml .= '<DOC_LIE>'; ?>
    <?php 
	for($u = 0; $u < count($colonne_doc_lie);$u++)
	{
		$xml .='<'.$colonne_doc_lie[$u].'>'.$row_doc_lie[$colonne_doc_lie[$u]].'</'.$colonne_doc_lie[$u].'>';
	}
	?>
    <?php $xml .= '</DOC_LIE>'; ?>
    <?php } while ($row_doc_lie = mysql_fetch_assoc($doc_lie)); ?>
<?php $xml .= '</PATRIMOINE>'; ?>
<?php
	$fp = fopen("exportAlienorWebLibre.xml", 'w+');
	fputs($fp, $xml);
	fclose($fp);
	echo 'Export XML effectue !<br><a href="exportAlienorWebLibre.xml">Voir le fichier</a>';
?>
<?php
mysql_free_result($table_objet);

mysql_free_result($objet);

mysql_free_result($table_personne);

mysql_free_result($personne);

mysql_free_result($table_lieu);

mysql_free_result($lieu);

mysql_free_result($table_documentation);

mysql_free_result($documentation);

mysql_free_result($table_obj_per);

mysql_free_result($obj_per);

mysql_free_result($table_obj_lie);

mysql_free_result($obj_lie);

mysql_free_result($table_obj_doc);

mysql_free_result($obj_doc);

mysql_free_result($table_obj_ges);

mysql_free_result($obj_ges);

mysql_free_result($table_per_lie);

mysql_free_result($per_lie);

mysql_free_result($table_per_doc);

mysql_free_result($per_doc);

mysql_free_result($table_lie_per);

mysql_free_result($lie_per);

mysql_free_result($table_lie_doc);

mysql_free_result($lie_doc);

mysql_free_result($table_doc_lie);

mysql_free_result($doc_lie);

mysql_free_result($table_doc_per);

mysql_free_result($doc_per);
?>
