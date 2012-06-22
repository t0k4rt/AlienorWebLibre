<?php
class GestionConfig
{
	private $chemin;
	private $nomFichier;
	private $tabParam = array();

	public function __construct($paramNomFichier)
	{
		//construction de l'objet
		//mettre toutes les valeurs du fichier texte dans un tableau
		$this->nomFichier = $paramNomFichier;
		$this->chemin = dirname(__FILE__)."/";
		if(file_exists($this->chemin.$this->nomFichier)){
			$this->tabParam = parse_ini_file($this->chemin.$this->nomFichier);
		}else{
			echo "fichier inexistant";
		}
	}
    
    public function chemin()
    {
		//construction de l'objet
		//mettre toutes les valeurs du fichier texte dans un tableau
		$this->chemin = dirname(__FILE__)."/";
		return $this->chemin.$this->nomFichier;
	}
	
	public function __toString()
	{
		//afficher les valeurs du tableau
		$result = "";
		foreach($this->tabParam as $nom => $valeur)
		{
			$result = $result."<br/>$nom : $valeur";
		}
		return $result;
	}
	
	public function __get($nomValeur)
	{
		//obtenir les valeurs du tableau
		$reponse ="";
		if(isset($this->$nomValeur)){
			$reponse = $this->$nomValeur;
		}else{
			$reponse = $this->tabParam[$nomValeur];
		}
		return $reponse;
	}

	public function __set($nom,$valeur)
	{
		//modifier une valeur du tableau
		if(isset($this->tabParam[$nom])){
			if(isset($this->$nom)){
				$this->$nom=$valeur;
			}else{
				$this->tabParam[$nom]=$valeur;
			}
		}else{
			$this->tabParam=$this->tabParam.$this->tabParam[$nom];
			$this->tabParam[$nom]=addslashes($valeur);
		}
		
		return $this->tabParam[$nom];
	}
}
?>