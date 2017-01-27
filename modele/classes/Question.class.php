<?php

class Question{
	private $ID;
	private $enseignantID;
	private $enonce;
	private $choix;
	private $type;
	private $titre;
	private $reponse;
	
	public function __construct(
		$ID = "", $enseignantID = "", $enonce = "",
		$choix = "", $type = "", $titre = "", $reponse = "")
	{	
		$this->ID = $ID;
		$this->enseignantID = $enseignantID;
		$this->enonce = $enonce;
		$this->choix = $choix;
		$this->type = $type;
		$this->titre = $titre;
		$this->reponse = $reponse;
	}
	public function	setID($ID)				{$this->ID = $ID; 				}
	public function	setEnseignantID($EID)	{$this->enseignantID = $EID; 	}
	public function	setEnonce($enonce)		{$this->enonce = $enonce; 		}
	public function	setChoix($choix)		{$this->choix = $choix; 		}
	public function	setQuestionType($type)	{$this->type = $type; 			}
	public function	setTitre($titre)		{$this->titre = $titre; 		}
	public function	setReponse($reponse)	{$this->reponse = $reponse; 	}

	public function	getID()					{return $this->ID; 				}
	public function	getEnseignantID()		{return $this->enseignantID; 	}
	public function	getEnonce()				{return $this->enonce; 			}
	public function	getChoix()				{return $this->choix; 			}
	public function	getQuestionType()		{return $this->type; 			}
	public function	getTitre()				{return $this->titre; 			}
	public function	getReponse()			{return $this->reponse; 		}

	public function loadFromArray($tab){
		$this->ID			= $tab["id"];
		$this->enseignantID	= $tab["enseignantid"];
		$this->enonce		= $tab["enonce"];
		$this->choix		= $tab["choix"];
		$this->type			= $tab["type"];
		$this->titre		= $tab["titre"];
		$this->reponse		= $tab["reponse"];
		return $this;
	}
	public function loadFromObj($obj){
		$this->ID 			= $obj->id;
		$this->enseignantID = $obj->enseignantid;
		$this->enonce 		= $obj->enonce;
		$this->choix 		= $obj->choix;
		$this->type 		= $obj->type;
		$this->titre 		= $obj->titre;
		$this->reponse 		= $obj->reponse;
		return $this;
	}
}
?>