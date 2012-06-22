<?php

 require_once('../include/proxy.php');
 require_once('../include/modifTheso.php');
 $monProxy = new Proxy(true,"/alienorweblibre/Connections/pageProxy.php");
 $monTheso = new ModifTheso();

if(!empty($_GET["mediafile"])){
	$request = $_SERVER['REQUEST_URI'];
	$monProxy->mediafile=str_replace("/alienorweblibre/Connections/pageProxy.php?mediafile=","",$request);
	echo $monProxy->getPage();
}else{
	$request = $_SERVER['REQUEST_URI'];
	$monProxy->url=str_replace("/alienorweblibre/Connections/pageProxy.php?url=","",$request);
	//echo $monProxy->toString();
	//echo "<br>juste avant getpage:".$monProxy->url;
	$monTheso->page = $monProxy->getPage();	
	//echo "<br>juste après proxy getpage:<br>".$monTheso->page;
	$monTheso->transforme("Form");
	echo $monTheso->page;
}
?>