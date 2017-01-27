<?php

class Utilisateur{
	private $ID;
	private $nom;
	private $prenom;
	private $pass;
	private $user;
	private $dateCreation;
	private $type;

	public function __construct(
		$ID = "", $nom = "", $prenom = "", $pass = "",
		$user = "", $dateCreation = "", $type = "")	//Constructeur
	{
		$this->ID = $ID;
		$this->nom = $nom;
		$this->prenom = $prenom;
		$this->pass = $pass;
		$this->user = $user;
		$this->dateCreation = $dateCreation;
		$this->type = $type;
	}
	public function loadFromArray($array){
		$this->ID 			= $array[0];
		$this->user 		= $array[1];
		$this->pass 		= $array[2];
		$this->dateCreation = $array[3];
		$this->nom 			= $array[4];
		$this->prenom 		= $array[5];
		$this->type 		= $array[6];
	}
	public function loadFromObj($obj){
		$this->ID 			= $obj->id;
		$this->user 		= $obj->username;
		$this->pass 		= $obj->password;
		$this->dateCreation = $obj->creationDate;
		$this->nom 			= $obj->nom;
		$this->prenom 		= $obj->prenom;
		$this->type 		= $obj->type;
	}

	public function getID()					{return $this->ID;				}
	public function getNom()				{return $this->nom;				}
	public function getPrenom()				{return $this->prenom;			}
	public function getUser()				{return $this->user;				}
	public function getPass()				{return $this->pass;				}
	public function getDateCreation()		{return $this->dateCreation;		}
	public function getUserType()			{return $this->type;				}
	
	public function setID($ID)				{$this->ID = $ID;			}
	public function setNom($nom)			{$this->nom = $nom;		}
	public function setPrenom($prenom)		{$this->prenom = $prenom;	}
	public function setUser($user)			{$this->user = $user;		}
	public function setPass($pass)			{$this->pass = $pass;		}
	//public function setDateCreation($date)	{$this->dateCreation = $date;}
	public function setUserType($type)		{$this->type = $type;		}
}?>