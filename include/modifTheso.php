<?php
Class ModifTheso
{
	public $page;

	private $pattern;
	private $replace;
	
	
	public function __construct(){
	}
	
	public function transforme(){
		$nbParam = func_num_args();
		for ($i=0; $i<= $nbParam-1 ; $i++){
			$param = func_get_arg($i);
			switch ((string)$param){
						case "Form" :	$this->pattern = "'window.parent.parent.opener.document.forms\[0\]'";
										$this->replace = "window.parent.parent.opener.document.forms['fiche']";
										$this->page = preg_replace($this->pattern, $this->replace, $this->page);
										$this->pattern = "'window.parent.opener.document.forms\[0\]'";
										$this->replace = "window.parent.opener.document.forms['fiche']";
										$this->page = preg_replace($this->pattern, $this->replace, $this->page);
										$this->pattern = "#,'/ImageBase/AlienorWeb#";
										$this->replace = ",'../Connections/pageProxy.php?mediafile=http://www.alienor.org/ImageBase/AlienorWeb";
										$this->page = preg_replace($this->pattern, $this->replace, $this->page);
										
										break;
						case "FormAJAX" :	$this->pattern = "'window.parent.parent.opener.document.forms\[0\]'";
										$this->replace = "document.forms[1]";
										$this->page = preg_replace($this->pattern, $this->replace, $this->page);
										$this->pattern ="'window.parent.parent.close\(\);'";
										$this->replace = "";
										$this->page = preg_replace($this->pattern, $this->replace, $this->page);
										break;
			}
		}
		$this->pattern ="#ReplaceAll\(val, '\|', '\"'\)#";
		$this->replace ="ReplaceAll(val, '|', '\"');";
		$this->page=preg_replace($this->pattern, $this->replace, $this->page);
		$this->pattern ="#document.domain='alienor.org';#";
		$this->replace ="";
		$this->page=preg_replace($this->pattern, $this->replace, $this->page);
	}

	public function __Set($name, $value){
		$this->$name = $value;
	}
	public function __get($name){
		return $this->$name;
	}

}

?>