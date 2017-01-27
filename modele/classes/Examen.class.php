<?php
class Examen{
	private $ID;
	private $EnseignantID; 
	private $ponderation;
	private $titre;

	public function __construct($ID= "", $EnseignantID= "", $ponderation= "", $titre=""){
		$this->ID= $ID;
		$this->EnseignantID= $EnseignantID;
		$this->ponderation= $ponderation;
		$this->titre = $titre;
		$this->disponible = false;
	}

	public function getID()					{return $this->ID;}
	public function getEnseignantID() 		{return $this->EnseignantID;}
	public function getPonderation() 		{return $this->ponderation;}
	public function getTitre() 				{return $this->titre;}
	public function getDisponible()			{return $this->disponible;}

	public function setID($ID) 				{$this->ID = $ID;}
	public function setEnseignantID($EID) 	{$this->EnseignantID = $EID;}
	public function setPonderation($pond) 	{$this->ponderation = $pond;}
	public function setTitre($titre) 		{$this->titre = $titre;}	
	public function setDisponible($dispo) 	{$this->disponible = $dispo;}

	public function loadFromArray($tab)
	{
		$this->ID = $tab["id"];
		$this->EnseignantID = $tab["Enseignantid"];
		$this->ponderation = $tab["ponderation"];
		$this->titre = $tab["titre"];
		$this->disponible = $tab["disponible"];
		return $this;
	}
	public function loadFromObj($obj){
		$this->ID 			= $obj->id;
		$this->EnseignantID = $obj->Enseignantid;
		$this->ponderation	= $obj->ponderation;
		$this->titre		= $obj->titre;
		$this->disponible	= $obj->disponible;
		return $this;
	}
}
?>