<?php
class ExamenEleve{
	private $examID;
	private $eleveID; 
	private $commentaire;
	private $complet;
	private $corrected;

	public function __construct(
		$examID= "", $eleveID= "",$commentaire= "",
		 $complet = 0, $corrected = 0){
		$this->examID 		= $examID;
		$this->eleveID  	= $eleveID;
		$this->commentaire 	= $commentaire;
		$this->complet  	= $complet;
		$this->corrected  	= $corrected;

	}

	public function getExamID()		{return $this->examID;}
	public function getExamenID()	{return $this->examID;}
	public function getEleveID() 	{return $this->eleveID;}
	public function getCommentaire(){return $this->commentaire;}
	public function getComplet()	{return $this->complet;}
	public function getCorrected()	{return $this->corrected;}

	public function setExamenID($examID) 			{$this->examID = $examID;}
	public function setExamID($examID) 				{$this->examID = $examID;}
	public function setEleveID($EID) 				{$this->eleveID = $EID;}
	public function setCommentaire($commentaire) 	{$this->commentaire = $commentaire;}
	public function setComplet($complet) 			{$this->complet = $complet;}
	public function setCorrected($corrected) 		{$this->corrected = $corrected;}	

	public function loadFromArray($tab)
	{
		$this->examID = $tab["Examenid"];
		$this->eleveID = $tab["Eleveid"];
		$this->commentaire = $tab["commentaire"];
		$this->complet = $tab["complet"];
		$this->corrected = $tab["corrected"];
		return $this;
	}

	public function loadFromObj($obj){
		$this->examID 			= $obj->Examenid;
		$this->eleveID 			= $obj->Eleveid;
		$this->commentaire		= $obj->commentaire;
		$this->complet			= $obj->complet;
		$this->corrected		= $obj->corrected;
		return $this;
	}
}
?>